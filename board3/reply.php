<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_tagcheck]=="0")
{
	$notag_check_start="<!--";
	$notag_check_end="-->";
}
if($tmp_row[kind_lockcheck]=="0")
{
	$nolock_check_start="<!--";
	$nolock_check_end="-->";
}

if($tmp_row[kind_appendcheck]=="0")
{
	$noappend_check_start="<!--";
	$noappend_check_end="-->";
}

if($tmp_row[kind_wpower]=="2")
{
	if(!$_SESSION[ok_id])
	{
		echo("
			<script language='javascript'>
				alert('회원 로그인후 이용할 수 있습니다.');
				history.back();
			</script>
			");
	}
}

/*
if($tmp_row[kind_wpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('권한이 없습니다.');
			history.back();
		</script>
		");
}
*/

if($tmp_row[kind_replycheck]=="0")
{
	echo("
		<script language='javascript'>
			alert('답변기능을 사용하지 않는 게시판입니다.');
			history.back();
		</script>
		");
}


$sql="select * from $board_db
				where w_seq='$w_seq'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$href="kind_code=$kind_code&page=$page&w_seq=$w_seq";
$href.="&search_part=$search_part&search_name=$search_name";

$sql="select * from $board_db where w_seq=$w_seq";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

//$row[w_content]=">".str_replace("\n", "\n>", $row[w_content]);
$row[w_content]=
	">===================================\n".
	">제목 : $row[w_title]\n".
	">작성자 : $row[w_name]\n".
	"$row[w_content]\n".
	">===================================\n";

include("reply_main.php");

?>
