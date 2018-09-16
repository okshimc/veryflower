<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--List-->
<div class="board_area">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
		<colgroup>
			<col width="10%">
			<col width="55%">
			<col width="35%">
		</colgroup>
		<thead>
			<tr>
				<th scope="col">번호</th>
				<th scope="col">기관명</th>
				<th scope="col">홈페이지</th>
			</tr>
		</thead>
		<tbody>

		  <?php for($i=0; $i<$total_num; $i++){?>
		  <tr class="loop_odd tr_on">
			<td scope="col" align="center"><?=$arr[$i]["k"]?></td>
			<td scope="col" align="center"><?=$arr[$i]["w_title"]?></td>
			<td scope="col" align="center"><?php if($arr[$i]["w_email"]){?><a href="http://<?=$arr[$i]["w_email"]?>" target="_blank"><?=$arr[$i]["w_email"]?></a><?php }?></td>
		  </tr>
		  <?php }?>

		  <?=$norecord_check_start?>
		  <tr class="loop_odd tr_on">
			<td scope="col" colspan="3" align="center">검색된 결과가 없습니다.</td>
		  </tr>
		  <?=$norecord_check_end?>

		</tbody>
	</table>

</div><!--class="board_area" 끝-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td height="30"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td align="center">
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
</form>
<!--board_form end-->
</table>

<?php include("foot_board.php");?>
