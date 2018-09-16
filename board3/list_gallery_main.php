<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!-- 내용 테이블 시작 -->
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr> 
		  <td height="28"> 
			<?=$nopart_check_start?>
			<select name="part" onChange="part_search();">
			  <option value="">분류 선택</option>
			  <?=$part_select_msg?>
			</select>
			<script language="javascript">
			  for(i=0; i<=<?=$part_num?>; i++)
			  {
				  if(document.board_form.part[i].value=="<?=$part?>")
				  {
					  document.board_form.part[i].selected=true;
				  }
			  }
			</script> 
			<?=$nopart_check_end?>
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
	<td height="250"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
		  <td colspan="2" valign="top" align="center">


<table width="100%" border="0" cellpadding="10" cellspacing="1">
	<tr> 
	  <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="4">

<?php
$j=0;
$s=0;
for($i=0; $i<$total_num; $i++)
{
	$j++;
	$s++;
	if($j==1 || $j%4==1) echo("<tr>");
?>

		<td valign="top" width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td height="135" valign="top"><table height="105" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="499EDA">
				  <tr> 
					<td bgcolor="#FFFFFF"><table width="100%" height="93" border="0" cellpadding="0" cellspacing="0">
						<tr> 
						  <td bgcolor="#FFFFFF">
						  <div align="center"><?=$arr[$i]["w_fileimg"]?></div></td>
						</tr>
					  </table></td>
				  </tr>
				</table>
				<br>
				<div align="center">
				<?=$arr[$i]["w_title"]?>
				<br><br>
				</div></td>
			</tr>
		  </table></td>

<?php
	if($j%4==0)
	{
		echo("</tr>");
		$s=0;
	}
} //end for($i=0; $i<$total_num; $i++)

if($s!=0)
{
	for($m=$s; $m<4; $m++)
	{
?>

		<td valign="top" width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td height="135" valign="top"><table height="105" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="499EDA">
				  <tr> 
					<td bgcolor="#FFFFFF"><table width="100%" height="93" border="0" cellpadding="0" cellspacing="0">
						<tr> 
						  <td bgcolor="#FFFFFF">
						  <div align="center"><img src="<?=$tmp_row[kind_updir]?>/no_simg.gif" border="0" width="100" align="absmiddle" hspace="5" vspace="5"></div></td>
						</tr>
					  </table></td>
				  </tr>
				</table></td>
			</tr>
		  </table></td>

<?php
	}
}
?>

<?php
if($total_num<1)
{
?>
	  <tr>
		<td valign="top" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td height="30"><table border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr> 
					<td bgcolor="#FFFFFF"><div align="center">검색된 결과가 없습니다.</div></td>
				  </tr>
				</table></td>
			</tr>
		  </table></td>
		</tr>
<?php
}
?>

		</table>
		</td>
	</tr>
  </table>



		  </td>
		</tr>
		<tr> 
		  <td height="3" colspan="2"></td>
		</tr>
		<tr> 
		  <td width="85%" height="28">
		  <select name="search_part" class="box1">
			  <option value="w_title">글제목</option>
			  <option value="w_content">글내용</option>
			  <option value="w_name">작성자</option>
		  </select>
		  <script language="javascript">
			for(i=0; i<3; i++)
			{
				if(document.board_form.search_part[i].value=="<?=$search_part?>") 
				{
					document.board_form.search_part[i].selected=true;
					break;
				}
			}
		  </script>
		  <input name="search_name" type="text" class="box" style="width:100">
		  <a href="javascript:search_chk();"><img src="img/bt_search_b_y1.gif" border="0" align="absmiddle"></a></td>
		  <td width="15%" align="right">
		  <?=$nowrite_check_start?>
		  <a href="write.php?kind_code=<?=$kind_code?>"><img src="img/write2_button_y1.gif" border="0" align="absmiddle"></a>
		  <?=$nowrite_check_end?>
		  </td>
		</tr>
	  </table></td>
  </tr>
</form>
<!--board_form end-->
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

<?php include("foot_board.php");?>
