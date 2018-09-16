<?php include("top_vote.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<SCRIPT LANGUAGE="JavaScript">
<!--

function getCookieVal(offset) 
{
	var endstr = document.cookie.indexOf (';', offset);
	if (endstr == -1) endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name) //설정된 쿠키값 가져오는 함수
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;

	while(i < clen) 
	{
		var j = i + alen;
		if(document.cookie.substring(i, j) == arg) 
		{
			return getCookieVal(j);
		}
		i = document.cookie.indexOf(" ", i) + 1;
		if(i == 0) 
		{
			break;
		}
	}
	return null;
}

function vote_check(vote_no) //설문 체크하고 새창으로 전송하기
{
	var return_value=0;
	var form=document.vote_form;

	for(i=0; i<form.ans_no.length; i++)
	{
		if(form.ans_no[i].checked==true)
		{
			return_value=1;
			break;
		}
	}
	if(return_value==0)
	{
		alert("항목을 선택하세요.");
		return;
	}

	var voted_val=GetCookie("voted");
	if(voted_val)
	{
		alert("이미 투료를 하셨습니다.");
		return;
	}
	form.action="view_vote.php";
	form.mode.value="update";
	form.submit();
}

//-->
</SCRIPT>
<!-- 내용 테이블 시작 -->
<table width="95%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
	  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td>&nbsp;</td>
			</tr>
<!--vote_form start-->
<form name="vote_form" method="post" action="">
<input type="hidden" name="vote_no" value="<?=$vote_no?>">
<input type="hidden" name="mode" value="">
			<tr> 
			  <td><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
				  <tr> 
					<td valign="top" style="padding-top:15;padding-bottom:15;"> 
					  <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#D8D8D8">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="4"></td>
                                <td></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td></td>
                                <td width="4"></td>
                              </tr>
                              <tr>
                                <td height="4"></td>
                                <td height="4"></td>
                                <td height="4"></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td bgcolor="EFEDEB"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="10%" height="6"></td>
                                            <td width="90%" height="6"></td>
                                          </tr>
                                          <tr>
                                            <td><img src="vote_img/icon_ques.gif" hspace="7"></td>
                                            <td align="left"><b><span class="style7"><span class="style8">:</span> <?=$row[vote_question]?></span></b></td>
                                          </tr>
                                          <tr>
                                            <td height="6"></td>
                                            <td height="6"></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="left"><span class="style10">- 설문기간 : <?=$row[vote_startday]?> ~ <?=$row[vote_endday]?> -</span></td>
                                          </tr>
                                          <tr>
                                            <td height="6"></td>
                                            <td height="6"></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td height="8"></td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" bgcolor="F5F5F5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="4%" height="20"></td>
                                            <td width="96%" height="20"></td>
                                          </tr>
										  <tr background="img/bg_dot_line.gif">
											<td height="5" background="img/bg_dot_line.gif"></td>
											<td background="img/bg_dot_line.gif"></td>
										  </tr>
										  <?php for($i=1; $i<=$row[vote_exnum]; $i++){ ?>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="30"><input name="ans_no" type="radio" value="<?=$arr[$i][vote_ansno]?>" style="border:0px;"> <span class="style7"><?=$arr[$i][vote_question]?></span></td>
                                          </tr>
										  <tr background="img/bg_dot_line.gif">
											<td height="5" background="img/bg_dot_line.gif"></td>
											<td background="img/bg_dot_line.gif"></td>
										  </tr>
										  <?php } ?>
                                          <tr>
                                            <td height="10">&nbsp;</td>
                                            <td height="10">&nbsp;</td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                </table></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="4"></td>
                                <td height="4"></td>
                                <td height="4"></td>
                              </tr>
                          </table></td>
                        </tr>
                      </table></td>
				  </tr>
				</table></td>
			</tr>
			<tr> 
			  <td height="40"><div align="center">
			  <a href="javascript:vote_check('<?=$row[vote_no]?>');"><img src="vote_img/main_poll_btn01.gif" hspace="14" border="0"></a>
			  &nbsp; <a href="view_vote.php?mode=view&vote_no=<?=$row[vote_no]?>&page=<?=$page?>"><img src="vote_img/main_poll_btn02.gif" border="0"></a>
			  &nbsp; <a href="list_vote.php?page=<?=$page?>"><img src="img/list_button.gif" border="0" hspace="14"></a>
			</div></td>
			</tr>
</form>
<!--vote_form end-->
		</table></td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
</table>
<!-- 내용 테이블 끝 -->
<?php //include("view_list_prevnext.php");?>
<?php
if($tmp_row[kind_commentcheck]=="1") include("comment_view.php");
?>
<?php //include("view_list_main.php");?>
<?php include("foot_vote.php");?>
