<?php
session_start();
include("../inc/dbcon.php");
include("../inc/db_sql.php");
include("../inc/function.php");

if(!$_SESSION[ok_id])
{
	$html="$home_path/shop/value_write.php?brand_code=$brand_code";
	echo("
		<script language='javascript'>
			alert('상품평은 회원만 작성할수 있습니다.');
			window.close();
		</script>
		");
	exit();
}

$sql="select * from $brand_value_db where value_no='$value_no'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

if($row[value_rate]=="1") $check1="checked";
if($row[value_rate]=="2") $check2="checked";
if($row[value_rate]=="3") $check3="checked";
if($row[value_rate]=="4") $check4="checked";

?>
<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<SCRIPT LANGUAGE="JavaScript">

function value_chk()
{
	var rate_check="no";

	if(document.value_form.subject.value=="")
	{
		alert("제목을 입력하세요.");
		document.value_form.subject.focus();
		return;
	}
	if(document.value_form.comment.value=="")
	{
		alert("내용을 입력하세요.");
		document.value_form.comment.focus();
		return;
	}
	if(!confirm('입력하시겠습니까?'))
	{
		return;
	}
	document.value_form.submit();
}

function value_delchk(value_no)
{
	if(!confirm('삭제하시겠습니까?'))
	{
		return;
	}
	del_form.value_no.value=value_no;
	del_form.action="value_ok.php";
	del_form.submit();
}

</SCRIPT>

<!--List-->
<div class="ps_table ma_top10">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--value_form start-->
<form name="value_form" method="post" action="value_ok.php">
<input type="hidden" name="mode" value="update">
<input type="hidden" name="value_no" value="<?=$row[value_no]?>">
<input type="hidden" name="page" value="<?=$page?>">
	<colgroup>
		<col width="17%">
		<col width="83%">
	</colgroup>
	<tfoot>
		<tr>
			<td scope="col" colspan="2" class="tfoot"></td>
		</tr>
	</tfoot>
	<tbody>
		<!--
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">이름</p></td>
			<td scope="col">
				<p class="ma_left15"><input type="text" name="text" style="width:400px;"></p>
			</td>
		</tr>
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">비밀번호</p></td>
			<td scope="col">
				<p class="ma_left15"><input type="password" name="text" style="width:150px;">
					<span class="ma_left15 f11">(글 수정/삭제시 필요합니다.)</span>
				</p>
			</td>
		</tr>
		-->
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">제목</p></td>
			<td scope="col">
				<p class="ma_left15"><input type="text" name="subject" value="<?=$row[value_subject]?>" style="width:520px;"></p>
			</td>
		</tr>
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">제품평가</p></td>
			<td scope="col">
				<p class="ma_left15">
					<input type="radio" name="rate" id="rate" value="5" onFocus="blur();" class="check"> 매우좋음
					<span class="ma_left20"><input type="radio" name="rate" id="rate" value="4" onFocus="blur();" class="check"> 좋음</span>
					<span class="ma_left20"><input type="radio" name="rate" id="rate" value="3" onFocus="blur();" class="check"> 보통</span>
					<span class="ma_left20"><input type="radio" name="rate" id="rate" value="2" onFocus="blur();" class="check"> 나쁨</span>
					<span class="ma_left20"><input type="radio" name="rate" id="rate" value="1" onFocus="blur();" class="check"> 매우나쁨</span>
				</p>
			</td>
		</tr>
		<script language="javascript">
		  for(i=0; i<document.value_form.rate.length; i++)
		  {
			  if(document.value_form.rate[i].value=="<?=$row[value_rate]?>")
			  {
				  document.value_form.rate[i].checked=true;
			  }
		  }
		</script> 
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">내용</p></td>
			<td scope="col">
				<p class="ma_left15"><textarea name="comment" id="comment" style="width:520px; height:200px;"><?=$row[value_comment]?></textarea></p>
			</td>
		</tr>
</form>
<!--value_form end-->
	</tbody>
</table>
</div>

<!--버튼-->
<p class="rbtn_list">
<span class="ma_left5"><a href="javascript:value_chk();"><img src="../images/btn/btn_ok.gif"></a></span>
<span class="ma_left5"><a href="javascript:history.back();"><img src="../images/btn/btn_list.gif"></a></span>
</p>

<?php include("foot_board.php");?>
