<?php
header("Content-type: text/html; charset=utf-8");
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");

$page_href="kind_code=$kind_code&";
if($search_name)
{
	$page_href.="search_part=$search_part&search_name=$search_name&";
}
else if($part)
{
	$page_href.="part=$part&";
}

if(!$page) //넘어온 현재 페이지값이 없으면...
{
   $page=1;
}

//한 페이지에 출력되는 레코드의 갯수
$record_set=10;

$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

$where_sql="where w_noticeyn='0'";
if(strlen($search_name)>0) $where_sql.=" and w_title like '%$search_name%' ";

$orderby_sql="order by w_group desc, w_top asc";

$sql.=" (select * from board_1 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_2 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_3 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_4 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_5 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_6 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_7 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_8 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_9 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_10 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_11 $where_sql $orderby_sql) ";
$sql.=" union all ";
$sql.=" (select * from board_12 $where_sql $orderby_sql) ";

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$result=mysql_query($sql);
$total_record=mysql_num_rows($result); //총 레코드의 갯수

$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

if($total_record>0) //입력된 게시물이 하나도 없으면...
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

$default_href="$PHP_SELF?$page_href";
$page_arr=page_list_pagei(); //페이지 나누기 함수 실행

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$sql=$sql." limit $start_record, $record_set";
$result=mysql_query($sql);
$total_num=mysql_num_rows($result);

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($row=mysql_fetch_array($result))
{
	$k--;
	$arr[$f]["k"]=$k;
	$kind_code=$row[w_code];
	$board_db="board_".$kind_code;

	$view_href="w_seq=$row[w_seq]&page=$page&kind_code=$kind_code";
	if($search_name)
	{
		$view_href.="&search_part=$search_part&search_name=$search_name";
	}
	else if($part)
	{
		$view_href.="&part=$part";
	}

	$arr[$f]["view_href"]=$view_href;
	$arr[$f]["w_name"]=trim($row[w_name]);
	$arr[$f]["w_date"]=substr($row[w_date], 0, 10);
	$arr[$f]["w_seq"]=$row[w_seq];
	$arr[$f]["w_read"]=$row[w_read];
	$arr[$f]["w_email"]=$row[w_email];
	$arr[$f]["w_content"]=cut_str(strip_tags($row[w_content]), 500);

	$kind_sql="select * from $board_kind_db
								where kind_code='$kind_code'";
	$kind_result=mysql_query($kind_sql, $connect);
	$kind_row=mysql_fetch_array($kind_result);
	$arr[$f]["kind_name"]=$kind_row[kind_name];

	$board_upload_dir=$_SERVER["DOCUMENT_ROOT"].$kind_row[kind_updir];
	$board_upload_path=$kind_row[kind_updir];

	if($row[w_repnum]>0) $cmt_row_count=" (".$row[w_repnum].")";
	else $cmt_row_count="";

	$arr[$f]["cmt_row_count"]=$cmt_row_count;

	if($kind_row[kind_appendcheck]=="1")
	{
		$file_sql="select * from $board_file_db
							where file_wcode='$kind_code'
							and file_wseq='$row[w_seq]'
							and file_sequence='0'";
		$file_result=mysql_query($file_sql, $connect);
		$file_row=mysql_fetch_array($file_result);
	}

	if(strlen($row[w_title])>0)
	{
		if($kind_row[kind_lockcheck]=="1") //잠금기능 사용이면
		{
			$w_title=cut_str($row[w_title], 100);

			if($row[w_lockyn]=="y")
			{
				if($_SESSION[ok_id] && $row[w_id]==$_SESSION[ok_id])
				{
					$w_title="<img src='board_img/lock.gif' align='absmiddle'> $w_title";
				}
				else
				{
					$w_title="<img src='board_img/lock.gif' align='absmiddle'> $w_title";
				}
			}
			else
			{
				if($row[w_step]>0)
				{
					$lock_sql="select w_id, w_lockyn from $board_db where w_seq='$row[w_group]'";
					$lock_result=mysql_query($lock_sql, $connect);
					$lock_row=mysql_fetch_array($lock_result);

					if($lock_row[w_lockyn]=="y")
					{
						if($_SESSION[ok_id] && $lock_row[w_id]==$_SESSION[ok_id])
						{
							$w_title="<img src='board_img/lock.gif' align='absmiddle'> $w_title";
						}
						else
						{
							$w_title="<img src='board_img/lock.gif' align='absmiddle'> $w_title";
						}
					}
				}
			}
		}
		else //잠금기능 사용이 아니면...
		{
			if($kind_code==100)
			{
				if($row[w_email])
				{
					$w_title=cut_str($row[w_title], 100);
				}
				else
				{
					$w_title=cut_str($row[w_title], 100);
				}
			}
			else if($kind_code==500)
			{
				$w_title=cut_str($row[w_title], 100);
				$cont_sql="select w_content
							from $board_db
							where w_seq='$row[w_seq]'";
				$cont_result=mysql_query($cont_sql);
				$cont_row=mysql_fetch_array($cont_result);
				$arr[$f][w_content]=$cont_row[w_content];
				$w_title=cut_str($row[w_title], 100);
			}
			else
			{
				if($kind_row[kind_gallerycheck]=="1") $w_title=cut_str($row[w_title], 30);
				else $w_title=cut_str($row[w_title], 100);
			}
		}
	}
	else
	{
		$w_title="삭제된 게시물입니다.";
	}

	if($kind_row[kind_appendcheck]=="1")
	{
		if($file_row[file_regname])
		{
			$w_pds_icon=select_icon("$board_upload_dir/$file_row[file_path]", $file_row[file_regname]);
			$w_fileimg="<img src='board_img/$w_pds_icon' border='0' align='absmiddle'>";
			
			if($kind_row[kind_lockcheck]=="1" && $row[w_lockyn]=="y")
			{
				$arr[$f]["w_fileimg"]="<img src='board_img/$w_pds_icon' border='0' align='absmiddle'>";
			}
			else
			{
				$arr[$f]["w_fileimg"]=$w_fileimg;
			}
		}
		else
		{
			$arr[$f]["w_fileimg"]="<img src='board_img/nothing.gif' border='0' align='absmiddle'>";
		}
	}

	if($row[w_step]>0) //답변글이면 제목앞에 아이콘 달기
	{
		$w_title="└[re]".$w_title;

		for($i=0; $i<$row[w_step]; $i++)
		{
			$w_title="&nbsp;&nbsp;".$w_title;
		}
	}

	if($row[w_part] && $kind_row[kind_partcheck]=="1" && $row[w_step]=="0")
	{
		$part_title_msg="[".$row[w_part]."]";
		$w_title=$part_title_msg." ".$w_title;
	}

	if($kind_row[kind_gallerycheck]=="1")
	{
		$file_sql="select * from $board_file_db
						where file_wcode='$kind_code'
						and file_wseq='$row[w_seq]'
						and file_sequence='0'";
		$file_result=mysql_query($file_sql, $connect);
		$file_num=mysql_num_rows($file_result);
		$file_row=mysql_fetch_array($file_result);

		if($file_row[file_regname])
		{
			if(file_exists("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]"))
			{
				$gallery_img_msg=$file_row[file_regname];
			}
		}

		$img_width=$config_img_width;
		$img_height=$config_img_height;

		if($file_row[file_regname])
		{
			if(file_exists("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]"))
			{
				if(file_exists($board_upload_dir."/".$file_row[file_path]."/small_".$file_row[file_regname]))
				{
					//$new_size=img_resize($board_upload_dir."/".$file_row[file_path]."/small_".$file_row[file_regname], $config_img_width, $config_img_height);
					//$img_width=$new_size[0];
					//$img_height=$new_size[1];

					//$encode_filename=urlencode("small_".$file_row[file_regname]);
					$encode_filename="small_".$file_row[file_regname];
					$gallery_img_msg="<img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0'>";
					$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
				}
				else
				{
					//$new_size=img_resize("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]", $config_img_width, $config_img_height);
					//$img_width=$new_size[0];
					//$img_height=$new_size[1];

					//$encode_filename=urlencode($file_row[file_regname]);
					$encode_filename=$file_row[file_regname];
					$gallery_img_msg="<img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0'>";
					$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
				}
			}
		}
		else
		{
			$gallery_img_msg="";
			$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
		}

		if($file_num<1)
		{
			$gallery_img_msg="";
			$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
		}
		//$arr[$f]["w_fileimg"]=$arr[$f]["gallery_img_msg"];
	}
	else
	{
		$gallery_img_msg="";
		$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
	}

	$arr[$f]["w_title"]=$w_title;

	$f++;
}

