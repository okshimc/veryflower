<?php
header("Content-type: text/html; charset=utf-8");
session_cache_limiter("");
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
		exit();
	}
}

if($tmp_row[kind_wpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('권한이 없습니다.');
			history.back();
		</script>
		");
	exit();
}


$sql="select * from $board_db
				where w_seq='$w_seq'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$href="kind_code=$kind_code&page=$page&w_seq=$w_seq";
$href.="&search_part=$search_part&search_name=$search_name";

if($row[w_tagyn]=="y")
{
	$tagyn_check_js="
		<script language='javascript'>
			document.board_form.tagyn[1].checked=true;
		</script>
		";
}
else
{
	$tagyn_check_js="
		<script language='javascript'>
			document.board_form.tagyn[0].checked=true;
		</script>
		";
}

if($row[w_lockyn]=="y")
{
	$lockyn_check_js="
		<script language='javascript'>
			document.board_form.lockyn.checked=true;
		</script>
		";
}
else
{
	$lockyn_check_js="
		<script language='javascript'>
			document.board_form.lockyn.checked=false;
		</script>
		";
}

if($tmp_row[kind_partcheck]=="1" && $row[w_step]=="0")
{
	/* 분류 추출하기 */
	$part_sql = "select part_code, part_name
							from $board_part_db
							where part_code='$kind_code'
							order by part_no asc";
	$part_result = mysql_query($part_sql, $connect);

	while($part_row = mysql_fetch_array($part_result))
	{
		if($row[w_part]==$part_row[part_name])
		{
			$part_select_msg.="<option value='$part_row[part_name]' selected>$part_row[part_name]</option>
			";
		}
		else
		{
			$part_select_msg.="<option value='$part_row[part_name]'>$part_row[part_name]</option>
			";
		}
	}
}
else
{
	$nopart_check_start="<!--";
	$nopart_check_end="-->";
}

include("edit_main.php");

?>
