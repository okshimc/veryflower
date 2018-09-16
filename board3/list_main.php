<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr> 
	<td class="pb_10">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
		  <td height="30" align="left">
			<span class="txt_s2">Page :</span>
			<b><?=$page?></b>
			<span class="txt_s2">/ Total :</span>
			<b><?=$total_page?></b>
			</td>
		  <td align="right"> 
			<?=$nopart_check_start?>
			<select name="part" onChange="part_search();">
			  <option value="">분류 선택</option>
			  <?=$part_select_msg?>
			</select>
			<script language="javascript">
			  for(i=0; i<document.board_form.part.length; i++)
			  {
				  if(document.board_form.part[i].value=="<?=$part?>")
				  {
					  document.board_form.part[i].selected=true;
				  }
			  }
			</script> 
			<?=$nopart_check_end?>
			</td>
		</tr>
	  </table>
      </td>
  </tr>
  <tr>
	<td class="pb_10"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
		  <td width="75">
		 <select name="search_part">
		  <option value="w_title">글제목</option>
		  <option value="w_content">글내용</option>
		  <option value="w_name">작성자</option>
	  </select>
			</td>
		  <td width="190">
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
			<input name="search_name" type="text" size="28">
			</td>
            <td width="45">
            <a href="javascript:search_chk();" class="btn_search">검색</a></td>
            <td>&nbsp;</td>
		</tr>
	  </table> 
      </td>
  </tr>
  <tr>
	<td>
   <div class="tableListLayout rndRecruit recruit"> 
    <table summary="리스트로 번호, 제목, 작성자, 작성일, 조회수를 나타냅니다.">
            <caption></caption>
            <colgroup>
            <col width="55" />
            <col />
            <col width="80" />
            <col width="85" />
            <col width="55" />
           </colgroup>
    	<thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
                <th scope="col" class="last">조회수</th>
            </tr>
        </thead>
		<?php for($i=0; $i<$notice_total_num; $i++):?>
		<tbody>
        <tr>
		  <td class="status"><?=$notice_arr[$i]["k"]?></td>
		  <td class="title"><?=$notice_arr[$i]["w_title"]?> <?=$notice_arr[$i]["cmt_row_count"]?></td>
		  <td class="online"><?=$notice_arr[$i]["w_name"]?></td>
		  <td class="online"><?=$notice_arr[$i]["w_date"]?></td>
		  <td class="hit"><?=$notice_arr[$i]["w_read"]?></td>
		</tr>
		<?php endfor;?>

		<?php for($i=0; $i<$total_num; $i++):?>
		<tr>
		  <td class="status"><?=$arr[$i]["k"]?></td>
		  <td class="title"><?=$arr[$i]["w_title"]?> <?=$arr[$i]["cmt_row_count"]?></td>
		  <td class="online"><?=$arr[$i]["w_name"]?></td>
		  <td class="online"><?=$arr[$i]["w_date"]?></td>
		  <td class="hit"><?=$arr[$i]["w_read"]?></td>
		</tr>		
		<?php endfor;?>

	    <?=$norecord_check_start?>
		<tr>
		  <td colspan="5"><div align="center">검색된 결과가 없습니다.</div></td>
		</tr>		
	    <?=$norecord_check_end?>
		</tbody>
	</table>
    </div>
    </td>
  </tr>
  <tr>
	<td>
    <div class="list_number">
       <p>
       <div class="list_n_menu">
       <?=$page_arr["first1"]?>
       <  맨처음
       <?=$page_arr["first2"]?>
       
       <?=$page_arr["prev1"]?>
       <  이전
       <?=$page_arr["prev2"]?>
       <?=$page_arr["list"]?>
       <?=$page_arr["next1"]?>
       다음  >
       <?=$page_arr["next2"]?>
       
       <?=$page_arr["end1"]?>
       마지막  >
       <?=$page_arr["end2"]?>
       </div>
       </p>
 </div>
    </td>
  </tr>
  <tr>
        <td align="right">
        <?=$nowrite_check_start?>
        <a href="write.php?kind_code=<?=$kind_code?>" class="btn_write">쓰기</a>
        <?=$nowrite_check_end?>
        </td>
  </tr> 
</form>
<!--board_form end-->
</table>
<?php include("foot_board.php");?>
