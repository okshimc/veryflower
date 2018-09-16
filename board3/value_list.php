<?php
session_start();
include("../inc/dbcon.php");
include("../inc/db_sql.php");
include("../inc/function.php");
include("../inc/paging_function.php");

/* 페이지 나누기 초기 설정값 */
if(!$page) //넘어온 현재 페이지값이 없으면...
{
   $page=1;
}
$record_set=10; //한 페이지에 출력되는 레코드의 갯수
$start_record=($page-1)*$record_set; // 쿼리의 시작점...
$page_set=10; //한 페이지에 출력되는 아래 링크의 갯수

$page_sql="select value_no from $brand_value_db";
$page_result=mysql_query($page_sql, $connect);

$total_record=mysql_num_rows($page_result); //총 레코드의 갯수
$total_page=ceil($total_record/$record_set); //총 페이지의 갯수

$default_href="$PHP_SELF?";
$page_arr=page_list($total_page, $page_set, $page, $default_href); //페이지 나누기 함수 실행

$sql="select * from $brand_value_db
			order by value_no desc
			limit $start_record, $record_set";
$result=mysql_query($sql, $connect);
$list_cnt=mysql_num_rows($result);

if($list_cnt>0)
{
	$nocnt_check_start="<!--";
	$nocnt_check_end="-->";
}

$f=0;
$k=($total_record-$record_set*($page-1))+1;
while($row=mysql_fetch_array($result))
{
	$k--;
	$arr[$f]["k"]=$k;

	$sql2="select brand_smallimg
					from $brand_db
					where brand_code='$row[value_brandcode]'";
	$result2=mysql_query($sql2, $connect);
	$row2=mysql_fetch_array($result2);
	$arr[$f]["brand_smallimg"]=$row2[brand_smallimg];

	if($row[value_rate]==5) $value_rate="★★★★★";
	else if($row[value_rate]==4) $value_rate="★★★★☆";
	else if($row[value_rate]==3) $value_rate="★★★☆☆";
	else if($row[value_rate]==2) $value_rate="★★☆☆☆";
	else if($row[value_rate]==1) $value_rate="★☆☆☆☆";
	else $value_rate="";

	$arr[$f]["value_rate"]=$value_rate;
	$arr[$f]["value_no"]=$row[value_no];
	$arr[$f]["value_brandcode"]=$row[value_brandcode];
	$arr[$f]["value_brandname"]=$row[value_brandname];
	$arr[$f]["value_name"]=$row[value_name];
	$arr[$f]["value_subject"]=cut_str($row[value_subject], 60);
	$arr[$f]["value_comment"]=$row[value_comment];
	$arr[$f]["value_date"]=$row[value_date];
	$f++;
}

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

<!--del_form start-->
<form name="del_form" method="post" action="">
<input type="hidden" name="value_no" value="">
<input type="hidden" name="mode" value="delete">
</form>
<!--del_form end-->

<div class="board_search">
	<p class="fr ma_left3"><a href="#"><img src="../images/btn/btn_search.gif" alt="검색"></a></p>
	<p class="fr ma_left3"><input type="text" name="text" style="width:170px;"></p>
	<p class="fr ma_left3">
		<select name="select" class="select_01" style="width:80px;">
			<option>전체</option>
			<option>제목</option>
			<option>내용</option>
			<option>작성자</option>
		</select>
	</p>
</div>

<!--List-->
<div class="ps_table ma_top10">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="6%">
			<col width="45%">
			<col width="15%">
			<col width="10%">
			<col width="12%">
			<col width="6%">
			<col width="6%">
		</colgroup>
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">제목</th>
				<th scope="col">작성자</th>
				<th scope="col">작성일</th>
				<th scope="col">평점</th>
				<th scope="col">수정</th>
				<th scope="col">삭제</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td scope="col" colspan="7" class="tfoot"></td>
			</tr>
		</tfoot>
		<tbody id="psList">

			<?php for($i=0; $i<$list_cnt; $i++){?>
			<tr class="loop tr_on">
				<td scope="col" align="center"><?=$arr[$i]["k"]?></td>
				<td scope="col"><a href="javascript:void_List_OnClick('<?=$arr[$i]["k"]?>');"><?=$arr[$i]["value_subject"]?></a> </td>
				<td scope="col" align="center"><?=$arr[$i]["value_name"]?></td>
				<td scope="col" align="center"><?=$arr[$i]["value_date"]?></td>
				<td scope="col" align="center" class="ff_brwon"><?=$arr[$i]["value_rate"]?></td>
				<td scope="col" align="center"><?php if($arr[$i]["value_id"]!=$_SESSION[ok_id]){?><a href="value_edit.php?value_no=<?=$arr[$i]["value_no"]?>"><img src="../images/btn/shop_modify.gif"></a><?php }?></td>
				<td scope="col" align="center"><?php if($arr[$i]["value_id"]!=$_SESSION[ok_id]){?><a href="javascript:value_delchk('<?=$arr[$i]["value_no"]?>');"><img src="../images/btn/shop_del.gif"></a><?php }?></td>
			</tr>
			<tr class="loop tr_on">
				<td scope="col" colspan="7" class="ps_bdno">
					<p class="ps_txt" id="eview<?=$arr[$i]["k"]?>" style="display:none;">
						<?=$arr[$i]["value_comment"]?>
					</p>
				</td>
			</tr>
			<?php }?>

		    <?=$nocnt_check_start?>
		    <tr>
			  <td height="30" align="center" colspan="7">남기신 상품문의가 없습니다.</td>
		    </tr>
		    <?=$nocnt_check_end?>

		</tbody>
	</table>
</div>

<!--목록넘기기-->
<div id="pagenum_b" class="ma_top15">
	<span>
		<?=$page_arr["first1"]?><img src="../images/btn/btn_first.gif"><?=$page_arr["first2"]?>
		<?=$page_arr["prev1"]?><img src="../images/btn/btn_prev.gif"><?=$page_arr["prev2"]?>
	</span>
	<span>
		<?=$page_arr["list"]?>
	</span>
	<span>
		<?=$page_arr["next1"]?><img src="../images/btn/btn_next.gif"><?=$page_arr["next2"]?>
		<?=$page_arr["end1"]?><img src="../images/btn/btn_last.gif"><?=$page_arr["end2"]?>
	</span>
</div>

<!--버튼-->
<p class="rbtn_list01"><a href="value_write.php"><img src="../images/btn/btn_write.gif"></a></p>


<?php include("foot_board.php");?>
