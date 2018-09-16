
<!-- 내용 테이블 시작 -->
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
<!--board_list_form start-->
<form name="board_list_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr> 
		  <td height="28"> 
			<?=$list_nopart_check_start?>
			<select name="list_part" onChange="list_part_search();">
			  <option value="">분류 선택</option>
			  <?=$list_part_select_msg?>
			</select>
			<script language="javascript">
			  for(i=0; i<=<?=$list_part_num?>; i++)
			  {
				  if(document.board_list_form.list_part[i].value=="<?=$list_part?>")
				  {
					  document.board_list_form.list_part[i].selected=true;
				  }
			  }
			</script> 
			<?=$list_nopart_check_end?>
			&nbsp;
			<span class="txt_s2">Page :</span>
			<b><?=$page?></b>
			<span class="txt_s2">/ Total :</span>
			<b><?=$total_page?></b>
			</td>
		</tr>
	  </table></td>
  </tr>
  <tr> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
		  <td colspan="2"><table width="100%" height="29" border="0" cellpadding="0" cellspacing="0" background="img/board_bg_y1.gif">
			  <tr style="padding-top:5px">
				<td width="12%" align="center">번호 </td>
				<td width="3" align="center">:</td>
				<td width="46%" align="center">제목 </td>
				<td width="3" align="center">:</td>
				<td width="15%" align="center">작성자</td>
				<td width="3" align="center">:</td>
				<td width="13%" align="center">날짜</td>
				<td width="3" align="center">:</td>
				<td width="10%" align="center">조회</td>
			  </tr>
			</table></td>
		</tr>
		<tr> 
		  <td colspan="2">

<?php
for($i=0; $i<$list_notice_total_num; $i++)
{
?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr> 
				<td width="12%" height="25"><div align="center"><?=$list_notice_arr[$i]["k"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="48%" style="padding-left:5;"><?=$list_notice_arr[$i]["w_title"]?></td>
				<td width="2"><div align="center"></div></td>
				<td width="15%"><div align="center"><?=$list_notice_arr[$i]["w_name"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="15%"><div align="center"><?=$list_notice_arr[$i]["w_date"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="10%"><div align="center"><?=$list_notice_arr[$i]["w_read"]?></div></td>
			  </tr>
			  <tr> 
				<td height="1" colspan="9" background="img/list_line_bg.gif"></td>
			  </tr>
			</table>
<?php
} //end for($i=0; $i<$list_notice_total_num; $i++)
?>

<?php
for($i=0; $i<$list_total_num; $i++)
{
?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr> 
				<td width="12%" height="25"><div align="center"><?=$list_arr[$i]["k"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="48%" style="padding-left:5;">
				<?=$list_arr[$i]["w_fileimg"]?>
				<?=$list_arr[$i]["w_title"]?>
				<?=$list_arr[$i]["w_newicon"]?>
				</td>
				<td width="2"><div align="center"></div></td>
				<td width="15%"><div align="center"><?=$list_arr[$i]["w_name"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="15%"><div align="center"><?=$list_arr[$i]["w_date"]?></div></td>
				<td width="2"><div align="center"></div></td>
				<td width="10%"><div align="center"><?=$list_arr[$i]["w_read"]?></div></td>
			  </tr>
			  <tr> 
				<td height="1" colspan="9" background="img/list_line_bg.gif"></td>
			  </tr>
			</table>
<?php
} //end for($i=0; $i<$list_total_num; $i++)
?>
			<?=$list_norecord_check_start?>
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
			  <tr> 
				<td colspan="9" height="30">
				<div align="center">등록된 글이 없습니다.</div></td>
			  </tr>
			  <tr> 
				<td height="1" colspan="9" background="img/list_line_bg.gif"></td>
			  </tr>
			</table>
			<?=$list_norecord_check_end?>
		  </td>
		</tr>
		<tr bgcolor="89BDE2"> 
		  <td height="3" colspan="2"></td>
		</tr>
		<tr> 
		  <td width="85%" height="28">
		  <select name="list_search_part" class="box1">
			  <option value="w_title">글제목</option>
			  <option value="w_content">글내용</option>
			  <option value="w_name">작성자</option>
		  </select>
		  <script language="javascript">
			for(i=0; i<3; i++)
			{
				if(document.board_list_form.list_search_part[i].value=="<?=$list_search_part?>") 
				{
					document.board_list_form.list_search_part[i].selected=true;
					break;
				}
			}
		  </script>
		  <input name="list_search_name" type="text" class="box" style="width:100">
		  <a href="javascript:list_search_chk();"><img src="img/bt_search_b_y1.gif" border="0" align="absmiddle"></a></td>
		  <td width="15%" align="right">
		  <?=$list_nowrite_check_start?>
		  <a href="write.php?kind_code=<?=$kind_code?>"><img src="img/write2_button_y1.gif" border="0" align="absmiddle"></a>
		  <?=$list_nowrite_check_end?>
		  </td>
		</tr>
	  </table></td>
  </tr>
</form>
<!--board_list_form end-->
<tr> 
  <td height="40" align="center" class="board" > 
	<?=$page_arr["first1"]?>
	<img src="img/first_page_y1.gif" border="0"> 
	<?=$page_arr["first2"]?>
	&nbsp; 
	<?=$page_arr["prev1"]?>
	<img src="img/pre_page_y1.gif" border="0"> 
	<?=$page_arr["prev2"]?>
	&nbsp; <span class="rf"> 
	<?=$page_arr["list"]?>
	</span> &nbsp; 
	<?=$page_arr["next1"]?>
	<img src="img/next_page_y1.gif" border="0"> 
	<?=$page_arr["next2"]?>
	&nbsp; 
	<?=$page_arr["end1"]?>
	<img src="img/last_page_y1.gif" border="0"> 
	<?=$page_arr["end2"]?>
	&nbsp;&nbsp; </td>
</tr>
</table>
<!-- 내용 테이블 끝 -->
