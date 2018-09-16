<?php
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

$tmp_row[kind_wpower]="1";
$board_title_img1="title_08.gif";
$board_name="방명록";

if($tmp_row[kind_lpower]=="2")
{
	if(!$HTTP_SESSION_VARS[ok_id])
	{
		echo("
			<script language='javascript'>
				alert('회원 로그인후 이용할 수 있습니다.');
				history.back();
			</script>
			");
	}
}

if($tmp_row[kind_lpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('관리자 전용 구역입니다.');
			history.back();
		</script>
		");
}

if(!$page) //넘어온 현재 페이지값이 없으면...
{
   $page=1;
}

//한 페이지에 출력되는 레코드의 갯수
if($tmp_row[kind_gallerycheck]=="1") $record_set=12;
else $record_set=15;

$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$page_sql="select count(comment_no) from incheck_comment";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$cmt_sql="select * from incheck_comment
					where comment_wcode='7'
					order by comment_no desc
					limit $start_record, $record_set";
$cmt_result=mysql_query($cmt_sql);
$cmt_total_num=mysql_num_rows($cmt_result);

$default_href="$PHP_SELF?$page_href";
$page_arr=page_list(); //페이지 나누기 함수 실행

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($cmt_row=mysql_fetch_array($cmt_result))
{
	$k--;
	$cmt_arr[$f]["k"]=$k;
	$cmt_arr[$f]["comment_no"]=trim($cmt_row[comment_no]);
	$cmt_arr[$f]["comment_id"]=trim($cmt_row[comment_id]);
	$cmt_arr[$f]["comment_name"]=trim($cmt_row[comment_name]);
	$cmt_arr[$f]["comment_date"]=trim($cmt_row[comment_date]);
	$cmt_arr[$f]["comment_content"]=stripslashes($cmt_row[comment_content]);

	$f++;
}

include("list_incheck_main.php");

?>
