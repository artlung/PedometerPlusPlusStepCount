<?php
//header('Content-Type: text/plain');

//$csv = file_get_contents('Export.csv');
//$data = str_getcsv($csv, ",", "\"");

$lines = file('Export.csv');

$data = array();

$DATE_FORMAT = "Y-m-d";

$numlines = count($lines);
$startindex = 1;
function parseDate($str) {
	global $DATE_FORMAT;
	return date($DATE_FORMAT,strtotime($str));
}
function parseLine($line) {
	$parsed = explode(',', $line);
	return array(
		'date' => parseDate($parsed[0]),
		'steps' => (int)$parsed[1]
	);
}

$last_date = parseLine($lines[1]);
$first_date = parseLine($lines[$numlines - 1]);

$last_date = $last_date['date'];
$first_date = $first_date['date'];
/*
print_r($first_date);
print "<br>";
print_r($last_date);
print "<br>";
*/
// http://stackoverflow.com/questions/4312439/php-return-all-dates-between-two-dates-in-an-array
function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

$keyDates = createDateRangeArray($first_date, $last_date);


$datesAndSteps = array_fill_keys($keyDates, 0);


for($i=$startindex; $i < $numlines; $i++){

	$line = $lines[$i];
	$obj = parseLine($line);
	
	$datesAndSteps[$obj['date']] = $obj['steps'];

}

$json = array();

$json[] = array('Date', 'Steps');
foreach($datesAndSteps as $k => $v) {
	$json[] = array($k, $v);
}

//print_r($datesAndSteps);

print json_encode($json);