?>
<? include "../include/topmenu.php"; ?>

<style type="text/css">
/* paging */
.list_number{padding-top:25px; text-align:center;}
.list_n_menu {padding:3px; MARGIN:3px; TEXT-ALIGN: center}
.list_n_menu A {padding:5px 8px 4px 8px; MARGIN: 2px; BORDER: #ccc 1px solid; COLOR: #999; TEXT-DECORATION: none; }
.list_n_menu A:hover {BORDER:#999 1px solid; COLOR: #666;}
.list_n_menu A:active {BORDER:#999 1px solid; COLOR: #666;}
.list_n_menu .current {BORDER: #00b866 1px solid; padding:5px 8px 4px 8px; FONT-WEIGHT: bold; MARGIN: 2px; COLOR: #00854a;}
.list_n_menu .disabled {BORDER: #eee 1px solid; padding:5px 8px 4px 8px; MARGIN: 2px; COLOR: #ddd;} 
</style>

<div class="subContTitleWrap">
	<h4 class="subContTitle"><strong>'<?=$search_name?>'</strong>에 대한 <strong><?=number_format($total_record)?>건</strong>의 검색 결과가 있습니다.</h4>
</div>

<!-- subContent -->
<div class="subContent non_bor" >

	<link rel="stylesheet" href="/style/style_bod.css" />

	<table id="NewsBoardType1" summary="뉴스게시판입니다.">
		<caption></caption>
		<colgroup>
		<col width="50%" />
		<col width="50%" />
	</colgroup>

	<thead>
		<td>총 <strong><?=number_format($total_record)?></strong>건</td>
		<td class="right"></td>
	</thead>

	<tbody>

		<!-- 이미지가 있을때 -->
		<?php for($i=0; $i<$total_num; $i++):?>
		<tr>
			<td colspan="2"<?php if(!$arr[$i]["gallery_img_msg"]){?> class="noImage"<?php }?>>
				<a href="view.php?<?=$arr[$i]["view_href"]?>">
					<?=$arr[$i]["gallery_img_msg"]?>
					<span class="text">
						<span class="title">
							<font class="gang">[<?=$arr[$i]["kind_name"]?>]</font> <!-- 검색된 게시판명의 상위 메뉴명 > 검색된 게시판명 -->
							<?=$arr[$i]["w_title"]?>
						</span>
						<span class="SimpleText"><?=$arr[$i]["w_content"]?></span>
						<!-- 내용을 간략하게 TEXT로 보여주기 html은 제거 오직 텍스트만 내용 글자수 자르기 -->
						<span class="Info">작성자 : <?=$arr[$i]["w_name"]?> | <?=$arr[$i]["w_date"]?> | 조회수 : <?=$arr[$i]["w_read"]?></span>
					</span>
				</a>
			</td>
		</tr>
		<?php endfor;?>
		<!-- //이미지가 있을때 -->

	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
    <div class="list_number">
       <p>
       <div class="list_n_menu">
       <?=$page_arr["first1"]?>
       <  맨처음
       <?=$page_arr["first2"]?>
       
       <?=$page_arr["prev1"]?>
       <  이전
       <?=$page_arr["prev2"]?>
       <?=$page_arr["list"]?>
       <?=$page_arr["next1"]?>
       다음  >
       <?=$page_arr["next2"]?>
       
       <?=$page_arr["end1"]?>
       마지막  >
       <?=$page_arr["end2"]?>
       </div>
       </p>
 </div>
			</td>
		</tr>
	</tfoot>
</table>

</div>
<!-- //subContent -->

<? include "../include/bottom.php"; ?>
