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

		if($notice_row[w_step]>0) //�亯���̸� ����տ� ������ �ޱ�
		{
			$w_title="��[re]".$w_title;

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

//recent_list("���̺��", "�Խ����ڵ�", "����Ʈ����", "���丮", "�������ܱ��ڼ�", "���λ�����", "���λ�����", "��Ÿ�ϸ�");
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
	<!--���������-->
	<? include "../html_include/top_menu.php" ?>
	
	<!--�����̹���-->
	<? include "../html_include/sub_img.php" ?>
	
	<!--�߾�������-->
	<div id="container_bg">
		<div id="container">
			<!--���������� ����-->
			<div id="main_content">
				<!--���������-->
				<ul class="path">
					<li><img src="../images/common/home_icon.gif"></li>
					<li>��������</li>
					<li class="path_page">E-Newsletter</li>
				</ul>
				<h4><img src="../images/title/title06_02.png" class="png24"></h4>

        <dl class="news_list">
				  <div class="news_priv" align="left">
							<select name="select">
								<option>����ȣ ����</option>
							</select>
					</div>
					<div class="news_letter">
					<a onclick="MM_showHideLayers('sitePopup02','','show','popupWrapper02','','show')" style="cursor:pointer;">
					<img src="img/btn_newsletter.gif" alt="�������ͽ�û"></a></div>
					<dt></dt>
					<dd>					
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<colgroup>
								<col width="50%">
								<col width="50%">
							</colgroup>
							<tbody>
								<tr>
									<th width="50%" scope="col"><div class="news_tit" align="left">2011�� 1�� 1ȣ</div></th>
									<th width="50%" valign="top" scope="col">
									<div class="news_tit2" align="right">�ѱ��Ǽ���迬����</div></th>
								</tr>
								<tr>
									<td height="1" colspan="2" bgcolor="#E3E3E3" scope="col"></td>
								</tr>
								<tr>
									<th rowspan="2" valign="top" scope="col">
										  <div class="news_main">
										  	<p class="news_main_tit">���п� ��Ʈ��ũ��?</p>
										  	<p class="news_main_con">
										  	���ü.�������.��������� �������� �� ������ <br>
										  	�����ϰ� ��Ʈ��ũ Ȱ���� ���� ����.�� ����������� <br>
										  	Ȱ���� ��ȭ�ϰ��� �¶��λ� ����� �ý����Դϴ�.
										  	<br><br>
									  		�ѱ��Ǽ���� �������� ����� ��ٸ��� �ֽ��ϴ�.<br>
									  		</p><br>
										  	<p class="news_main_btn" align="right">
												<a href="#"><img src="img/btn_newsletter2.gif" alt="��ϼ��ۼ��ϱ�"></a></p>
											</div><!--class="news_main" ��-->
											
											<div class="news_main02">
												<p><img src="img/btn_banner.gif" alt="���"></p>
											</div>
											<!--class="news_main" ��-->
									</th>
									<th height="91" valign="top" scope="col">
										<p class="news_sub_tit">���/�������</p>
											<ul>
											<?php for($i=0; $i<$notice_arr["notice_total_num"]; $i++){?>
											<li><?=$notice_arr[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr["notice_total_num"]<1){?>
											<li>�˻��� ����� �����ϴ�.</li>
											<?php }?>
										</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">������</p>
									<ul>
											<?php for($i=0; $i<$notice_arr2["notice_total_num"]; $i++){?>
											<li><?=$notice_arr2[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr2["notice_total_num"]<1){?>
											<li>�˻��� ����� �����ϴ�.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">KOCERI ����</p>
									<ul>
											<?php for($i=0; $i<$notice_arr3["notice_total_num"]; $i++){?>
											<li><?=$notice_arr3[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr3["notice_total_num"]<1){?>
											<li>�˻��� ����� �����ϴ�.</li>
											<?php }?>
									</ul>
									</th>
									<th valign="top" scope="col">
									<p class="news_sub_tit">���� �� ���̳�</p>
									<ul>
											<?php for($i=0; $i<$notice_arr4["notice_total_num"]; $i++){?>
											<li><?=$notice_arr4[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr4["notice_total_num"]<1){?>
											<li>�˻��� ����� �����ϴ�.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th valign="top" scope="col">
									<p class="news_sub_tit">�Ǽ���� ����</p>
									<ul>
											<?php for($i=0; $i<$notice_arr5["notice_total_num"]; $i++){?>
											<li><?=$notice_arr5[$i]["w_title"]?></li>
											<?php }?>
											<?php if($notice_arr5["notice_total_num"]<1){?>
											<li>�˻��� ����� �����ϴ�.</li>
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
											<li>�˻��� ����� �����ϴ�.</li>
											<?php }?>
									</ul>
									</th>
								</tr>
								<tr>
									<th colspan="2" scope="col">
										<p><img src="img/btn_banner2.gif" alt="���"></p>
									</th>
								</tr>
								<tr>
									<th colspan="2" scope="col">									</th>
								</tr>
							</tbody>
						</table>
					</dd>
				</dl>

			</div><!--// id="main_content" ��-->
			<!--// ���������� ��-->
			
			<!--����������-->
			<? include "../html_include/left_menu.php" ?>
			<!--// ���������� ��-->
			
			<!--���޴�-->
			<? include "../html_include/quick.php" ?>
		</div><!--// id="container" ��-->
	</div><!--// id="container_bg" ��-->
	
	<!--bottom-->
	<? include "../html_include/bottom.php" ?>
</div>
<!--����Ʈ��-->
<? include "../sitemap/sitemap.php" ?>

<!--newsletter-->
<? include "../newsletter/newsletter.php" ?>
</body>
</html>
