<?php
header("Content-type: text/html; charset=utf-8");
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_lpower]=="2")
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

if($tmp_row[kind_lpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('관리자 전용 구역입니다.');
			history.back();
		</script>
		");
	exit();
}

if($tmp_row[kind_wpower]=="3")
{
	$nowrite_check_start="<!--";
	$nowrite_check_end="-->";
}

if($tmp_row[kind_partcheck]=="1")
{
	/* 분류 추출하기 */
	$part_sql = "select part_code, part_name
							from $board_part_db
							where part_code='$kind_code'
							order by part_no asc";
	$part_result = mysql_query($part_sql, $connect);
	$part_num = mysql_num_rows($part_result);

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

$where_sql="where w_noticeyn='0'";

if(strlen($search_name)>0) //검색어가 있을때 추가할 쿼리문
{
	$where_sql.=" and $search_part like '%$search_name%'";
}
else if(strlen($part)>0) //검색어가 있을때 추가할 쿼리문
{
	$where_sql.=" and w_part='$part'";
}
else //검색어가 없을때 추가할 쿼리문
{
	$where_sql.="";
}

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
if($tmp_row[kind_gallerycheck]=="1") $record_set=12;
else $record_set=10;

$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$page_sql="select count(w_seq) from $board_db $where_sql";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

if($total_record>0) //입력된 게시물이 하나도 없으면...
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

$default_href="$PHP_SELF?$page_href";
$page_arr=page_list(); //페이지 나누기 함수 실행

$orderby_sql="order by w_group desc, w_top asc";

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$sql="select * from $board_db
				$where_sql
				$orderby_sql
				limit $start_record, $record_set";
$result=mysql_query($sql);
$total_num=mysql_num_rows($result);

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($row=mysql_fetch_array($result))
{
	$k--;
	$arr[$f]["k"]=$k;

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

	/*
	//검색어에 배경색 표시
	if($search_name)
	{

		$row[w_title]=preg_replace("/($search_name)/i","<span style=background-color:#3366FF;color:#FFFFFF><b>$1</b></span>",$row[w_title]);
	}

	if(eregi($search_name, $row[w_title]))
	{
		$arr[$f]["layer_showcheck"]="block";
	}
	else
	{
		$arr[$f]["layer_showcheck"]="none";
	}
	*/

	/*
	$cmt_sql="select count(comment_no)
					from $board_comment_db
					where comment_wcode='$kind_code'
					and comment_wseq='$row[w_seq]'
					";
	$cmt_result=mysql_query($cmt_sql, $connect);
	$cmt_row=mysql_fetch_array($cmt_result);

	if($cmt_row[0]>0) $cmt_row_count=" (".$cmt_row[0].")";
	else $cmt_row_count="";

	$arr[$f]["cmt_row_count"]=$cmt_row_count;

	*/

	if($row[w_repnum]>0) $cmt_row_count=" (".$row[w_repnum].")";
	else $cmt_row_count="";

	$arr[$f]["cmt_row_count"]=$cmt_row_count;

	if($tmp_row[kind_appendcheck]=="1")
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
		if($tmp_row[kind_lockcheck]=="1") //잠금기능 사용이면
		{
			$w_title=cut_str($row[w_title], 100);

			if($row[w_lockyn]=="y")
			{
				if($_SESSION[ok_id] && $row[w_id]==$_SESSION[ok_id])
				{
					$w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view.php?$view_href' class=board>$w_title</a>";
				}
				else
				{
					$w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view_passwd.php?$view_href' class=board>$w_title</a>";
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
							$w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view.php?$view_href' class=board>$w_title</a>";
						}
						else
						{
							$w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view_passwd.php?$view_href' class=board>$w_title</a>";
						}
					}
					else
					{
						$w_title="<a href='view.php?$view_href' class=board>$w_title</a>";
					}
				}
				else
				{
					$w_title="<a href='view.php?$view_href' class=board>$w_title</a>";
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
					$w_title="<a href='http://$row[w_email]' class=board target=_blank>$w_title</a>";
				}
				else
				{
					$w_title=cut_str($row[w_title], 100);
					$w_title="<a href='view.php?$view_href' class=board>$w_title</a>";
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
				$w_title="<a href='view.php?$view_href' class=board><strong>$w_title</strong></a>";
			}
			else
			{
				if($tmp_row[kind_gallerycheck]=="1") $w_title=cut_str($row[w_title], 30);
				else $w_title=cut_str($row[w_title], 100);
				$w_title="<a href='view.php?$view_href' class=board>$w_title</a>";
			}
		}
	}
	else
	{
		$w_title="삭제된 게시물입니다.";
	}

	if($tmp_row[kind_appendcheck]=="1")
	{
		if($file_row[file_regname])
		{
			$w_pds_icon=select_icon("$board_upload_dir/$file_row[file_path]", $file_row[file_regname]);
			$w_fileimg="<img src='board_img/$w_pds_icon' border='0' align='absmiddle'>";
			
			if($tmp_row[kind_lockcheck]=="1" && $row[w_lockyn]=="y")
			{
				$arr[$f]["w_fileimg"]="<img src='board_img/$w_pds_icon' border='0' align='absmiddle'>";
			}
			else
			{
				$arr[$f]["w_fileimg"]="<a href='down.php?kind_code=$kind_code&w_seq=$row[w_seq]'>$w_fileimg</a>";
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

	if($row[w_part] && $tmp_row[kind_partcheck]=="1" && $row[w_step]=="0")
	{
		$part_title_msg="[".$row[w_part]."]";
		$w_title=$part_title_msg." ".$w_title;
	}

	if($tmp_row[kind_gallerycheck]=="1")
	{
		$cont_sql="select w_content
					from $board_db
					where w_seq='$row[w_seq]'";
		$cont_result=mysql_query($cont_sql);
		$cont_row=mysql_fetch_array($cont_result);
		$arr[$f][w_content]=cut_str($cont_row[w_content], 500);

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
					$gallery_img_msg="<img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0' align='absmiddle' hspace='5' vspace='5'>";
					$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
				}
				else
				{
					//$new_size=img_resize("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]", $config_img_width, $config_img_height);
					//$img_width=$new_size[0];
					//$img_height=$new_size[1];

					//$encode_filename=urlencode($file_row[file_regname]);
					$encode_filename=$file_row[file_regname];
					$gallery_img_msg="<img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0' align='absmiddle' hspace='5' vspace='5'>";
					$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
				}
			}
		}
		else
		{
			$gallery_img_msg="<img src='$board_upload_path/no_simg.gif' border='0' align='absmiddle' hspace='5' vspace='5' width='$config_img_width'>";
			$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
		}

		if($file_num<1)
		{
			$gallery_img_msg="<img src='$board_upload_path/no_simg.gif' border='0' align='absmiddle' hspace='5' vspace='5' width='100'>";
			$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
		}
		//$arr[$f]["w_fileimg"]=$arr[$f]["gallery_img_msg"];
		$arr[$f]["w_fileimg"]="<a href='view.php?$view_href'>".$arr[$f]["gallery_img_msg"]."</a>";
	}
	else
	{
		$gallery_img_msg="";
		$arr[$f]["gallery_img_msg"]=$gallery_img_msg;
	}

	$arr[$f]["w_title"]=new_icon($row[w_date], $w_title); //new 아이콘 생성 함수

	$f++;
}

