<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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

<!--List-->
<dl class="guide_list">
	<dt></dt>
	<dd>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="23%">
				<col width="77%">
			</colgroup>
			<tbody>
				<tr>
					<th width="23%" scope="col">제목</th>
					<td width="77%" scope="col"><?=$part_title_msg?> <?=$row[w_title]?> </td>
				</tr>
				<tr>
					<th scope="col">주최</th>
					<td scope="col"><?=$row[w_name]?></td>
				</tr>
				<tr>
					<th scope="col">기간</th>
					<td scope="col"><?=$row[w_email]?> </td>
				</tr>
				<tr>
					<th scope="col">첨부파일</th>
					<td scope="col">
					<?=$noappend_check_start?>
					<?php for($i=0; $i<$file_num; $i++){?>
					<a href="down.php?kind_code=<?=$kind_code?>&w_seq=<?=$w_seq?>&sequence=<?=$arr[$i][file_sequence]?>"><?=$arr[$i][file_regname]?></a> (<?=$arr[$i][file_size]?>)
					&nbsp;&nbsp;
					<?php }?>
					<?=$noappend_check_end?>
					</td>
				</tr>
				<tr>
					<th scope="col">내용</th>
					<td scope="col">
					<?=$nogallery_check_start?>
					<?=$gallery_img_msg?>
					<?=$nogallery_check_end?>
					<?//=$file_preview_name?>
					<?=$content?>
					</td>
				</tr>
			</tbody>
		</table>
	</dd>
</dl>

<!--버튼-->
<p class="btn_area">
	<a href="list.php?<?=$view_href?>"><img src="../images/btn/btn_list.gif"></a>
</p>

</form>
<!--board_form end-->

<?php include("foot_board.php");?>
