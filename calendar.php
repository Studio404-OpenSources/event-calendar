<?php
class calendar{
	
	function __construct($opt){
		$this->option = $opt;
		$this->post_request();
		$this->show();
	}
    
    public function show() {    	
    	$this->dayLabels = $this->option['dayLabels'];
    	$this->monthLabel = $this->option['monthLabel'];
    	$this->naviHref = $this->option['slug'];  
         
        if($this->requests('GET','year')){
 			$year = $this->requests('GET','year');
        }else{
            $year = date("Y", time()); 
        }         
         
        if($this->requests('GET','month')){
 			$month = $this->requests('GET','month');
 			if($month > 12){ $month = 12; }
 			if($month <= 0){ $month = 1; }
        }else{
 			$month = date("m",time());
        }                  
         
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->currentDay = 0;
        $this->daysInMonth = $this->daysInMonth($month, $year);  
         
 		$content = sprintf(
 			'<table style="%s" cellpadding="0" cellspacing="1">
 			<tr style="%s">
 			<td colspan="7">%s</td>
 			</tr>
 			<tr>%s</tr>
 			',
 			$this->arrayToStyle($this->option['css']['calendar']), 
 			$this->arrayToStyle($this->option['css']['header']), 
 			$this->createNavi(),
 			$this->createLabels()
 		);

 		$weeksInMonth = $this->weeksInMonth($month,$year);
 		for( $i=0; $i<$weeksInMonth; $i++ ){
 			$content .= '<tr>';
			for($j=1;$j<=7;$j++){
				$content .= $this->showDay($i*7+$j);
			}
			$content .= '</tr>';
		}
		if($this->option['addEvents']){
			$content .= sprintf(
			'<tr>
			<td colspan="7">
			<form action="%s" method="POST" style="%s">
			<label style="%s">ივენთის დამატება</label>
			<label style="%s">თარიღი: ( თვე-დღე-წელი )</label>
			<input type="text" name="calendar_date" value="%s" style="%s" />
			<label style="%s">დასახელება:</label>
			<input type="text" name="calendar_title" value="" style="%s" />
			<label style="%s">ფერი:</label>
			<select style="%s" name="calendar_color">%s</select>
			<input type="submit" name="calendar_submit" value="შენახვა" style="%s" />
			</form>
			</td>
			</tr>',
			$this->option['slug'],
			$this->arrayToStyle($this->option['css']['form']),
			$this->arrayToStyle($this->option['css']['form_title']),
			$this->arrayToStyle($this->option['css']['label']),
			date("m-d-Y"), 
			$this->arrayToStyle($this->option['css']['input_text']), 
			$this->arrayToStyle($this->option['css']['label']),
			$this->arrayToStyle($this->option['css']['input_text']), 
			$this->arrayToStyle($this->option['css']['label']),
			$this->arrayToStyle($this->option['css']['select']),
			$this->arrayToOption($this->option['css']['options']),
			$this->arrayToStyle($this->option['css']['input_submit']) 
			);
		}
 		$content .= '</table>';		

        return $content;   
    }

    private function post_request(){
    	if(
			$this->option['addEvents'] && 
			$this->requests('POST','calendar_date') && 
			$this->requests('POST','calendar_title') && 
			$this->requests('POST','calendar_color') 
		){
			$ck = explode("-", $this->requests('POST','calendar_date'));
			if($ck[1]<=9){ $ck[1] = sprintf("0%s",$ck[1]); }

			if(
				checkdate($ck[0],$ck[1],$ck[2]) 				
			){
				$cdate = sprintf(
					"%s-%s-%s",
					$ck[0],
					$ck[1],
					$ck[2]
				);

				$this->shell(
					"createdir", 
					array(
						$this->option['temp_files'], 
						$cdate
					)
				);

				$this->shell(
					"createfile",  
					array(
						$this->option['temp_files'],
						$cdate,
						$ck[1],
						$this->requests('POST','calendar_title'), 
						$this->requests('POST','calendar_color')
					)
				);

				$this->unsetRequest(array(
					"calendar_date",
					"calendar_title",
					"calendar_color"
				));
			}			
		}
    }

    private function isEnabled($func) {
    	return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
	}

    private function shell($command, $arg = false){
    	if($arg){
	    	$validated = array_map(
				function($arg) { 
					return str_replace(
			    		array(';','|','&','$',' '), 
			    		array(''), 
			    		$arg
			    	);
				},
				$arg
			);
    	}
		if ($this->isEnabled('shell_exec')) {
			switch($command){
				case 'createdir':
					if(is_array($arg) && is_dir($this->option['shell_files']) && is_dir($arg[0])){
						$command = sprintf(
							"sh %s/createdir.sh %s 2>&1",
							$this->option['shell_files'],
							implode(' ', $arg)
						);
						shell_exec($command);						
					}
					break;
				case 'createfile':
					if(is_dir($arg[0])){
						$json = json_encode(array(
							"day"=>$arg[2],
							"title"=>$arg[3],
							"color"=>$arg[4]
						));
						$command = sprintf(
							"sh %s/createfile.sh %s %s %s %s 2>&1",
							$this->option['shell_files'], 
							$arg[0],
							$arg[1], 
							time(), 
							escapeshellarg($json)
						); 
						shell_exec($command);
					}
					break;
			}
		}else{
			die("shell_exec is not enabled !");
		}
    	
    }

