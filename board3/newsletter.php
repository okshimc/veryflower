<? $page_num_depth_01="6" ?>
<? $page_num_depth_02="2" ?>
<? $page_num_depth_01="0" ?>
<?php
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");

function recent_list($board_table, $kind_code, $limit_num, $folder, $cut_num, $img_w_size, $img_h_size, $class_name)
{
	GLOBAL $connect, $board_file_db, $board_upload_dir, $board_upload_path;

	$notice_sql="select w_seq, w_title, w_email, w_date, w_step
						from $board_table
						order by w_group desc, w_top asc
						limit $limit_num";
	$notice_result=mysql_query($notice_sql);
	$notice_arr["notice_total_num"]=mysql_num_rows($notice_result);

	$i=0;
	while($notice_row=mysql_fetch_array($notice_result))
	{
		$view_href="w_seq=$notice_row[w_seq]&kind_code=$kind_code";
		$notice_arr[$i]["w_date"]=substr($notice_row[w_date], 0, 10);
		$notice_arr[$i]["w_seq"]=$notice_row[w_seq];

		if($kind_code==1)
		{
			if($notice_row[w_email])
			{
				$w_title=cut_str($notice_row[w_title], $cut_num);
				$w_title="<a href='http://$notice_row[w_email]' class='$class_name' target=_blank>$w_title</a>";
			}
			else
			{
				$w_title=cut_str($notice_row[w_title], $cut_num);
				$w_title="<a href='$folder/view.php?$view_href' class='$class_name'>$w_title</a>";
			}
		}
		else
		{
			$w_title=cut_str($notice_row[w_title], $cut_num);
			$w_title="<a href='$folder/view.php?$view_href' class='$class_name'>$w_title</a>";
		}

		if($notice_row[w_step]>0) //답변글이면 제목앞에 아이콘 달기
		{
			$w_title="└[re]".$w_title;

			for($re_i=0; $re_i<$notice_row[w_step]; $re_i++)
			{
				$w_title="&nbsp;&nbsp;".$w_title;
			}
		}

		$notice_arr[$i]["w_title"]=$w_title;

		if($img_w_size && $img_h_size)
		{
			$file_sql="select * from $board_file_db
							where file_wcode='$kind_code'
							and file_wseq='$notice_row[w_seq]'
							and file_sequence='0'";
			$file_result=mysql_query($file_sql, $connect);
			$file_num=mysql_num_rows($file_result);
			$file_row=mysql_fetch_array($file_result);

			if($file_row[file_regname])
			{
				if(file_exists("$board_upload_dir/$file_row[file_regname]"))
				{
					$gallery_img_msg=$file_row[file_regname];
				}
			}

			if($file_row[file_regname])
			{
				if(file_exists("$board_upload_dir/$file_row[file_regname]"))
				{
					$new_size=img_resize("$board_upload_dir/$file_row[file_regname]", "$img_w_size", "$img_h_size");
					$img_width=$new_size[0];
					$img_height=$new_size[1];

					$encode_filename=urlencode($file_row[file_regname]);
					$gallery_img_msg="<a href='$folder/view.php?$view_href'><img src='$board_upload_path/$encode_filename' width='$img_width' height='$img_height' border='0' align='absmiddle' hspace='0' vspace='0' border='0'></a>";
					$notice_arr[$i]["gallery_img_msg"]=$gallery_img_msg;
				}
			}
			else
			{
				$gallery_img_msg="<a href='$folder/view.php?$view_href'><img src='$board_upload_path/no_simg.gif' border='0' align='absmiddle' hspace='0' vspace='0' width='$img_w_size' border='0'></a>";
				$notice_arr[$i]["gallery_img_msg"]=$gallery_img_msg;
			}

			if($file_num<1)
			{
				$gallery_img_msg="<img src='$board_upload_path/no_simg.gif' border='0' align='absmiddle' hspace='0' vspace='0' width='$img_w_size'>";
				$notice_arr[$i]["gallery_img_msg"]=$gallery_img_msg;
			}
			$notice_arr[$i]["w_fileimg"]=$notice_arr[$i]["gallery_img_msg"];
		}

		$i++;
	}

	return $notice_arr;
}

//recent_list("테이블명", "게시판코드", "리스트갯수", "디렉토리", "제목절단글자수", "가로사이즈", "세로사이즈", "스타일명");
$notice_arr=recent_list("board_7", "7", "4", "/board", "40", "", "", "");
$notice_arr2=recent_list("board_8", "8", "4", "/board", "40", "", "", "");
$notice_arr3=recent_list("board_6", "6", "4", "/board", "40", "", "", "");
$notice_arr4=recent_list("board_16", "16", "4", "/board", "40", "", "", "");
$notice_arr5=recent_list("board_1", "1", "4", "/board", "40", "", "", "");
$notice_arr6=recent_list("board_4", "4", "4", "/board", "40", "", "", "");

