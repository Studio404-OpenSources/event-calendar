<?php 
/* require file */
date_default_timezone_set("Asia/Tbilisi");
require 'calendar.php';
?>
<!DOCTYPE>
<html lang="ge">
<head>
<meta charset="utf-8" />
<title>Calendar</title>
<style type="text/css">
 
:focus{
    outline:none;
}
 
.clear{
    clear:both;
}
</style>
</head>
<body>
<?php
$container_width = '100%';
$opt = array(
	"addEvents" => true,  
	"dayLabels" => array(
		"ორშ",
		"სამ",
		"ოთხ",
		"ხუთ",
		"პარ",
		"შაბ",
		"კვი"
	), 
	"monthLabel" => array(
		"იანვარი",
		"თებერვალი",
		"მარტი",
		"აპრილი",
		"მაისი",
		"ივნისი",
		"ივლისი",
		"აგვისტო",
		"სექტემბერი",
		"ოქტომბერი",
		"ნოემბერი",
		"დეკემბერი"
	), 
	"slug"=>"index.php",
	"css"=>array(
		"calendar"=>array(
			"margin"=>"0px auto",
			"padding"=>"0px", 
			"width"=>$container_width, 
			"font-family"=>"serif", 
			"border-top"=>"solid 4px #3c8dbc"
		), 
		"header"=>array(
			"line-height"=>"60px", 
			"position"=>"relative",
			"height"=>"40px", 
			"text-align"=>"center",
		),
		"prev"=>array(
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"float"=>"left",
			"margin-left"=>"10px", 
			"color"=>"#787878"
		),
		"title"=>array(
			"margin"=>"0px",
			"padding"=>"0px",
			"color"=>"#787878",
			"text-align"=>"center",
		),
		"next"=>array(
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"color"=>"#787878",
			"float"=>"right",
			"margin-right"=>"10px"
		),
		"weekdays"=>array(
			"height"=>"40px", 
			"line-height"=>"40px", 
			"text-align"=>"center", 
			"color"=>"#ffffff", 
			"font-size"=>"14px", 
			"background-color"=>"#3c8dbc"
		),
		"days"=>array(
			"height"=>"80px", 
			"font-size"=>"25px", 
			"background-color"=>"#ffffff",
			"color"=>"#000",
			"text-align"=>"center", 
			"position"=>"relative",
			"border"=>"solid 1px #dddddd"
		),
		"days_number"=>array(
			"margin"=>"0px", 
			"padding"=>"0px", 
			"width"=>"20px", 
			"height"=>"20px", 
			"height"=>"20px", 
			"font-size"=>"14px", 
			"position"=>"absolute", 
			"bottom"=>"10px", 
			"right"=>"10px"
		),
		"form"=>array(
			"margin"=>"10px 0", 
			"padding"=>"0px"
		),
		"label"=>array(
			"margin"=>"0px", 
			"padding"=>"10px 0px",
			"width"=>"100%",
			"display"=>"block", 
			"color"=>"#787878"
		),
		"input_text"=>array(
			"margin"=>"0px", 
			"padding"=>"0 5px",
			"width"=>"100%",
			"height"=>"30px", 
			"color"=>"#787878"
		),
		"input_submit"=>array(
			"margin"=>"10px 0 0 0", 
			"padding"=>"10px 20px",
			"border"=>"0px",
			"cursor"=>"pointer",
			"background-color"=>"#3c8dbc",
			"color"=>"#ffffff"
		),
		"clear"=>array(
			"clear"=>"both"
		)
	)
);
/*

*/
$calendar = new calendar();
echo $calendar->show($opt);
?>
</body>
</html>
