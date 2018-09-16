<?php

//검색범위에 있는 게시물 정해진 갯수만큼 구하기
$cmt_sql="select * from $board_comment_db
					where comment_wcode='$kind_code'
					and comment_wseq='$w_seq'
					order by comment_no asc";
$cmt_result=mysql_query($cmt_sql);
$total_num=mysql_num_rows($cmt_result);

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($cmt_row=mysql_fetch_array($cmt_result))
{
	$k--;
	$arr[$f]["k"]=$k;
	$arr[$f]["comment_no"]=trim($cmt_row[comment_no]);
	$arr[$f]["comment_id"]=trim($cmt_row[comment_id]);
	$arr[$f]["comment_name"]=trim($cmt_row[comment_name]);
	$arr[$f]["comment_date"]=trim($cmt_row[comment_date]);
	$arr[$f]["comment_content"]=stripslashes($cmt_row[comment_content]);

	$f++;
}

?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
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

	if(document.comment_form.zsfCode && document.comment_form.zsfCode.value=="")
	{
		alert("스팸방지코드를 입력해 주세요.\r\n(스팸광고 방지를 위함)");
		document.comment_form.zsfCode.focus();
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
	document.comment_form.action="comment_ok.php";
	document.comment_form.submit();
}

function del_pwd_chk(no)
{
	document.comment_form.mode.value="comment_del";
	document.comment_form.delno.value=no;
	document.comment_form.action="comment_pwd.php";
	document.comment_form.submit();
}
//-->
</SCRIPT>
<!--comment_form start-->
<form name="comment_form" method="post" action="comment_ok.php">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="delno" value="">
<input type="hidden" name="mode" value="comment_input">
	<tr>
    	<td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pb_10"><span class="text_01">댓글 보기</span>
			<?php if($tmp_row[kind_wpower]=="2" && strlen($_SESSION[ok_id])<1) {?>
			(로그인 후 글쓰기가 가능합니다.)
			<?php } ?></td>
            <td width="25%" align="right">
			<?php if($tmp_row[kind_wpower]=="2" && strlen($_SESSION[ok_id])<1) {?>
			<a href="/mypage/login.php"><img src="img/btn_login.gif" width="40" height="16" border="0"></a>&nbsp;
			<a href="/mypage/agreement.php"><img src="img/btn_join.gif" width="49" height="16" border="0"></a>
			<?php } ?>
			</td>
          </tr>
        </table>
        </td>
        </tr>
    <tr> 
	  <td class="border_comment">
     <table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td class="pb_5">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <?php if($tmp_row[kind_wpower]!="2" && strlen($_SESSION[ok_id])<1) {?>
             <tr>
             	<td class="pb_10">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8%" class="pr_5">작성자 :</td>
                    <td width="42%" class="pr_35"><input type="text" name="comment_name" size="20" class="input"></td>
                    <td width="10%" class="pr_5">비밀번호 :</td>
                    <td width="40%" ><input type="password" name="comment_pw" size="20" class="input"></td>
                  </tr>
                </table>
                </td>
             </tr>
              <tr>
                <td class="pb_10">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img id="zsfImg" src="zmSpamFree.php?zsfimg" alt="여기를 클릭해 주세요." title="SpamFree.kr" style="border: none; cursor: pointer" onclick="this.src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime()" align="absmiddle" />
<a href="javascript:;"><img src="img/other_img.jpg" alt="다른그림보기" style="border:0px;" align="absmiddle" onclick="document.getElementById('zsfImg').src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime();" /></a>
<input type="text" name="zsfCode" id="zsfCode" size="20" class="form_box1" />
보안문자를 입력해주세요.</td>
                  </tr>
                </table>

                </td>
             </tr>
            <?php } ?>
        </table>
        </td>
      </tr>
       <tr>
        <td align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td>
      <?php if( $tmp_row[kind_wpower]=="2" && strlen($_SESSION[ok_id])<1 ){?>
      <textarea name="comment_content" cols="70" rows="3" class="box" onClick="alert('먼저 로그인을 해주시기 바랍니다');" style='width:100%; word-break:break-all;' readonly></textarea></td>
      <td width="12%" align="right">
      <a href="javascript:alert('먼저 로그인을 하세요.');" class="btn_comment">글쓰기</a>
      <?php }else{ ?>
      <textarea name="comment_content" cols="70" rows="3" class="box" style='width:100%; word-break:break-all;'></textarea></td>
      <td width="12%" align="right">
      <a href="javascript:comment_chk();" class="btn_comment">글쓰기</a>
      <?php } ?>
      </td>
    </tr>
  </table>
        
        </td>
      </tr>
  </table>

      </td>
	</tr>    
</table>
 <!-- 코멘트 끝 -->

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mt_20">
  <tr> 
    <td align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
		<?php for($i=0; $i<$total_num; $i++) {?>
        <tr> 
          <td class="dot_line">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" id="comment_view">
              <tr> 
                <td width="80%">
				<strong><font color="#000000">
				<?=$arr[$i]["comment_name"]?>
				</font></strong></td>
                <td width="20%" align="right"><font color="#999999"><?=$arr[$i]["comment_date"]?></font></td>
              </tr>
              <tr> 
			    <td><?=nl2br($arr[$i]["comment_content"])?></td>
                <td align="right">
				<?php if( strlen($_SESSION[ok_id])>0 && $_SESSION[ok_id]==$arr[$i]["comment_id"] ){?>
				<a href="javascript:del_chk('<?=$arr[$i]["comment_no"]?>');" class="btn_del">삭제하기</a>
				<?php }else{?>
				<a href="javascript:del_pwd_chk('<?=$arr[$i]["comment_no"]?>');" class="btn_del">삭제하기</a>
				<?php }?>
				</td>
              </tr>
            </table></td>
        </tr>
		<?php } ?>
      </table></td>
  </tr>
  </form>
</table>
<!--comment_form end-->

