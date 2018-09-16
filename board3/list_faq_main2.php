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

<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">

<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
	<td height="5"></td> 
  </tr> 
  <tr> 
	<td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
		<tr> 
		  <td height="45" align="center" bgcolor="#EDF7F8" style="border-right:1px solid #89D3E7; border-left:1px solid #89D3E7; border-top:1px solid #89D3E7; border-bottom:1px solid #89D3E7;"> <table border="0" cellpadding="0" cellspacing="0"> 
			  <tr> 
				<td height="20">
	  <select name="search_part" class="box">
		  <option value="w_title">글제목</option>
		  <option value="w_content">글내용</option>
	  </select>
	  <script language="javascript">
		for(i=0; i<document.board_form.search_part.length; i++)
		{
			if(document.board_form.search_part[i].value=="<?=$search_part?>") 
			{
				document.board_form.search_part[i].selected=true;
				break;
			}
		}
	  </script>
				  </td> 
				<td width="3"></td> 
				<td><input name="search_name" type="text" size="40" class="box"></td> 
				<td width="4"></td> 
				<td align="left" bgcolor="#EAF3EC"><a href="javascript:search_chk();"><img src="img/board_btn_search.gif" width="40" height="20" border="0" align="absmiddle"></a></td> 
			  </tr> 
			</table></td> 
		</tr> 
	  </table></td> 
  </tr> 
  <tr> 
	<td height="25"></td> 
  </tr> 
  <tr> 
	<td height="50" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
		<tr> 
		  <td>
		  
			<?php for($i=0; $i<$total_num; $i++):?>
			<!-- 첫번째 메뉴 테이블 시작--> 
			<table border="0" cellpadding="0" cellspacing="0" width="620"> 
			  <tr> 
				<td height="2" colspan="2"></td> 
			  </tr> 
			  <tr> 
				<td width="30" height="27" align="center"><img src="img/faq_bt_q.gif" width="14" height="14" /></td> 
				<td width="606" align="left" style="cursor:hand; padding-left:10px; padding-top:2px;" onClick="return toggleMenu(<?=$i?>)"><?=$arr[$i]["w_title"]?></td> 
			  </tr> 
			  <tr> 
				<td height="1" colspan="2" align="center" background="img/faq_line.gif"></td> 
			  </tr> 
			</table> 
			<table border="0" cellpadding="0" cellspacing="0" width="620" bgcolor="#F9FCFD" id="menu" style="display:none;"> 
			  <tr> 
				<td colspan="3" height="5"></td> 
			  </tr> 
			  <tr> 
				<td style="padding-bottom:2px" width="30" height="20" align="center" valign="top"><img src="img/faq_bt_a.gif" width="14" height="14"></td> 
				<td style="padding-left:8px; padding-right:8px; padding-top:2px; padding-bottom:6px" class="faq_blue"><?=$arr[$i]["w_content"]?></td> 
				<td width="10"></td> 
			  </tr> 
			  <tr> 
				<td height="1" colspan="3" bgcolor="#DCEBEE"></td> 
			  </tr> 
			</table>
			<?php endfor;?>
			<?=$norecord_check_start?>
			<table border="0" cellpadding="0" cellspacing="0" width="620"> 
			  <tr> 
				<td height="2" colspan="2"></td> 
			  </tr> 
			  <tr> 
				<td width="30" height="27" align="center"></td> 
				<td width="606" align="left" style="padding-left:10px; padding-top:2px;">검색된 결과가 없습니다.</td> 
			  </tr> 
			  <tr> 
				<td height="1" colspan="2" align="center" background="img/faq_line.gif"></td> 
			  </tr> 
			</table> 
			<?=$norecord_check_end?>
			<!-- 첫번째 메뉴 테이블 끝--> 

			</td> 
		</tr> 
		<tr> 
		  <td> </td> 
		</tr> 
		<tr> 
		  <td>&nbsp;</td> 
		</tr> 
		<tr>
		  <td><table  border="0" align="center" cellpadding="0" cellspacing="0">
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
		  <td>&nbsp;</td> 
		</tr> 
	  </table></td> 
  </tr> 
</form>
<!--board_form end-->
</table>

<?php include("foot_board.php");?>
