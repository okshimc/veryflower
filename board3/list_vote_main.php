<?php include("top_vote.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td>&nbsp;</td>
  </tr>
<script src="board.js" language="javascript"></script>
  <tr>
	<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr height="26">
				<td width="60" bgcolor="#678BBB">
				<div align="center"><font color="#FFFFFF"><b>NO</b></font></div></td>
				<td bgcolor="#678BBB">
				<div align="center"><font color="#FFFFFF"><b>설문 제목</b></font></div></td>
				<td width="92" bgcolor="#678BBB">
				<div align="center"><font color="#FFFFFF"><b>시작일</b></font></div></td>
				<td width="92" bgcolor="#678BBB">
				<div align="center"><font color="#FFFFFF"><b>종료일</b></font></div></td>
				<td width="82" bgcolor="#678BBB">
				<div align="center"><font color="#FFFFFF"><b>상태</b></font></div></td>
			  </tr>
			  <tr>
				<td height="5"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			  </tr>

			  <?php for($i=0; $i<$total_num; $i++):?>
			  <tr>
				<td height="25"><div align="center"><?=$arr[$i]["k"]?></div></td>
				<td style="padding-left:10px;"><?=$arr[$i]["vote_question"]?></td>
				<td><div align="center"><?=$arr[$i]["vote_startday"]?></div></td>
				<td><div align="center"><?=$arr[$i]["vote_endday"]?></div></td>
				<td><div align="center"><?=$arr[$i]["vote_status"]?></div></td>
			  </tr>
			  <tr background="img/bg_dot_line.gif">
				<td height="5" background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
			  </tr>
			  <?php endfor;?>
			  <?=$norecord_check_start?>
			  <tr>
				<td colspan="5" height="25"><div align="center">검색된 결과가 없습니다.</div></td>
			  </tr>
			  <tr background="img/bg_dot_line.gif">
				<td height="5" background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
			  </tr>
			  <?=$norecord_check_end?>

		  </table></td>
		</tr>
		<tr>
		  <td height="10"></td>
		</tr>
		<tr>
		  <td><table  border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td>
<?=$page_arr["first1"]?>
<img src="img/first_page.gif" width="14" height="10" border="0"> 
<?=$page_arr["first2"]?>
&nbsp; 
<?=$page_arr["prev1"]?>
<img src="img/pre_page.gif" width="7" height="10" border="0"> 
<?=$page_arr["prev2"]?>
&nbsp; <span class="rf"> 
<?=$page_arr["list"]?>
</span> &nbsp; 
<?=$page_arr["next1"]?>
<img src="img/next_page.gif" width="7" height="10" border="0"> 
<?=$page_arr["next2"]?>
&nbsp; 
<?=$page_arr["end1"]?>
<img src="img/last_page.gif" width="14" height="10" border="0"> 
<?=$page_arr["end2"]?>
				</td>
			  </tr>
		  </table></td>
		</tr>
		<tr>
		  <td height="30"></td>
		</tr>
	</table></td>
  </tr>
</table>

<?php include("foot_vote.php");?>
