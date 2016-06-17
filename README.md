# Introduction
Event Calendar Module

# Example Url
http://c.404.ge/events_calendar

# Installation
```php 
/* Set Defoult Time Zone */
date_default_timezone_set("Asia/Tbilisi");

/* Require Calendar Class */
require_once 'studio404_calendar.php';
$main_options = array(
	"addEvents" => true, /* You Should allow it for only authorize user */
	"deleteEvents" => true, /* You Should allow it for only authorize user */
	"temp_files"=>"_temp", /* directory where saves json files */
	"shell_files"=>"_shellx", /* dangerous directory 'shell script' */
	"dayLabels" => array(
		"ორშ",
		"სამ",
		"ოთხ",
		"ხუთ",
		"პარ",
		"შაბ",
		"კვი"
	), /* Week days */
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
	), /* Month names */
	"slug"=>"index.php", /* slug Where should event calendar send requests */
	"colors"=>array(
		"#F44336"=>"ფერი #F44336",
		"#E91E63"=>"ფერი #E91E63",
		"#9C27B0"=>"ფერი #9C27B0",
		"#03A9F4"=>"ფერი #03A9F4",
		"#009688"=>"ფერი #009688"
	), /* event label background colors */
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
```