    private function getEventsFiles($date){
    	$files = array(); 
    	$dir = sprintf(
    		'%s/%s', 
    		$this->option['temp_files'],
			$date
    	); 
    	// echo $dir."<br/>";
    	if(is_dir($dir)){

    		$command = sprintf(
				"cd %s/%s; ls",
				$this->option['temp_files'],
				$date
			);
	    	$output = shell_exec($command);
	    	if(!empty($output)){
	    		$files = explode(".json", $output);
	    		$files = array_filter(
					array_map(
						'trim', 
						$files
					)
				);
				return $files;
	    	}
    	}
		return false;
    } 

    private function requests($type,$item){
		if($type=="POST" && isset($_POST[$item])){
			return filter_input(INPUT_POST, $item);
		}else if($type=="GET" && isset($_GET[$item])){
			return filter_input(INPUT_GET, $item);
		}else{
			return '';
		}
	}

	private function unsetRequest($item){
		if(is_array($item)){
			foreach ($item as $i) {
				if($this->requests("GET",$i))
					unset($_GET[$i]);
				else if($this->requests("POST",$i))
					unset($_POST[$i]);
			}
		}else{
			if($this->requests("GET",$item))
				unset($_GET[$item]);
			else if($this->requests("POST",$item))
				unset($_POST[$item]);
		}
	}

    private function showDay($cellNumber){
        if($this->currentDay==0){
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
			if(intval($cellNumber) == intval($firstDayOfTheWeek)){
				$this->currentDay = 1;
			}
        }
         
        if(($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)){
			$this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;
        }else{
        	$this->currentDate = null;
        	$cellContent = null;
        }
        $addEventDiv = " ";
        if(!empty($cellContent)){
        	if($cellContent<=9){ $dayf = "0".$cellContent; }
        	else{ $dayf = $cellContent; }
       		$o = $this->currentMonth."-".$dayf."-".$this->currentYear;
       		if(!empty($this->getEventsFiles($o))){
       			$file_array = $this->getEventsFiles($o); 
       			foreach ($file_array as $f) {
       				$file_path = sprintf(
	       				'%s/%s/%s.json',
	       				$this->option['temp_files'], 
	       				$o, 
	       				$f
	       			);
	       			$fileget = json_decode(file_get_contents($file_path),true);
	       			$addEventDiv .= sprintf(
	       				'<span style="%s; background-color:%s">%s</span>',
	       				$this->arrayToStyle($this->option['css']['eventBox']),
	       				$fileget['color'],
	       				$fileget['title']
	       			);
       			}      			
       		}
    	}
        $out = sprintf(
        	'<td style="%s">%s<p style="%s">%s</p></td>',
        	$this->arrayToStyle($this->option['css']['days']),
        	$addEventDiv,
        	$this->arrayToStyle($this->option['css']['days_number']),
        	$cellContent
        );

		return $out;
    }

    private function createNavi(){
		$nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
		$nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
		$preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
		$preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        //$title = date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1'));
        $title = sprintf(
        	'%s %s',
        	$this->currentYear, 
        	$this->monthLabel[(int)$this->currentMonth - 1]
        );
        
        $out = sprintf(
        	'<table width="100&#37;" cellspacing="0" cellpadding="0">
        	<tr>
        	<td width="25&#37;"><a style="%s" href="%s?month=%02d&year=%s">უკან</a></td>
        	<td width="50&#37;"><div style="%s">%s</div></td>
        	<td width="25&#37;"><a style="%s" href="%s?month=%02d&year=%s">წინ</a></td>
        	</tr>
        	</table>',
        	$this->arrayToStyle($this->option['css']['prev']), 
        	$this->naviHref, 
        	$preMonth, 
        	$preYear, 
        	$this->arrayToStyle($this->option['css']['title']), 
        	$title, 
        	$this->arrayToStyle($this->option['css']['next']), 
        	$this->naviHref, 
        	$nextMonth, 
        	$nextYear
        );

        return $out;
    }


    private function createLabels(){  
        $content = '';
        foreach($this->dayLabels as $index => $label){
        	$content .= sprintf(
				'<td style="%s">%s</td>', 
				$this->arrayToStyle($this->option['css']['weekdays']), 
				$label
			);
		}
		return $content;
    }
     
    private function weeksInMonth($month=null,$year=null){
        if(null==($year)){
            $year =  date("Y",time()); 
        }
		
		if(null==($month)) {
			$month = date("m",time());
        }

        $daysInMonths = $this->daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){             
            $numOfweeks++;         
        }
         
        return $numOfweeks;
    }
 

    private function daysInMonth($month=null,$year=null){
        if(null==($year))
            $year =  date("Y",time()); 
 		if(null==($month))
            $month = date("m",time());
        return date('t',strtotime($year.'-'.$month.'-01'));
    }

    private function arrayToStyle($css){
		$output = '';
		try{
			if(is_array($css)){
				$output = implode('; ', array_map(
					function ($v, $k) { return sprintf("%s:%s", $k, $v); },
					$css,
					array_keys($css)
				));
			}
		}catch(Exception $e){
			$this->error[] = sprintf(
				"მოხდა შეცდომა ! <b>%s</b>", 
				$e
			);
		}
		return $output;
	}

	private function arrayToOption($array){
		$output = '';
		try{
			if(is_array($array)){
				$output = implode("",array_map(
					function ($v, $k) { return sprintf("<option value='%s'>%s</option>", $k, $v); },
					$array,
					array_keys($array)
				));
			}
		}catch(Exception $e){
			$this->error[] = sprintf(
				"მოხდა შეცდომა ! <b>%s</b>", 
				$e
			);
		}
		return $output;
	}	
     
}
?>