//공지글 출력
$notice_sql="select w_seq, w_part, w_name, w_title, w_date, w_read,
					w_group, w_step, w_lockyn
					from $board_db
					where w_noticeyn='1'
					order by w_seq desc";
$notice_result=mysql_query($notice_sql);
$notice_total_num=mysql_num_rows($notice_result);

$f=0;
while($notice_row=mysql_fetch_array($notice_result))
{
	$notice_arr[$f]["k"]="<b>[공지]</b>";

	$view_href="w_seq=$notice_row[w_seq]&page=$page&kind_code=$kind_code";
	if($search_name)
	{
		$view_href.="&search_part=$search_part&search_name=$search_name";
	}
	else if($part)
	{
		$view_href.="&part=$part";
	}

	$notice_arr[$f]["w_name"]=trim($notice_row[w_name]);
	$notice_arr[$f]["w_date"]=substr($notice_row[w_date], 0, 10);
	$notice_arr[$f]["w_seq"]=$notice_row[w_seq];
	$notice_arr[$f]["w_read"]=$notice_row[w_read];

	if(strlen($notice_row[w_title])>0)
	{
		$w_title=cut_str($notice_row[w_title], 100);
		$w_title="<a href='view.php?$view_href' class=board>$w_title</a>";
	}

	$notice_arr[$f]["w_title"]=new_icon($notice_row[w_date], $w_title); //new 아이콘 생성 함수
	$f++;
}

if($notice_total_num>0) //입력된 게시물이 하나도 없으면...
{
	$norecord_check_start="<!--";
	$norecord_check_end="-->";
}

if($tmp_row[kind_gallerycheck]=="1")
{
	if($kind_code==500)
	{
		include("list_gallery_main3.php");
	}
	else
	{
		include("list_gallery_main2.php");
	}
}
else
{
	include("list_main.php");
}

?>
