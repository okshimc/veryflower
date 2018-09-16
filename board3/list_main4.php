<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">

<!--List-->
<div class="board_area">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<colgroup>
		<col width="10%">
		<col width="40%">
		<col width="25%">
		<col width="25%">
	</colgroup>
	<thead>
		<tr>
			<th width="10%" scope="col">No</th>
			<th width="40%" scope="col">제목</th>
			<th width="25%" scope="col">주최</th>
			<th width="25%" scope="col">기간</th>
		</tr>
	</thead>
	<tbody>

		<?php for($i=0; $i<$total_num; $i++):?>
		<tr class="loop_odd tr_on">
			<td scope="col" align="center"><?=$arr[$i]["k"]?></td>
			<td scope="col" align="center"><?=$arr[$i]["w_title"]?></td>
			<td scope="col" align="center"><?=$arr[$i]["w_name"]?></td>
			<td scope="col" align="center"><?=$arr[$i]["w_email"]?></td>
		</tr>
		<?php endfor;?>

	    <?=$norecord_check_start?>
		<tr class="loop_odd tr_on">
			<td colspan="5" scope="col" align="center">검색된 결과가 없습니다.</td>
		</tr>
	    <?=$norecord_check_end?>

		</tbody>
	</table>
</div>

<!--목록넘기기 시작-->
<div class="pagenum_area">
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
<!--목록넘기기 끝-->

<!--검색-->
<div class="board_search">
	<p class="fr ma_left3"><a href="javascript:search_chk();"><img src="../images/btn/btn_search.gif"></a></p>
	<p class="fr ma_left3"><input type="text" name="search_name" style="width:170px;"></p>
	<p class="fr ma_left3">
		  <select name="search_part" class="select_01" style="width:80px;">
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
	</p>
</div><!--검색끝-->

</form>
<!--board_form end-->

<?php include("foot_board.php");?>
