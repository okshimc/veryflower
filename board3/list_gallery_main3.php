<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">

<dl class="info_list">

	<?php for($i=0; $i<$total_num; $i++){?>
	<dd>
		<table width="100%" border="0" cellspacing="3" cellpadding="8" bgcolor="#EEEEEE">
			<colgroup>
				<col width="70%">
				<col width="30%">
			</colgroup>
			<tbody>
				<tr>
					<th width="23%" align="center" scope="col"><?=$arr[$i]["w_fileimg"]?></th>
					<td width="77%" scope="col">
						<p class="b bottom_10"><?=$arr[$i]["w_title"]?></p>
						<p class="left_5 right_10"><?=$arr[$i]["w_content"]?></p>
					</td>
				</tr>
			</tbody>
		</table>
	</dd>
	<?php }?>

	<?=$norecord_check_start?>
	<dd>
		<table width="100%" border="0" cellspacing="3" cellpadding="8" bgcolor="#EEEEEE">
				<tr>
					<th align="center" scope="col">검색된 결과가 없습니다.</td>
				</tr>
		</table>
	</dd>
	<?=$norecord_check_end?>

</dl>
	
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
