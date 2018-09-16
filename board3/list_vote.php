<?php
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");

if(strlen($search_name)>0)
{
	$where_sql="where $search_part like '%$search_name%'";
}
else
{
	$where_sql="";
}

$orderby_sql="order by vote_no desc";

if(!$page) //넘어온 현재 페이지값이 없으면...
{
   $page=1;
}

//한 페이지에 출력되는 레코드의 갯수
if($tmp_row[kind_gallerycheck]=="1") $record_set=12;
else $record_set=10;

$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기 위한 기초작업) */
$page_sql="select count(vote_no) from $vote_db $where_sql";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

if($total_record>0) //입력된 게시물이 하나도 없으면...
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

$default_href="$PHP_SELF?search_part=$search_part&search_name=$search_name&";
$page_arr=page_list(); //페이지 나누기 함수 실행

$k=($total_record-$record_set*($page-1))+1; //임시 일련번호

$sql="select vote_no, vote_question, vote_status,
			vote_startday, vote_endday
			from $vote_db
			$where_sql
			$orderby_sql
			limit $start_record, $record_set";
$result=mysql_query($sql);
$total_num=mysql_num_rows($result);

$i=0;
$k=($total_record-$record_set*($page-1))+1;
while($row=mysql_fetch_array($result))
{
	$k--; //임시 일련번호 증가
	$arr[$i]["k"]=$k;

	$view_href="vote_no=$row[vote_no]&page=$page";

	if($search_name)
	{
		$view_href.="&search_part=$search_part&search_name=$search_name";
	}

	switch($row[vote_status])
	{
		case "0" :
			$arr[$i][vote_status]="대기중";
		break;

		case "1" :
			$arr[$i][vote_status]="진행중";
		break;

		case "2" :
			$arr[$i][vote_status]="종료됨";
		break;
	}

	$arr[$i][vote_no]=$row[vote_no];
	$arr[$i][vote_question]="<a href='view_vote.php?$view_href'>".cut_str($row[vote_question], 36)."</a>";
	$arr[$i][vote_startday]=$row[vote_startday];
	$arr[$i][vote_endday]=$row[vote_endday];

	$i++;
}

include("list_vote_main.php");

?>
