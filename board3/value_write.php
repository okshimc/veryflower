<?php
session_start();
include("../inc/dbcon.php");
include("../inc/db_sql.php");
include("../inc/function.php");

if(!$brand_code) $brand_code=1;

if(!$_SESSION[ok_id])
{
	$html="$home_path/shop/value_write.php?brand_code=$brand_code";
	echo("
		<script language='javascript'>
			alert('상품평은 회원만 작성할수 있습니다.');
			history.back();
		</script>
		");
	exit();
}

$cfg_sql="select cfg_valuecnt from $config_db";
$cfg_result=mysql_query($cfg_sql, $connect);
$cfg_row=mysql_fetch_array($cfg_result);

$sql="select count(value_no) from $brand_value_db where value_id='$_SESSION[ok_id]'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

if($row[0]>=$cfg_row[cfg_valuecnt])
{
	echo("
		<script language='javascript'>
			alert('상품평은 하루에 $cfg_row[cfg_valuecnt]번 이상 작성할수 없습니다.');
			history.back();
		</script>
		");
	exit();
}

$sql2="select brand_name from $brand_db where brand_code='$brand_code'";
$result2=mysql_query($sql2, $connect);
$row2=mysql_fetch_array($result2);
$brand_name=$row2[brand_name];

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
<input type="hidden" name="brand_code" value="<?=$brand_code?>">
<input type="hidden" name="brand_name" value="<?=$brand_name?>">
<input type="hidden" name="mode" value="insert">
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
				<p class="ma_left15"><input type="text" name="subject" style="width:520px;"></p>
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
		<tr>
			<td scope="col" class="ps_th"><p class="ma_left25">내용</p></td>
			<td scope="col">
				<p class="ma_left15"><textarea name="comment" id="comment" style="width:520px; height:200px;"></textarea></p>
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
