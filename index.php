<?php 
header("Content-type: text/html; charset=utf-8");

ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Tbilisi");

require 'calendar.php';
$opt = array(
	"addEvents" => true,  
	"temp_files"=>"_temp", 
	"shell_files"=>"_shell", 
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
			"width"=>"100%", 
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
			"font-size"=>"16px", 
			"position"=>"absolute", 
			"bottom"=>"10px", 
			"right"=>"10px",
			"color"=>"#787878"
		),
		"form"=>array(
			"margin"=>"10px 0", 
			"padding"=>"0px"
		),
		"form_title"=>array(
			"margin"=>"0px", 
			"padding"=>"20px 0 0 0",
			"width"=>"100%",
			"display"=>"block", 
			"color"=>"#3c8dbc"
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
		"select"=>array(
			"margin"=>"0px", 
			"padding"=>"0 5px",
			"width"=>"100%",
			"height"=>"30px", 
			"line-height"=>"30px", 
			"color"=>"#787878"
		),
		"options"=>array(
			"#000000"=>"შავი",
			"#ff0000"=>"წითელი" 
		),
		"input_submit"=>array(
			"margin"=>"15px 0 0 0", 
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

$calendar = new calendar($opt);
echo $calendar->show();
?>
