<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<script type="text/javascript" language="javascript">
<!-- Hide script from older browsers
  function toggleMenu(currMenu) {
    if (document.all) {
	  if(document.all.menu.length>1)
	  {
		thisMenu = eval("document.all.menu[" + (currMenu) + "].style");
	  }else
	  {
		thisMenu = eval("document.all.menu.style");
	  }
      if (thisMenu.display == "block") {
        thisMenu.display = "none";
      }
      else {
		if(document.all.menu.length>1)
		{
			for(i=0;i<document.all.menu.length;i++) {
			  otherMenu = eval("document.all.menu[" + i + "].style");
			  otherMenu.display = "none";
			}
		}
        thisMenu.display = "block"
      }
      return false;
    }
    else {
      return true;
    }
  }

//-->
</script>

<table width="670" border="0" cellspacing="0" cellpadding="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr>
	<td height="25">&nbsp;</td>
  </tr>
  <tr>
	<td align="center"><table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><img src="../image/customer/qna_box_top.gif" width="650" height="10"></td>
	  </tr>
	  <tr>
		<td align="center" background="../image/customer/qna_box_bg.gif" style="padding:15 0 15 0">
		
		<?php for($i=0; $i<$total_num; $i++):?>
		<table width="620" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="60" height="30"align="center" background="../image/customer/qna_title_bg.gif"><img src="../image/customer/icon_q.gif" width="15" height="14" /></td>
			  <td width="560" height="30" background="../image/customer/qna_title_bg.gif" onClick="return toggleMenu(<?=$i?>)" style="cursor:hand;">
			  <?=$arr[$i]["w_title"]?></td>
			</tr>
		  </table>
			<table width="620" border="0" cellspacing="0" cellpadding="0" id="menu" style="display:none;">
			  <tr>
				<td width="60" align="center" valign="top"><img src="../image/customer/icon_a.gif" width="15" height="14" vspace="10" /></td>
				<td width="560" style="padding:10 0 10 0"><?=$arr[$i]["w_content"]?></td>
			  </tr>
			</table>
		  <table width="620" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="3"></td>
			  </tr>
			</table>
			<?php endfor;?>

			<?=$norecord_check_start?>
			<table width="620" border="0" cellspacing="0" cellpadding="0" id="menu" style="display:block;">
			  <tr>
				<td><div align="center">검색된 결과가 없습니다.</div></td>
			  </tr>
			</table>
			<?=$norecord_check_end?>

<!--
		  <table width="620" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="60" height="30"align="center" background="../image/customer/qna_title_bg.gif"><img src="../image/customer/icon_q.gif" width="15" height="14" /></td>
				<td width="560" height="30" background="../image/customer/qna_title_bg.gif" onClick="return toggleMenu(2)" style="cursor:hand;"><strong>[관련]</strong> 질문</td>
			  </tr>
			</table>
		  <table width="620" border="0" cellspacing="0" cellpadding="0" id="menu" style="display:none;">
			  <tr>
				<td width="60" align="center" valign="top"><img src="../image/customer/icon_a.gif" width="15" height="14" vspace="10" /></td>
				<td width="560" style="padding:10 0 10 0">답변</td>
			  </tr>
			</table>
			<table width="620" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="3"></td>
			  </tr>
			</table>
-->

		  </td>
	  </tr>
	  <tr>
		<td><img src="../image/customer/qna_box_bottom.gif" width="650" height="10"></td>
	  </tr>
	</table></td>
  </tr>
  <tr>
	<td align="center">&nbsp;</td>
  </tr>

  <tr>
	<td height="30"><table  border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td>
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
			</td>
		  </tr>
	</table></td>
  </tr>
  <tr>
	<td><table border="0" align="right" cellpadding="3" cellspacing="0">
		  <tr>
			<td bgcolor="#F2F4F4">&nbsp;</td>
			<td bgcolor="#F2F4F4">
	  <select name="search_part">
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
			<input name="search_name" type="text" size="10">
			<a href="javascript:search_chk();"><img src="img/bt_search_b_y1.gif" border="0" align="absmiddle"></a></td>
			<td bgcolor="#F2F4F4">&nbsp;</td>
			<td width="90">
			&nbsp;
			<?=$nowrite_check_start?>
			<a href="write.php?kind_code=<?=$kind_code?>"><img src="img/write2_button_y1.gif" border="0" align="absmiddle"></a>
			<?=$nowrite_check_end?>
			</td>
		  </tr>
	  </table></td>
  </tr>

</table></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>

<?php include("foot_board.php");?>
