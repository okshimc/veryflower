<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<?php

/* 검색 범위에 있는 총 게시물 목록 구하기(페이지 나누기용) */
$page_sql="select count(comment_no) from incheck_comment";
$page_result=mysql_query($page_sql);
$page_row=mysql_fetch_row($page_result);

$total_record=$page_row[0]; //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$cmt_sql="select * from incheck_comment
					where comment_wcode='7'
					order by comment_no desc
					limit $start_record, $record_set";
$cmt_result=mysql_query($cmt_sql);
$cmt_total_num=mysql_num_rows($cmt_result);

$default_href="$PHP_SELF?$page_href";
$page_arr=page_list(); //페이지 나누기 함수 실행

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($cmt_row=mysql_fetch_array($cmt_result))
{
	$k--;
	$cmt_arr[$f]["k"]=$k;
	$cmt_arr[$f]["comment_no"]=trim($cmt_row[comment_no]);
	$cmt_arr[$f]["comment_id"]=trim($cmt_row[comment_id]);
	$cmt_arr[$f]["comment_name"]=trim($cmt_row[comment_name]);
	$cmt_arr[$f]["comment_date"]=trim($cmt_row[comment_date]);
	$cmt_arr[$f]["comment_content"]=stripslashes($cmt_row[comment_content]);

	$f++;
}

?>

<table width="95%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="EAF4F6">
<SCRIPT LANGUAGE="JavaScript">
<!--

function comment_chk()
{
	if(document.comment_form.comment_name && document.comment_form.comment_name.value=="") 
	{
		alert("이름을 입력하세요.");
		document.comment_form.comment_name.focus();
		return;
	}
	if(document.comment_form.comment_pw && document.comment_form.comment_pw.value=="") 
	{
		alert("비밀번호를 입력하세요.");
		document.comment_form.comment_pw.focus();
		return;
	}
	if(document.comment_form.comment_content.value=="") 
	{
		alert("내용을 입력하세요.");
		document.comment_form.comment_content.focus();
		return;
	}
	if(!confirm("등록 하시겠습니까?")) return;
	document.comment_form.submit();
}

function del_chk(no)
{
	if(!confirm("삭제하시겠습니까?")) return;
	document.comment_form.mode.value="comment_del";
	document.comment_form.delno.value=no;
	document.comment_form.action="incheck_ok.php";
	document.comment_form.submit();
}

function del_pw_chk(no)
{
	//if(!confirm("삭제하시겠습니까?")) return;
	document.comment_form.mode.value="comment_del";
	document.comment_form.delno.value=no;
	document.comment_form.action="passwd_incheck.php";
	document.comment_form.submit();
}
//-->
</SCRIPT>
<!--comment_form start-->
<form name="comment_form" method="post" action="incheck_ok.php">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="delno" value="">
<input type="hidden" name="mode" value="comment_input">
	<tr> 
	  <td width="100%" bgcolor="#F9F9F9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr> 		
			<td width="75%"><img src="img/bullet_07.gif" width="16" height="13" align="absmiddle"><font color="#333333"><strong>방명록</strong></font>
			<?php if($tmp_row[kind_wpower]=="2" && !$_SESSION[ok_id]) {?>
			(로그인 후 글쓰기가 가능합니다.)
			<?php } ?>
			</td>
			<td width="25%" align="right">
			<!--
			<?php if(!$_SESSION[ok_id]) {?>
			<a href="/member/login.php"><img src="img/btn_login.gif" width="40" height="16" border="0"></a>&nbsp;
			<a href="/member/join.php"><img src="img/btn_join.gif" width="49" height="16" border="0"></a>
			<?php } ?>
			-->
			</td>
		  </tr>
		  <?php if($tmp_row[kind_wpower]=="1") {?>
		  <tr> 
			<td>
			  작성자 <input type="text" name="comment_name" size="10" class="box">
			  비밀번호 <input type="password" name="comment_pw" size="10" class="box">
			</td>
		  </tr>
		  <?php } ?>
		  <tr> 
			<td height="5" colspan="2"></td>
		  </tr>
		  <tr> 
			<td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td width="88%"><textarea name="comment_content" cols="70" rows="2" class="box" <? if($tmp_row[kind_wpower]=="2" && !$_SESSION[ok_id]){?>onClick="alert('먼저 로그인을 해주시기 바랍니다');" readonly<? } ?>></textarea></td>
				  <td width="12%" align="right">
				  <?php if($tmp_row[kind_wpower]=="2" && !$_SESSION[ok_id]){?>
				  <a href="javascript:alert('먼저 로그인을 하세요.');"><img src="img/btn_write.gif" width="59" height="18" border="0"></a>
				  <?php }else{ ?>
				  <a href="javascript:comment_chk();"><img src="img/btn_write.gif" width="59" height="18" border="0"></a>
				  <?php } ?>
				  </td>
				</tr>
			  </table></td>
		  </tr>
		</table></td>
	</tr>
