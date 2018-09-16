<?php include("top_vote.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!-- 내용 테이블 시작 -->
<table width="95%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
	  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td>&nbsp;</td>
			</tr>
			<tr> 
			  <td><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
				  <tr> 
					<td valign="top" style="padding-top:15;padding-bottom:15;">					  <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#D8D8D8">
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
                                    <td bgcolor="#EFEDEB"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="10%" height="6"></td>
                                          <td width="90%" height="6"></td>
                                        </tr>
                                        <tr>
                                          <td><img src="vote_img/icon_ques.gif" hspace="7"></td>
                                          <td align="left"><b><span class="style7">: <?=$row[vote_question]?></span></b></td>
                                        </tr>
                                        <tr>
                                          <td height="6"></td>
                                          <td height="6"></td>
                                        </tr>
                                        <tr>
                                          <td height="24">&nbsp;</td>
                                          <td align="left"><span class="style10">- 설문기간 : <?=$row[vote_startday]?> ~ <?=$row[vote_endday]?></span></td>
                                        </tr>
                                        <tr>
                                          <td height="24">&nbsp;</td>
                                          <td align="left"><span class="style10">- 총설문인원 : <?=$total_vote?> 명</span></td>
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
                                    <td align="left" valign="top" bgcolor="#F5F5F5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="4%" height="20"></td>
                                          <td width="92%" height="20"></td>
                                          <td width="4%" height="20"></td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                              <tr background="img/bg_dot_line.gif">
                                                <td height="5" background="img/bg_dot_line.gif"></td>
                                                <td background="img/bg_dot_line.gif"></td>
                                                <td background="img/bg_dot_line.gif"></td>
                                              </tr>
											  <?php for($i=1; $i<=$row[vote_exnum]; $i++){ ?>
                                              <tr>
                                                <td width="35%" height="30" class="style7"><?=$arr[$i][v]?>. <?=$arr[$i][ex_name]?></td>
                                                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td><img src="vote_img/poll_stick10_img.gif" width="<?=$arr[$i][width]?>" height="14"></td>
                                                    </tr>
                                                </table></td>
                                                <td width="20%" class="style7"><?=$arr[$i][ans_percent]?>% (<?=$arr[$i][ans_num]?>명)</td>
                                              </tr>
                                              <tr background="img/bg_dot_line.gif">
                                                <td height="5" background="img/bg_dot_line.gif"></td>
                                                <td background="img/bg_dot_line.gif"></td>
                                                <td background="img/bg_dot_line.gif"></td>
                                              </tr>
											  <?php } ?>
                                          </table></td>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td height="10"></td>
                                          <td height="10"></td>
                                          <td height="10"></td>
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
			  <a href="list_vote.php?page=<?=$page?>"><img src="img/list_button.gif" border="0" hspace="14"></a>
			</div></td>
			</tr>
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
