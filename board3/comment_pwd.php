<?php
session_cache_limiter("");
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");
include("board_inc/board_kind_top.php");
include("top_board.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<!-- 내용 테이블 시작 -->
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<script>
function pw_chk()
{
	if(document.pw_form.comment_pw.value.length==0)
	{
		alert("비밀번호를 입력하세요.");
		document.pw_form.comment_pw.focus();
		return;
	}
	document.pw_form.submit();
}
</script>
<form name="pw_form" method="post" action="comment_ok.php">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="delno" value="<?=$delno?>">
<input type="hidden" name="mode" value="comment_del">
  <tr> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr> 
		  <td align="center" bgcolor="#FFFFFF"><img src="img/pwd_q_title.gif"></td>
		</tr>
		<tr> 
		  <td height="40" align="center" bgcolor="#FFFFFF">
		  비밀번호 : <input name="comment_pw" type="password" size="20" class="box"></td>
		</tr>
		<tr> 
		  <td height="40" align="center" valign="bottom" bgcolor="#FFFFFF">
		  <a href="javascript:pw_chk();"><img src="img/ok_button.gif" border="0"></a>
		  &nbsp;
		  <a href="javascript:history.back();"><img src="img/cancel_button.gif" border="0"></a> 
		  </td>
		</tr>
	  </table></td>
  </tr>
<!--pw_form end-->
</form>
</table>
<!-- 내용 테이블 끝 -->

<?php include("foot_board.php");?>