</form>
<!--comment_form end-->
</table>
  <p>
  <!-- 코멘트 끝 -->

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td>&nbsp;</td>
  </tr>
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr>
	<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr height="26">
				<td bgcolor="#825337">
				<div align="center"><font color="#FFFFFF"><b>내 용</b></font></div></td>
				<td width="90" bgcolor="#825337">
				<div align="center"><font color="#FFFFFF"><b>작성자</b></font></div></td>
				<td width="130" bgcolor="#825337">
				<div align="center"><font color="#FFFFFF"><b>작성일</b></font></div></td>
				<td width="60" bgcolor="#825337">
				<div align="center"><font color="#FFFFFF"><b>DEL</b></font></div></td>
			  </tr>
			  <tr>
				<td height="5"></td>
				<td></td>
				<td></td>
				<td></td>
			  </tr>

			  <?php for($i=0; $i<$cmt_total_num; $i++):?>
			  <tr>
				<td style="padding-left:10px;"><?=nl2br($cmt_arr[$i]["comment_content"])?></td>
				<td width="90"><div align="center"><?=$cmt_arr[$i]["comment_name"]?></div></td>
				<td width="130"><div align="center"><?=$cmt_arr[$i]["comment_date"]?></div></td>
				<td width="60" height="25"><div align="center">
				<?php if($tmp_row[kind_wpower]=="2" && $_SESSION[ok_id] && $_SESSION[ok_id]==$cmt_arr[$i]["comment_id"]){?>
				<a href="javascript:del_chk('<?=$cmt_arr[$i]["comment_no"]?>');"><img src="img/btn_delete_y1.gif" border="0"></a>
				<?php }else{?>
				<a href="javascript:del_pw_chk('<?=$cmt_arr[$i]["comment_no"]?>');"><img src="img/btn_delete_y1.gif" border="0"></a>
				<?php }?>
				</div></td>
			  </tr>
			  <tr background="img/bg_dot_line.gif">
				<td height="5" background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
			  </tr>
			  <?php endfor;?>
			  <?php if($cmt_total_num<1){?>
			  <tr>
				<td colspan="4" height="25"><div align="center">검색된 결과가 없습니다.</div></td>
			  </tr>
			  <tr background="img/bg_dot_line.gif">
				<td height="5" background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
				<td background="img/bg_dot_line.gif"></td>
			  </tr>
			  <?php }?>

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
<img src="img/first_page_y1.gif" border="0" align="absmiddle"> 
<?=$page_arr["first2"]?>
&nbsp; 
<?=$page_arr["prev1"]?>
<img src="img/pre_page_y1.gif" border="0" align="absmiddle"> 
<?=$page_arr["prev2"]?>
&nbsp; <span class="rf"> 
<?=$page_arr["list"]?>
</span> &nbsp; 
<?=$page_arr["next1"]?>
<img src="img/next_page_y1.gif" border="0" align="absmiddle"> 
<?=$page_arr["next2"]?>
&nbsp; 
<?=$page_arr["end1"]?>
<img src="img/last_page_y1.gif" border="0" align="absmiddle"> 
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
</form>
<!--board_form end-->
</table>

<?php include("foot_board.php");?>
