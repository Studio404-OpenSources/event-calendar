<?php 
header('Content-type: text/html; charset=utf-8');

/* Set Default Time Zone */
date_default_timezone_set("Asia/Tbilisi");

/* Require Calendar Class */
require_once 'studio404_calendar.php';
$main_options = array(
	"addEvents"=>true,  
	"deleteEvents"=>true,  
	"temp_files"=>"_temp", 
	"shell_files"=>"_shellx", 
	"slug"=>"index.php",
	"dayLabels"=>array(
		"ორშ",
		"სამ",
		"ოთხ",
		"ხუთ",
		"პარ",
		"შაბ",
		"კვი"
	), 
	"monthLabel"=>array(
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
	), 
	"colors"=>array(
		"#F44336"=>"ფერი #F44336",
		"#E91E63"=>"ფერი #E91E63",
		"#9C27B0"=>"ფერი #9C27B0",
		"#03A9F4"=>"ფერი #03A9F4",
		"#009688"=>"ფერი #009688"
	)
);

$studio404_calendar = new studio404_calendar($main_options);
echo $studio404_calendar->show();
?>