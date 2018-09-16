<?php include("top_req.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="90%"  border="0" cellspacing="0" cellpadding="0">
<script language="javascript" src="board.js"></script>
<form name="req_form" method="post" action="req_ok2.php" enctype="multipart/form-data">
<input type="hidden" name="mode" value="reg">
<input type="hidden" name="req_part" value="1">
  <tr>
	<td height="20"></td>
  </tr>
  <tr>
	<td height="181" align="center" valign="top"><table width="100%" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#C6C6C6">
	  <tr height="30" bgcolor="#ffffff">
		<td width="100" height="25" bgcolor="#F2F2F2">
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		성 명</td>
		<td height="25" bgcolor="#ffffff">
		<input name="req_name" type="text" class="input" value="" size="20">
		</td>
	  </tr>
	  <tr height="30">
		<td height="25" bgcolor="#F2F2F2">
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		전화번호</td>
		<td height="12" bgcolor="#FFFFFF">
		<input name="req_phone1" type="text" class="input" value="" size="10">
		-
		<input name="req_phone2" type="text" class="input" value="" size="10">
		-
		<input name="req_phone3" type="text" class="input" value="" size="10"></td>
	  </tr>
	  <tr height="30">
		<td height="25" bgcolor="#F2F2F2">
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		휴대폰</td>
		<td height="12" bgcolor="#FFFFFF">
		<input name="req_hp1" type="text" class="box" value="" size="10">
		-
		<input name="req_hp2" type="text" class="box" value="" size="10">
		-
		<input name="req_hp3" type="text" class="box" value="" size="10"></td>
	  </tr>
	  <tr height="30">
		<td height="25" bgcolor="#F2F2F2">
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		이메일 </td>
		<td height="12" bgcolor="#FFFFFF">
		<input name="req_email" type="text" class="input" value="" size="40"></td>
	  </tr>
	  <tr bgcolor="#FFFFFF" height="30">
		<td valign="top" bgcolor="#F2F2F2" class=p_t>
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		문의사항</td>
		<td valign="top" bgcolor="#FFFFFF">
		<textarea name="req_content" style="width:350px;height:120px" wrap="hard" class="input"></textarea></td>
	  </tr>
	  <tr height="30">
		<td height="25" bgcolor="#F2F2F2">
		<img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		첨부파일 </td>
		<td height="12" bgcolor="#FFFFFF">
		<input name="req_addfile" type="file" class="box" value="" size="50"></td>
	  </tr>
	</table></td>
  </tr>
  <tr>
	<td height="40" align="center" valign="bottom" class=p_t>
	<a href="javascript:req_check2();"><img src="../customer/img/ok_button_y1.gif" align="absmiddle" border="0"></a>
	&nbsp;&nbsp;
	<a href="javascript:history.back();"><img src="../customer/img/cancel_button_y1.gif" align="absmiddle" border="0"></a>
	</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
</form>
</table>

<?php include("foot_board.php");?>
