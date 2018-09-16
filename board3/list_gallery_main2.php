<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
/*  photo_list   */
.photo_list   {position:relative; margin:0 auto; width:100%; border-top:1px solid #9e9e9e; border-bottom:0px solid #9e9e9e; text-align:left;}
.photo_list dl { width:<?=$config_img_width+20?>px; position:relative; display:inline-block;*display:inline;*zoom:1; vertical-align:top; text-align:left; margin:20px 0;}

.photo_list dt { width:<?=$config_img_width?>px; height:<?=$config_img_height?>px; margin:0px 13px; border:1px solid #e3e3e3; }
.photo_list dt a { width:<?=$config_img_width?>px; height:<?=$config_img_height?>px; border:1px solid #e3e3e3; display:block;}
.photo_list dt a:hover { width:<?=$config_img_width?>px; height:<?=$config_img_height?>px; border:1px solid #f8f8f8; }

.photo_list dd   {width:<?=$config_img_width?>px; text-align:center; margin:0px 10px 0 10px; height:20px;}
.photo_list dd p   { margin-top:10px; line-height:130%; font-size:11px;}
.photo_list a   { color:#666666; font-weight:bold;}
.photo_list a:hover   { color:#999999; font-weight:bold;}

.photo_list_txt	{position:relative; margin:0px; padding:15px 0px; width:100%; border-top:1px solid #9e9e9e; border-bottom:1px solid #9e9e9e; text-align:center; }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="mode" value="">
  <tr> 
	<td align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
			<input name="search_name" type="text" size="29">
			</td>
            <td width="45">
            <a href="javascript:search_chk();" class="btn_search">검색</a></td>
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
	  </table>
      </td>
  </tr>
  <tr>
	<td>
		<div class='photo_list'>

        <?php for($i=0; $i<$total_num; $i++){?>
        <dl>
            <dt><?=$arr[$i]["w_fileimg"]?></dt>
            <dd>
                <p><?=$arr[$i]["w_title"]?></p>
            </dd>
        </dl>
		<?php }?>

		</div>

		<?php if($total_num<1){?>
		<p class="photo_list_txt">검색된 결과가 없습니다.</p>
		<?php }?>

		<div class='photo_list'></div>

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
