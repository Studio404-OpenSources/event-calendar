<?php
class calendar{
    
    public function show($opt) {
    	$this->option = $opt;
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
			<label style="%s">თარიღი:</label>
			<input type="text" name="calendar_date" value="%s" style="%s" />
			<label style="%s">დასახელება:</label>
			<input type="text" name="calendar_title" value="" style="%s" />
			<input type="submit" name="calendar_submit" value="შენახვა" style="%s" />
			</form>
			</td>
			</tr>',
			$this->option['slug'],
			$this->arrayToStyle($this->option['css']['form']),
			$this->arrayToStyle($this->option['css']['label']),
			date("d-m-Y"), 
			$this->arrayToStyle($this->option['css']['input_text']), 
			$this->arrayToStyle($this->option['css']['label']),
			$this->arrayToStyle($this->option['css']['input_text']), 
			$this->arrayToStyle($this->option['css']['input_submit']) 
			);
		}
 		$content .= '</table>';		

        return $content;   
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

        $out = sprintf(
        	'<td style="%s"><p style="%s">%s</p></td>',
        	$this->arrayToStyle($this->option['css']['days']),
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

	
     
}
?>