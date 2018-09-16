<?php
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

$tmp_row[kind_wpower]="1";
$board_title_img1="title_08.gif";
$board_name="방명록";

if($tmp_row[kind_wpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('권한이 없습니다.');
			history.back();
		</script>
		");
}

include("passwd_incheck_main.php");
?>
