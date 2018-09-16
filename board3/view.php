<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("board_inc/paging_function.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_wpower]=="3")
{
	$nowrite_check_start="<!--";
	$nowrite_check_end="-->";
}

if($tmp_row[kind_replycheck]=="0")
{
	$noreply_check_start="<!--";
	$noreply_check_end="-->";
}

if($tmp_row[kind_rpower]=="2")
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

if($tmp_row[kind_rpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('글보기 권한이 없습니다.');
			history.back();
		</script>
		");
	exit();
}

$view_href="page=$page&kind_code=$kind_code";
if($search_name)
{
	$view_href.="&search_part=$search_part&search_name=$search_name";
}
else if($part)
{
	$view_href.="&part=$part";
}

$sql="select * from $board_db
				where w_seq='$w_seq'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);


if($tmp_row[kind_lockcheck]=="1")
{
	if($_SESSION[ok_id] && $row[w_id]==$_SESSION[ok_id])
	{
		//통과
	}
	else
	{
		$lock_sql="select w_id, w_lockyn from $board_db where w_seq='$row[w_group]' and w_step='0'";
		$lock_result=mysql_query($lock_sql, $connect);
		$lock_row=mysql_fetch_array($lock_result);

		if($_SESSION[ok_id] && $lock_row[w_id]==$_SESSION[ok_id])
		{
			//통과
		}
		else
		{
			include("board_inc/board_view_pwcheck.php");
		}
	}
}

if($row[w_part] && $tmp_row[kind_partcheck]=="1")
{
	$part_title_msg="[".$row[w_part]."]";
}

$sql2="select w_seq, w_part, w_title from $board_db
						where w_seq>'$w_seq'
						order by w_seq asc
						limit 1";
$result2=mysql_query($sql2);
$row2=mysql_fetch_array($result2);
if($row2[w_part] && $tmp_row[kind_partcheck]=="1")
{
	$part_title_msg2="[".$row2[w_part]."]";
}

if(!$row2[w_seq])
{
	$noprev_check_start="<!--";
	$noprev_check_end="-->";
}

$sql3="select w_seq, w_part, w_title from $board_db
						where w_seq<'$w_seq'
						order by w_seq desc
						limit 1";
$result3=mysql_query($sql3);
$row3=mysql_fetch_array($result3);
if($row3[w_part] && $tmp_row[kind_partcheck]=="1")
{
	$part_title_msg3="[".$row3[w_part]."]";
}

if(!$row3[w_seq])
{
	$nonext_check_start="<!--";
	$nonext_check_end="-->";
}

$read_sql="update $board_db set
					w_read=w_read+1
					where w_seq='$w_seq'";
mysql_query($read_sql);

/*
if($tmp_row[kind_tagcheck]=="1")
{
	if($row[w_tagyn]=="y")
	{
		$content=$row[w_content];
	}
	else
	{
		$content=nl2br($row[w_content]);
	}
}
else if($tmp_row[kind_tagcheck]=="0")
{
	$content=htmlspecialchars($row[w_content]);
	$content=nl2br($content);
}
*/

if($row[w_tagyn]=="y")
{
	$content=stripslashes($row[w_content]);
}
else
{
	$content=nl2br($row[w_content]);
}

if($tmp_row[kind_appendcheck]=="1")
{
	$file_sql="select * from $board_file_db
					where file_wcode='$kind_code'
					and file_wseq='$w_seq'
					order by file_sequence asc";
	$file_result=mysql_query($file_sql, $connect);
	$file_num=mysql_num_rows($file_result);

	$f=0;
	$file_preview_name="";
	while($file_row=mysql_fetch_array($file_result))
	{
		if($file_row[file_regname])
		{
			if(file_exists("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]"))
			{
				$arr[$f]["k"]=$f+1;
				$arr[$f]["file_size"]=count_filesize($file_row[file_size]);
				$arr[$f]["file_regname"]=$file_row[file_regname];
				$arr[$f]["file_orgname"]=$file_row[file_orgname];
				$arr[$f]["file_sequence"]=$file_row[file_sequence];

				$file_preview_ext=get_ext($file_row[file_regname]);

				if($file_preview_ext[1]==".gif" || $file_preview_ext[1]==".jpg" || $file_preview_ext[1]==".jpeg" || $file_preview_ext[1]==".bmp")
				{
					$new_size=width_resize("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]", "800");
					$img_width=$new_size[0];
					$img_height=$new_size[1];

					$encode_filename=urlencode($file_row[file_regname]);
					$file_preview_name.="<a href=\"javascript:zoom_open('$board_upload_path/$file_row[file_path]/$encode_filename');\"><img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0' vspace='10'></a><p>";
				}
			}
		}
		$f++;
	}

	if($file_num<1)
	{
		$noappend_check_start="<!--";
		$noappend_check_end="-->";
	}
}
else
{
	$noappend_check_start="<!--";
	$noappend_check_end="-->";
}

if($tmp_row[kind_gallerycheck]=="1")
{
	$file_preview_name="";

	$file_sql="select * from $board_file_db
					where file_wcode='$kind_code'
					and file_wseq='$w_seq'
					order by file_sequence asc";
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

	if($file_row[file_regname])
	{
		if(file_exists("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]"))
		{
			$new_size=width_resize("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]", "800");
			$img_width=$new_size[0];
			$img_height=$new_size[1];

			$encode_filename=urlencode($file_row[file_regname]);
			$arr[$f]["encode_filename"]=$encode_filename;
			$gallery_img_msg="<img src='$board_upload_path/$file_row[file_path]/$encode_filename' width='$img_width' height='$img_height' border='0'><p>";
			$gallery_img_msg="<a href=\"javascript:zoom_open('$board_upload_path/$file_row[file_path]/$encode_filename');\">$gallery_img_msg</a>";
		}
	}
	else
	{
		$gallery_img_msg="<img src='$board_upload_path/no_img.gif' border='0'><p>";
	}

	if($file_num<1)
	{
		$gallery_img_msg="";
		//$nogallery_check_start="<!--";
		//$nogallery_check_end="-->";
	}
}
else
{
	$gallery_img_msg="";
	//$nogallery_check_start="<!--";
	//$nogallery_check_end="-->";
}


############# 하단 게시물 리스트 보기 ####################

if($tmp_row[kind_partcheck]=="1")
{
	/* 분류 추출하기 */
	$list_part_sql = "select part_code, part_name
							from $board_part_db
							where part_code='$kind_code'
							order by part_no asc";
	$list_part_result = mysql_query($list_part_sql, $connect);
	$list_part_num = mysql_num_rows($list_part_result);

	while($list_part_row = mysql_fetch_array($list_part_result))
	{
		if($list_row[w_part]==$list_part_row[part_name])
		{
			$list_part_select_msg.="<option value='$list_part_row[part_name]' selected>$list_part_row[part_name]</option>
			";
		}
		else
		{
			$list_part_select_msg.="<option value='$list_part_row[part_name]'>$list_part_row[part_name]</option>
			";
		}
	}
}
else
{
	$list_nopart_check_start="<!--";
	$list_nopart_check_end="-->";
}

$list_where_sql="where w_noticeyn='0'";

if(strlen($list_search_name)>0) //검색어가 있을때 추가할 쿼리문
{
	$list_where_sql.=" and $list_search_part like '%$list_search_name%'";
}
else if(strlen($list_part)>0) //검색어가 있을때 추가할 쿼리문
{
	$list_where_sql.=" and w_part='$list_part'";
}
else //검색어가 없을때 추가할 쿼리문
{
	$list_where_sql.="";
}

$page_href="kind_code=$kind_code&";
if($list_search_name)
{
	$page_href.="search_part=$list_search_part&search_name=$list_search_name&";
}
else if($list_part)
{
	$page_href.="part=$list_part&";
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

$default_href="list.php?$page_href";
$page_arr=page_list(); //페이지 나누기 함수 실행

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$page_sql="select count(w_seq) from $board_db $list_where_sql";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

if($total_record>0) //입력된 게시물이 하나도 없으면...
{
	$list_norecord_check_start="<!--";
	$list_norecord_check_end="-->";
}

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$list_sql="select w_seq, w_part, w_name, w_title, w_date, w_read,
					w_group, w_step, w_lockyn
					from $board_db
					$list_where_sql
					order by w_group desc, w_top asc
					limit $start_record, $record_set";
$list_result=mysql_query($list_sql);
$list_total_num=mysql_num_rows($list_result);

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($list_row=mysql_fetch_array($list_result))
{
	$k--;
	$list_arr[$f]["k"]=$k;

	$list_view_href="w_seq=$list_row[w_seq]&page=$page&kind_code=$kind_code";
	if($list_search_name)
	{
		$list_view_href.="&search_part=$list_search_part&search_name=$list_search_name";
	}
	else if($list_part)
	{
		$list_view_href.="&part=$list_part";
	}

	$list_arr[$f]["w_name"]=trim($list_row[w_name]);
	$list_arr[$f]["w_date"]=substr($list_row[w_date], 0, 10);
	$list_arr[$f]["w_seq"]=$list_row[w_seq];
	$list_arr[$f]["w_read"]=$list_row[w_read];

	if($tmp_row[kind_appendcheck]=="1")
	{
		$list_file_sql="select * from $board_file_db
							where file_wcode='$kind_code'
							and file_wseq='$list_row[w_seq]'
							and file_sequence='0'";
		$list_file_result=mysql_query($list_file_sql, $connect);
		$list_file_row=mysql_fetch_array($list_file_result);
	}

	if($tmp_row[kind_lockcheck]=="1") //잠금기능 사용이면
	{
		if(strlen($list_row[w_title])>0)
		{
			$list_w_title=cut_str($list_row[w_title], 26);

			if($list_row[w_lockyn]=="y")
			{
				$list_w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view_passwd.php?$list_view_href' class=board>$list_w_title</a>";
			}
			else
			{
				if($list_row[w_step]>0)
				{
					$list_lock_sql="select w_lockyn from $board_db where w_seq='$list_row[w_group]'";
					$list_lock_result=mysql_query($list_lock_sql, $connect);
					$list_lock_row=mysql_fetch_row($list_lock_result);

					if($list_lock_row[0]=="y")
					{
						$list_w_title="<img src='board_img/lock.gif' align='absmiddle'> <a href='view_passwd.php?$list_view_href' class=board>$list_w_title</a>";
					}
					else
					{
						$list_w_title="<a href='view.php?$list_view_href' class=board>$list_w_title</a>";
					}
				}
				else
				{
					$list_w_title="<a href='view.php?$list_view_href' class=board>$list_w_title</a>";
				}
			}
		}
		else
		{
			$list_w_title="삭제된 게시물입니다.";
		}

		if($tmp_row[kind_appendcheck]=="1")
		{
			if($list_file_row[file_regname])
			{
				$list_w_pds_icon=select_icon("$board_upload_dir/$list_file_row[file_path]", $list_file_row[file_regname]);
				$list_arr[$f]["w_fileimg"]="<img src='board_img/$list_w_pds_icon' border='0' align='absmiddle'>";
			}
			else
			{
				$list_arr[$f]["w_fileimg"]="<img src='board_img/nothing.gif' border='0' align='absmiddle'>";
			}
		}
	}
	else //잠금기능 사용이 아니면...
	{
		if(strlen($list_row[w_title])>0)
		{
			$list_w_title=cut_str($list_row[w_title], 26);
			$list_w_title="<a href='view.php?$list_view_href' class=board>$list_w_title</a>";
		}
		else
		{
			$list_w_title="삭제된 게시물입니다.";
		}

		if($tmp_row[kind_appendcheck]=="1")
		{
			if($list_file_row[file_regname])
			{
				$list_w_pds_icon=select_icon("$board_upload_dir/$list_file_row[file_path]", $list_file_row[file_regname]);
				$list_w_fileimg="<img src='board_img/$list_w_pds_icon' border='0' align='absmiddle'>";
				$list_arr[$f]["w_fileimg"]="<a href='down.php?kind_code=$kind_code&w_seq=$list_row[w_seq]'>$list_w_fileimg</a>";
			}
			else
			{
				$list_arr[$f]["w_fileimg"]="<img src='board_img/nothing.gif' border='0' align='absmiddle'>";
			}
		}
	}

	if($list_row[w_step]>0) //답변글이면 제목앞에 아이콘 달기
	{
		$list_w_title="└[re]".$list_w_title;

		for($i=0; $i<$list_row[w_step]; $i++)
		{
			$list_w_title="&nbsp;&nbsp;".$list_w_title;
		}
	}

	if($list_row[w_part] && $tmp_row[kind_partcheck]=="1" && $list_row[w_step]=="0")
	{
		$list_part_title_msg="[".$list_row[w_part]."]";
		$list_w_title=$list_part_title_msg." ".$list_w_title;
	}

	if($tmp_row[kind_gallerycheck]=="1")
	{
		$list_file_sql="select * from $board_file_db
						where file_wcode='$kind_code'
						and file_wseq='$list_row[w_seq]'
						and file_sequence='0'";
		$list_file_result=mysql_query($list_file_sql, $connect);
		$list_file_num=mysql_num_rows($list_file_result);
		$list_file_row=mysql_fetch_array($list_file_result);

		if($list_file_row[file_regname])
		{
			if(file_exists("$board_upload_dir/$list_file_row[file_path]/$list_file_row[file_regname]"))
			{
				$list_gallery_img_msg=$list_file_row[file_regname];
			}
		}

		if($list_file_row[file_regname])
		{
			if(file_exists("$board_upload_dir/$list_file_row[file_path]/$list_file_row[file_regname]"))
			{
				$list_new_size=width_resize("$board_upload_dir/$list_file_row[file_path]/$list_file_row[file_regname]", "40");
				$list_img_width=$list_new_size[0];
				$list_img_height=$list_new_size[1];

				$list_encode_filename=urlencode($list_file_row[file_regname]);
				$list_gallery_img_msg="<img src='$board_upload_path/$list_file_row[file_path]/$list_encode_filename' width='$list_img_width' height='$list_img_height' border='0' align='absmiddle' hspace='5' vspace='5'>";
				$list_arr[$f]["gallery_img_msg"]=$list_gallery_img_msg;
			}
		}
		else
		{
			$list_gallery_img_msg="<img src='$board_upload_path/no_img.gif' border='0' align='absmiddle' hspace='5' vspace='5' width='40'>";
			$list_arr[$f]["gallery_img_msg"]=$list_gallery_img_msg;
		}

		if($list_file_num<1)
		{
			$list_gallery_img_msg="<img src='$board_upload_path/no_img.gif' border='0' align='absmiddle' hspace='5' vspace='5' width='40'>";
			$list_arr[$f]["gallery_img_msg"]=$list_gallery_img_msg;
		}
		$list_arr[$f]["w_fileimg"]=$list_arr[$f]["gallery_img_msg"];
	}
	else
	{
		$list_gallery_img_msg="";
		$list_arr[$f]["gallery_img_msg"]=$list_gallery_img_msg;
	}

	//$list_arr[$f]["w_title"]=new_icon($list_row[w_date], $list_w_title);
	$list_arr[$f]["w_title"]=$list_w_title;
	if($list_row[w_seq]==$w_seq)
	{
		$list_arr[$f]["w_title"]="<b>".$list_arr[$f]["w_title"]."</b>";
	}

	if($kind_code=="1")
	{
		$list_arr[$f]["w_newicon"]=new_icon_show($list_row[w_date], "7", "<img src=/customer/board_img/new.gif border=0 align=absmiddle>");
	}
	else
	{
		$list_arr[$f]["w_newicon"]=new_icon_show($list_row[w_date], "1", "<img src=/customer/board_img/new.gif border=0 align=absmiddle>");
	}
	$f++;
}

//공지글 출력
$list_notice_sql="select w_seq, w_part, w_name, w_title, w_date, w_read,
					w_group, w_step, w_lockyn
					from $board_db
					where w_noticeyn='1'
					order by w_seq desc";
$list_notice_result=mysql_query($list_notice_sql);
$list_notice_total_num=mysql_num_rows($list_notice_result);

$f=0;
while($list_notice_row=mysql_fetch_array($list_notice_result))
{
	$list_notice_arr[$f]["k"]="[공지]";

	$list_view_href="w_seq=$list_notice_row[w_seq]&page=$page&kind_code=$kind_code";
	if($list_search_name)
	{
		$list_view_href.="&search_part=$list_search_part&search_name=$list_search_name";
	}
	else if($list_part)
	{
		$list_view_href.="&part=$list_part";
	}

	$list_notice_arr[$f]["w_name"]=trim($list_notice_row[w_name]);
	$list_notice_arr[$f]["w_date"]=substr($list_notice_row[w_date], 0, 10);
	$list_notice_arr[$f]["w_seq"]=$list_notice_row[w_seq];
	$list_notice_arr[$f]["w_read"]=$list_notice_row[w_read];

	if(strlen($list_notice_row[w_title])>0)
	{
		$list_w_title=cut_str($list_notice_row[w_title], 26);
		$list_w_title="<a href='view.php?$list_view_href' class=board>$list_w_title</a>";
	}

	$list_notice_arr[$f]["w_title"]=new_icon($list_notice_row[w_date], $list_w_title); //new 아이콘 생성 함수
	$f++;
}

if($kind_code==100)
{
	include("view_main3.php");
}
else
{
	include("view_main.php");
}

?>
