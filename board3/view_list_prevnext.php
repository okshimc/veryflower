<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="eeeeee"> 
	<td height="2" colspan="3"></td>
  </tr>
  <?=$noprev_check_start?>
  <tr> 
	<td width="86" height="25" style="padding-left:10;">
	▒ 이전글 </td>
	<td width="6">|</td>
	<td width="513" style="padding-left:10;">
	<a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row2[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row2[w_title]?></a>
	<?=$part_title_msg2?>
	</td>
  </tr>
  <tr> 
	<td height="2" colspan="3" bgcolor="eeeeee"></td>
  </tr>
  <?=$noprev_check_end?>
  <?=$nonext_check_start?>
  <tr> 
	<td height="25" style="padding-left:10;">
	▒ 다음글 </td>
	<td>|</td>
	<td style="padding-left:10;"> 
	<?=$part_title_msg3?>
	<a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row3[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row3[w_title]?></a></td>
  </tr>
  <tr> 
	<td height="2" colspan="3" bgcolor="eeeeee"></td>
  </tr>
  <?=$nonext_check_end?>
</table>
<p>