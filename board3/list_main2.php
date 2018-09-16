<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">

<div class="board_search">
	<p class="fr ma_left3"><a href="javascript:search_chk();"><img src="../images/btn/btn_search.gif" alt="검색"></a></p>
	<p class="fr ma_left3"><input type="text" name="search_name" style="width:170px;"></p>
	<p class="fr ma_left3">
	  <select name="search_part" class="select_01" style="width:80px;">
		  <option value="w_title">글제목</option>
		  <option value="w_content">글내용</option>
		  <option value="w_name">작성자</option>
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
	</p>
</div>

<!--List-->
<div class="ps_table ma_top10">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="7%">
			<col width="53%">
			<col width="12%">
			<col width="12%">
			<col width="7%">
			<col width="9%">
		</colgroup>
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">제목</th>
				<th scope="col">작성자</th>
				<th scope="col">등록일</th>
				<th scope="col">조회수</th>
				<th scope="col">답변여부</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td scope="col" colspan="6" class="tfoot"></td>
			</tr>
		</tfoot>
		<tbody>

			<?php for($i=0; $i<$total_num; $i++):?>
			<tr class="loop tr_on">
				<td scope="col" align="center"><?=$arr[$i]["k"]?></td>
				<td scope="col"><?=$arr[$i]["w_title"]?></td>
				<td scope="col" align="center"><?=$arr[$i]["w_name"]?></td>
				<td scope="col" align="center"><?=$arr[$i]["w_date"]?></td>
				<td scope="col" align="center"><?=$arr[$i]["w_read"]?></td>
				<td scope="col" align="center"><?=$arr[$i]["w_reply_check"]?></td>
			</tr>
			<?php endfor;?>

		    <?=$norecord_check_start?>
			<tr class="loop tr_on">
				<td scope="col" colspan="6" align="center">검색된 결과가 없습니다.</td>
			</tr>
		    <?=$norecord_check_end?>

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
<p class="rbtn_list01">
<?=$nowrite_check_start?>
<a href="write.php?kind_code=<?=$kind_code?>"><img src="../images/btn/btn_write.gif"></a>
<?=$nowrite_check_end?>
</p>

</form>
<!--board_form end-->

<?php include("foot_board.php");?>
