<?php
class calendar{
    
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    
    public function show($opt) {
    	$this->option = $opt;
    	$this->dayLabels = $this->option['dayLabels'];
    	$this->monthLabel = $this->option['monthLabel'];
    	$this->naviHref = $this->option['slug'];    	
        
        $year = null;         
        $month = null;
         
        if(null == $year && isset($_GET['year'])){
 			$year = $_GET['year'];
        }else if(null == $year){
            $year = date("Y",time());  
   		}          
         
        if(null == $month && isset($_GET['month'])){
 			$month = $_GET['month'];
 			if($month > 12){ $month = 12; }
 			if($month <= 0){ $month = 1; }
        }else if(null == $month){
 			$month = date("m",time());
        }                  
         
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->daysInMonth = $this->_daysInMonth($month, $year);  
         
 
		$content = sprintf(
			'<div style="%s">
			<div style="%s">%s</div>
			<div style="%s">
			<ul style="%s">%s</ul>
			<div style="%s"></div>
			<ul style="%s">', 
			$this->arrayToStyle($this->option['css']['calendar']), 
			$this->arrayToStyle($this->option['css']['box']), 
			$this->_createNavi(), 
			$this->arrayToStyle($this->option['css']['box-content']),
			$this->arrayToStyle($this->option['css']['ul']),
			$this->_createLabels(),
			$this->arrayToStyle($this->option['css']['clear']),
			$this->arrayToStyle($this->option['css']['dates_ul'])			
		);
        $weeksInMonth = $this->_weeksInMonth($month,$year);
		
		for( $i=0; $i<$weeksInMonth; $i++ ){
			for($j=1;$j<=7;$j++){
				$content .= $this->_showDay($i*7+$j);
			}
		}

        $content .= sprintf(
        	'</ul><div style="%s"></div></div></div>',
        	$this->arrayToStyle($this->option['css']['clear'])
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
        	'<li style="%s"><p style="%s">%s</p></li>',
        	$this->arrayToStyle($this->option['css']['dates_li']),
        	$this->arrayToStyle($this->option['css']['dates_p']),
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
        	'<div style="%s">
        	<a style="%s" href="%s?month=%02d&year=%s">უკან</a>
        	<span style="%s">%s</span>
        	<a style="%s" href="%s?month=%02d&year=%s">წინ</a>
        	</div>',
        	$this->arrayToStyle($this->option['css']['header']), 
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
				'<li style="%s">%s</li>', 
				$this->arrayToStyle($this->option['css']['li']), 
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