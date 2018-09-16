<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="620" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td>&nbsp;</td>
  </tr>
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="" enctype="multipart/form-data" onSubmit="return write_chk();">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search_part" value="<?=$search_part?>">
<input type="hidden" name="search_name" value="<?=$search_name?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="input">
  <tr>
	<td height="2" bgcolor="#E3E3E3"></td>
  </tr>
  <tr>
	<td bgcolor="#FFFFFF"><table  border="0" align="center" cellpadding="0" cellspacing="0">

		<?=$nopart_check_start?>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">분 류</div></td>
		  <td width="530" style="padding-left:10px;">
		  <select name="part" size="1">
			 <option value="">분류 목록</option>
			 <?=$part_select_msg?>
		  </select>
		  </td>
		</tr>
		<?=$nopart_check_end?>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">이 름</div></td>
		  <td width="530" style="padding-left:10px;"><input name="name" type="text" class="form_box1" value="<?=$_SESSION[ok_name]?>" size="30"></td>
		</tr>
		<?php if(!$_SESSION[ok_id]){?>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">비밀번호</div></td>
		  <td width="530" style="padding-left:10px;"><input name="passwd" type="password" class="form_box1" value="" size="30"></td>
		</tr>
		<?php }?>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">이메일</div></td>
		  <td width="530" style="padding-left:10px;"><input name="email" type="text" class="form_box1" size="50"></td>
		</tr>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">제 목</div></td>
		  <td width="530" style="padding-left:10px;"><input name="title" type="text" class="form_box1" value="" size="60"></td>
		</tr>
		<!--
		<?=//$notag_check_start?>
		<tr height="30" bgcolor="#ffffff">
		  <td bgcolor="F4FAFE">
		  <img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		  작성방법
		  </td>
		  <td>
		  <input name="tagyn" type="radio" value="n" checked class="i">
		  Text 입력
		  <input name="tagyn" type="radio" value="y" class="i">
		  Html 사용</td>
		</tr>
		<?=//$notag_check_end?>
		-->
		<?=$nolock_check_start?>
		<tr>
		  <td width="90" height="30" bgcolor="#F7F7F7"><div align="center">공개여부</div></td>
		  <td width="530" style="padding-left:10px;">
		  <input type="checkbox" name="lockyn" value="y" class="i">
		  비공개로 합니다.
		  </td>
		</tr>
		<?=$nolock_check_end?>
		<tr>
		  <td bgcolor="#F7F7F7"><div align="center">내 용</div></td>
		  <td width="530" style="padding-left:10px;">
		  <?php $sw->show();?>
		  (한줄바꿈 : Shift Enter / 두줄바꿈 : Enter)
		  </td>
		</tr>
		<?=$noappend_check_start?>
		<tr>
		  <td height="30" bgcolor="#F7F7F7"><div align="center">첨부파일</div></td>
		  <td width="530" style="padding-left:10px;">
		  <input name="upfile[]" type="file" size="46" class="form_box1">
		  </td>
		</tr>
		<?=$noappend_check_end?>
	</table></td>
  </tr>
  <tr>
	<td height="2" bgcolor="#E3E3E3"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><table border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td>
		  <input type="image" src="img/btn_check.gif" style="border:0px;">
		  <!--<a href="javascript:write_chk();"><img src="img/btn_check.gif" border="0"></a>-->
		  &nbsp;
		  <a href="list.php?kind_code=<?=$kind_code?>"><img src="img/list_button_y1.gif" border="0"></a></td>
		</tr>
	</table></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
</form>
<!--board_form end-->
</table>

<?php include("foot_board.php");?>
