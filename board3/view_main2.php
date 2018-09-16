<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div class="ps_table ma_top10">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="search_part" value="<?=$search_part?>">
<input type="hidden" name="search_name" value="<?=$search_name?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="part" value="<?=$part?>">
<input type="hidden" name="mode" value="">
		<colgroup>
			<col width="81%">
			<col width="9%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th scope="col">제목</th>
				<th scope="col">등록일</th>
				<th scope="col">조회수</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td scope="col" colspan="3" class="tfoot">
					<table width="100%">
						<colgroup>
							<col width="15%">
							<col width="85%">
						</colgroup>
						<tr class="loop_odd tr_on">
							<td scope="col" align="center" class="ps_th">다음글</td>
							<td scope="col" class="pad_ps01"><a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row2[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row2[w_title]?></a></td>
						</tr>
						<tr class="loop_odd tr_on">
							<td scope="col" align="center" class="ps_th">이전글</td>
							<td scope="col" class="pad_ps01"><a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row3[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row3[w_title]?></a></td>
						</tr>
					</table>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td scope="col" class="ff_brwon02"><?=$part_title_msg?> <?=$row[w_title]?></td>
				<td scope="col" align="center" class="ff_brwon02"><?=substr($row[w_date], 0, 10)?></td>
				<td scope="col" align="center" class="ff_brwon02"><?=$row[w_read]?></td>
			</tr>
			<tr>
				<td scope="col" colspan="3" class="pad_ps">

					<!--질문 영역-->
					<div class="ma_bottom15">
					<?=$noappend_check_start?>
					<?php for($i=0; $i<$file_num; $i++){?>
					<p class="board_file"><?=$arr[$i][file_regname]?> <span class="new_icon"><a href="down.php?kind_code=<?=$kind_code?>&w_seq=<?=$w_seq?>&sequence=<?=$arr[$i][file_sequence]?>"><img src="../images/btn/icon_file.gif"></a></span></p>
					<?php }?>
					<?=$noappend_check_end?>

					<!--이미지 가로값이 700px 넘지 않도록 합니다~!-->
					<?=$nogallery_check_start?>
					<?=$gallery_img_msg?>
					<?=$nogallery_check_end?>
					<?//=$file_preview_name?>
					<?=$content?>
					</div>
					
					<!--답변 영역-->
					<div class="ps_txt02">
                      <?php
					  if($row[w_reply]) echo $row[w_reply];
					  else echo "답변준비중입니다.";
					  ?>
					</div>

				</td>
			</tr>
</form>
<!--board_form end-->
		</tbody>
	</table>
</div>

<!--btn-->
<p class="align_r btn_area">
	<?=$nowrite_check_start?>
	<span class="ma_left5"><a href="javascript:view_chk('edit');"><img src="../images/btn/btn_modify.gif"></a></span>
	<?php if( strlen($_SESSION[ok_id])>0 && ($_SESSION[ok_id]==$row[w_id]) ){?>
	<span class="ma_left5"><a href="javascript:view_chk('direct_del');"><img src="../images/btn/btn_delete.gif"></a></span>
	<?php }else{?>
	<span class="ma_left5"><a href="javascript:view_chk('del');"><img src="../images/btn/btn_delete.gif"></a></span>
	<?php }?>
	<?=$nowrite_check_end?>
	<span class="ma_left5"><a href="list.php?<?=$view_href?>"><img src="../images/btn/btn_list.gif" alt="목록보기"></a></span>
</p>

<?php include("foot_board.php");?>
