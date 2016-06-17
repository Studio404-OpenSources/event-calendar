<?php 
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("Asia/Tbilisi");

/* Require Calendar Class */
require_once 'studio404_calendar.php';
$main_options = array(
	"addEvents" => true,  
	"deleteEvents" => true,  
	"temp_files"=>"_temp", 
	"shell_files"=>"_shellx", 
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
	"colors"=>array(
		"#000000"=>"შავი",
		"#ff0000"=>"წითელი", 
		"green"=>"მწვანე"
	),
	"lang"=>array(
		"prevTitle"=>"უკან",
		"nextTitle"=>"წინ",
		"addEvent"=>"ივენთის დამატება", 
		"date"=>"თარიღი", 
		"dateFormat"=>"თვე-დღე-წელი", 
		"addEventTitle"=>"დასახელება", 
		"color"=>"ფერი", 
		"submitTitle"=>"შენახვა",
		"deleteEventQuestion"=>"გნებავთ წაშალოთ ივენთი ?",
		"dateFormatErrorMsg"=>"გთხოვთ გადაამოწმოთ თარიღის ფორმატი !",
		"errorMsg"=>"მოხდა შეცდომა !"
	)
);

$studio404_calendar = new studio404_calendar($main_options);
echo $studio404_calendar->show();
?>
