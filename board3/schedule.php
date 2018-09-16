<?php
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if(!$iyear)
{
	$iyear  = date("Y");
}
if (!$imonth)
{
    $imonth = date("m");
}
if (!$iday)
{
    $iday  = date("d");
}
if (!$itime)
{
    $itime  = date("H:i:s");
}

$year = sprintf("%04d", $iyear);
$month = sprintf("%02d", $imonth);
$day = sprintf("%02d", $iday);

$maxday = date(t, mktime(0, 0, 0, $month, 1, $year));

$prevmonth = $month - 1;
$nextmonth = $month + 1;
$prevyear = $year;
$nextyear = $year;

if($month == 1)
{
  $prevmonth = 12;
  $prevyear = $year - 1;
}

else if($month == 12)
{
  $nextmonth = 1;
  $nextyear = $year + 1;
}

include("schedule_main.php");

?>