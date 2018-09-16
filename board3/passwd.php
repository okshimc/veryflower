<?php
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_wpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('권한이 없습니다.');
			history.back();
		</script>
		");
}

include("passwd_main.php");
?>
