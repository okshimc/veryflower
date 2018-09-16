<?php
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");

$sql="select * from $member_db
			where mem_id='$_SESSION[ok_id]'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$phone_array=explode("-", $row[mem_phone]);
$phone1=$phone_array[0];
$phone2=$phone_array[1];
$phone3=$phone_array[2];

include("req_main2.php");

?>
