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
<body style="margin:0px; padding:0px">
<?php
$container_width = '100%';
$opt = array(
	"dayLabels" => array("ორშ","სამ","ოთხ","ხუთ","პარ","შაბ","კვი"), 
	"monthLabel" => array("იან","თებ","მარ","აპრ","მაი","ივნ","ივლ","აგვ","სექ","ოქტ","ნოე","დეკ"), 
	"slug"=>"index.php",
	"css"=>array(
		"calendar"=>array(
			"margin"=>"0px auto",
			"padding"=>"0px", 
			"width"=>$container_width, 
			"font-family"=>"serif"
		), 
		"header"=>array(
			"line-height"=>"40px", 
			"position"=>"relative",
			"height"=>"40px", 
			"text-align"=>"center",
			"background-color"=>"#787878"
		),
		"prev"=>array(
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"color"=>"#FFF",
			"float"=>"left",
			"margin-left"=>"10px"
		),
		"title"=>array(
			"margin"=>"0px",
			"padding"=>"0px",
			"color"=>"#FFF",
			"font-size"=>"18px",
			"width"=>"150px",
			"text-align"=>"center",
			"position"=>"absolute",
			"left"=>"calc(50% - 75px)",
			"top"=>"0px",
		),
		"next"=>array(
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"color"=>"#FFF",
			"float"=>"right",
			"margin-right"=>"10px"
		),
		"weekdays"=>array(
			"height"=>"40px", 
			"line-height"=>"40px", 
			"text-align"=>"center", 
			"color"=>"#000", 
			"font-size"=>"15px", 
			"background-color"=>"#f2f2f2"
		),
		"days"=>array(
			"height"=>"80px", 
			"font-size"=>"25px", 
			"background-color"=>"#DDD",
			"color"=>"#000",
			"text-align"=>"center", 
			"position"=>"relative"
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
