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
$container_width = 740;
$opt = array(
	"dayLabels" => array("ორშ","სამ","ოთხ","ხუთ","პარ","შაბ","კვი"), 
	"monthLabel" => array("იან","თებ","მარ","აპრ","მაი","ივნ","ივლ","აგვ","სექ","ოქტ","ნოე","დეკ"), 
	"slug"=>"index.php",
	"css"=>array(
		"calendar"=>array(
			"margin"=>"0px auto",
			"padding"=>"0px", 
			"width"=>$container_width."px", 
			"font-family"=>"serif"
		), 
		"box"=>array(
			"position"=>"relative",
			"top"=>"0px",
			"left"=>"0px", 
			"width"=>$container_width."px",
			"height"=>"40px", 
			"background-color"=>"#787878"
		),
		"header"=>array(
			"line-height"=>"40px", 
			"vertical-align"=>"middle", 
			"position"=>"absolute",
			"left"=>"11px", 
			"top"=>"0px",
			"width"=>"calc(100% - 20px)", 
			"height"=>"40px", 
			"text-align"=>"center"
		),
		"prev"=>array(
			"position"=>"absolute", 
			"top"=>"0px",
			"height"=>"17px", 
			"display"=>"block",
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"color"=>"#FFF",
			"left"=>"0px"
		),
		"title"=>array(
			"color"=>"#FFF",
			"font-size"=>"18px"
		),
		"next"=>array(
			"position"=>"absolute", 
			"top"=>"0px",
			"height"=>"17px", 
			"display"=>"block",
			"cursor"=>"pointer",
			"text-decoration"=>"none",
			"color"=>"#FFF",
			"right"=>"0px"
		),
		"box-content"=>array(
			"border"=>"1px solid #787878", 
			"border-top"=>"none",
			"width"=>$container_width."px"
		),
		"ul"=>array(
			"float"=>"left", 
			"margin"=>"0px",
			"padding"=>"10px 20px 5px 20px",
			"list-style-type"=>"none"
		), 
		"li"=>array(
			"margin"=>"1px",
			"padding"=>"0px",
			"float"=>"left",
			"float"=>"left",
			"width"=>"98px", 
			"height"=>"40px", 
			"line-height"=>"40px", 
			"text-align"=>"center", 
			"color"=>"#000", 
			"font-size"=>"15px", 
			"background-color"=>"#f2f2f2"
		),
		"dates_ul"=>array(
			"float"=>"left", 
			"margin"=>"5px 20px 10px 20px",
			"padding"=>"0px",
			"list-style-type"=>"none"
		),
		"dates_li"=>array(
			"margin"=>"1px", 
			"padding"=>"0px", 
			"float"=>"left",
			"width"=>"98px", 
			"min-height"=>"80px", 
			"font-size"=>"25px", 
			"background-color"=>"#DDD",
			"color"=>"#000",
			"text-align"=>"center", 
			"position"=>"relative"
		),
		"dates_p"=>array(
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
