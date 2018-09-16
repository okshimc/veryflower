<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!-- 내용 테이블 시작 -->
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<script src="board.js" language="javascript"></script>
<form name="pw_form" method="post" action="save.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="search_part" value="<?=$search_part?>">
<input type="hidden" name="search_name" value="<?=$search_name?>">
<input type="hidden" name="mode" value="del">
<input type="hidden" name="part" value="<?=$part?>">
  <tr> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr> 
		  <td align="center" bgcolor="#FFFFFF"><img src="img/pwd_q_title.gif"></td>
		</tr>
		<tr> 
		  <td height="40" align="center" bgcolor="#FFFFFF">
		  비밀번호 : <input name="passwd" type="password" size="20" class="box"></td>
		</tr>
		<tr> 
		  <td height="40" align="center" valign="bottom" bgcolor="#FFFFFF">
		  <a href="javascript:pw_chk();"><img src="img/ok_button_y1.gif" border="0"></a>
		  &nbsp;
		  <a href="javascript:history.back();"><img src="img/cancel_button_y1.gif" border="0"></a> 
		  </td>
		</tr>
	  </table></td>
  </tr>
<!--pw_form end-->
</form>
</table>
<!-- 내용 테이블 끝 -->

<?php include("foot_board.php");?>