?>
<? include "../html_include/title.php" ?>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="wrapper">
	<!--상단컨텐츠-->
	<? include "../html_include/top_menu.php" ?>
	
	<!--서브이미지-->
	<? include "../html_include/sub_img.php" ?>
	
	<!--중앙컨텐츠-->
	<div id="container_bg">
		<div id="container">
			<!--메인컨텐츠 시작-->
			<div id="main_content">
				<!--페이지경로-->
				<ul class="path">
					<li><img src="../images/common/home_icon.gif"></li>
					<li>공지사항</li>
					<li class="path_page">E-Newsletter</li>
				</ul>
				<h4><img src="../images/title/title06_02.png" class="png24"></h4>

        <dl class="news_list">
				  <div class="news_priv" align="left">
							<select name="select">
								<option>지난호 보기</option>
							</select>
					</div>
					<div class="news_letter">
					<a onclick="MM_showHideLayers('sitePopup02','','show','popupWrapper02','','show')" style="cursor:pointer;">
					<img src="img/btn_newsletter.gif" alt="뉴스레터신청"></a></div>
					<dt></dt>
					<dd>					
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<colgroup>
								<col width="50%">
								<col width="50%">
							</colgroup>
							<tbody>
								<tr>
									<th width="50%" scope="col"><div class="news_tit" align="left">2011년 1월 1호</div></th>
									<th width="50%" valign="top" scope="col">
									<div class="news_tit2" align="right">한국건설기계연구원</div></th>
								</tr>
								<tr>
									<td height="1" colspan="2" bgcolor="#E3E3E3" scope="col"></td>
								</tr>
								<tr>
									<th rowspan="2" valign="top" scope="col">
										  <div class="news_main">
										  	<p class="news_main_tit">산학연 네트워크란?</p>
										  	<p class="news_main_con">
										  	산업체.교육기관.연구기관의 정보교류 및 협력을 <br>
										  	촉진하고 네트워크 활동을 통해 산학.연 공동기술개발 <br>
										  	활동을 강화하고자 온라인상에 구축된 시스템입니다.
										  	<br><br>
									  		한국건설기계 전문가의 등록을 기다리고 있습니다.<br>
									  		</p><br>
										  	<p class="news_main_btn" align="right">
												<a href="#"><img src="img/btn_newsletter2.gif" alt="등록서작성하기"></a></p>
											</div><!--class="news_main" 끝-->
											
											<div class="news_main02">
												<p><img src="img/btn_banner.gif" alt="배너"></p>
											</div>
											<!--class="news_main" 끝-->
									</th>
									<th height="91" valign="top" scope="col">
										<p class="news_sub_tit">기술/산업동향</p>
											<ul>
											<?php for($i=0; $i<$notice_arr["notice_total_num"]; $i++){?>
											<li><?=$notice_arr[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
										</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">연구논문</p>
									<ul>
											<?php for($i=0; $i<$notice_arr2["notice_total_num"]; $i++){?>
											<li><?=$notice_arr2[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr2["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">KOCERI 뉴스</p>
									<ul>
											<?php for($i=0; $i<$notice_arr3["notice_total_num"]; $i++){?>
											<li><?=$notice_arr3[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr3["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
									</ul>
									</th>
									<th valign="top" scope="col">
									<p class="news_sub_tit">교육 및 세미나</p>
									<ul>
											<?php for($i=0; $i<$notice_arr4["notice_total_num"]; $i++){?>
											<li><?=$notice_arr4[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr4["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">건설기계 뉴스</p>
									<ul>
											<?php for($i=0; $i<$notice_arr5["notice_total_num"]; $i++){?>
											<li><?=$notice_arr5[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr5["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
									</ul>
									</th>
									<th valign="top" scope="col">
									<p class="news_sub_tit">Q & A</p>
									<ul>
											<?php for($i=0; $i<$notice_arr6["notice_total_num"]; $i++){?>
											<li><?=$notice_arr6[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr6["notice_total_num"]<1){?>
											<li>검색된 결과가 없습니다.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th colspan="2" scope="col">
										<p><img src="img/btn_banner2.gif" alt="배너"></p>
									</th>
								</tr>
								<tr>
									<th colspan="2" scope="col">									</th>
								</tr>
							</tbody>
						</table>
					</dd>
				</dl>

			</div><!--// id="main_content" 끝-->
			<!--// 메인컨텐츠 끝-->
			
			<!--좌측컨텐츠-->
			<? include "../html_include/left_menu.php" ?>
			<!--// 좌측컨텐츠 끝-->
			
			<!--퀵메뉴-->
			<? include "../html_include/quick.php" ?>
		</div><!--// id="container" 끝-->
	</div><!--// id="container_bg" 끝-->
	
	<!--bottom-->
	<? include "../html_include/bottom.php" ?>
</div>
<!--사이트맵-->
<? include "../sitemap/sitemap.php" ?>

<!--newsletter-->
<? include "../newsletter/newsletter.php" ?>
</body>
</html>
