<?php
class calendar{
    
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;

    private function requests($type,$item){
		if($type=="POST" && isset($_POST[$item])){
			return filter_input(INPUT_POST, $item);
		}else if($type=="GET" && isset($_GET[$item])){
			return filter_input(INPUT_GET, $item);
		}else{
			return '';
		}
	}
    
    public function show($opt) {
    	$this->option = $opt;
    	$this->dayLabels = $this->option['dayLabels'];
    	$this->monthLabel = $this->option['monthLabel'];
    	$this->naviHref = $this->option['slug'];    	
                
        $month = null;
         
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
        $this->daysInMonth = $this->_daysInMonth($month, $year);  
         
 		$content = sprintf(
 			'<table style="%s">
 			<tr style="%s">
 			<td colspan="7">%s</td>
 			</tr>
 			',
 			$this->arrayToStyle($this->option['css']['calendar']), 
 			$this->arrayToStyle($this->option['css']['header']), 
 			$this->_createNavi()
 		);


 		$content .= sprintf(
 			'<tr>%s</tr>',
 			$this->_createLabels()
 		);

 		$weeksInMonth = $this->_weeksInMonth($month,$year);

 		$f = 1;
 		for( $i=0; $i<$weeksInMonth; $i++ ){
 			$content .= '<tr>';
			for($j=1;$j<=7;$j++){
				$content .= $this->_showDay($i*7+$j);
			}
			$content .= '</tr>';
		}


 		$content .= sprintf(
 			'</table>'
 		);
		

        return $content;   
    }

    private function _showDay($cellNumber){
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

    private function _createNavi(){
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
        	'<a style="%s" href="%s?month=%02d&year=%s">უკან</a>
        	<div style="%s">%s</div>
        	<a style="%s" href="%s?month=%02d&year=%s">წინ</a>',
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


    private function _createLabels(){  
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
     
    private function _weeksInMonth($month=null,$year=null){
        if(null==($year)){
            $year =  date("Y",time()); 
        }
		
		if(null==($month)) {
			$month = date("m",time());
        }

        $daysInMonths = $this->_daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){             
            $numOfweeks++;         
        }
         
        return $numOfweeks;
    }
 

    private function _daysInMonth($month=null,$year=null){
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