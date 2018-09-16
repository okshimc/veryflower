<?php
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

$where_sql="where agency_no>0";
if($search_name)
{
	if($search_part)
	{
		$where_sql.=" and $search_part like '%$search_name%'";
	}
	else
	{
		$where_sql.=" and (agency_name like '%$search_name%' or agency_area like '%$search_name%' or agency_phone like '%$search_name%')";
	}
}

if($agency_local) $where_sql.=" and agency_local='$agency_local'";
if($agency_type) $where_sql.=" and agency_type='$agency_type'";

if(!$page) //넘어온 현재 페이지값이 없으면...
{
   $page=1;
}

//한 페이지에 출력되는 레코드의 갯수
$record_set=10;

$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$page_sql="select count(agency_no) from $agency_db $where_sql";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

if($total_record>0) //입력된 게시물이 하나도 없으면...
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

$page_href="agency_local=$agency_local&";
$default_href="$PHP_SELF?$page_href";
$page_arr=page_list(); //페이지 나누기 함수 실행

$sql="select * from $agency_db $where_sql order by agency_sort asc";
$result=mysql_query($sql);
$total_num=mysql_num_rows($result);

if($total_num>0)
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

$i=0;
while($row=mysql_fetch_array($result))
{
	$arr[$i][view_href]="agency_local=$agency_local&part=$part&agency_no=$row[agency_no]&page=$page&search_name=$search_name";

	if($row[agency_type]=="1") $agency_type_msg="홈창업";
	else if($row[agency_type]=="2") $agency_type_msg="배달전용소점포";
	else if($row[agency_type]=="3") $agency_type_msg="해물요리전문점";
	else if($row[agency_type]=="4") $agency_type_msg="해물요리주점";

	if($row[agency_banner])
	{
		$arr[$i][agency_zoom_msg]="<a href=\"javascript:zoom_open('$etc_upload_path/$row[agency_banner]');\"><img src=\"img/map_view.jpg\" border=\"0\"></a>";
	}
	else
	{
		$arr[$i][agency_zoom_msg]="";
	}

	$arr[$i][agency_type]=$agency_type_msg;
	$arr[$i][agency_local]=$row[agency_local];
	$arr[$i][agency_name]=$row[agency_name];
	$arr[$i][agency_area]=$row[agency_area];
	$arr[$i][agency_phone]=$row[agency_phone];
	$arr[$i][agency_site]=$row[agency_site];
	$i++;
}

include("list_agency_main.php");

?>