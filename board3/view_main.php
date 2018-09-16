<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
.p_view_content_css p { margin-top:8px; margin-bottom:8px;}
img {
max-width:800px; 
width: expression(this.width > 800 ? 800: true); 
height: auto;}
</style>

<script type="text/javascript">
<!--
function list() {
	location.href = "news.asp?board=news&board_group=0&";
}

function reply() {
	location.href = "reply.asp?board=news&board_group=0&uid=547&params=";
}

function edit() {
	location.href = "write.asp?board=news&board_group=0&uid=547&params=";
}

function del() {
	location.href = "check_pass.asp?board=news&board_group=0&uid=547&mode=del&params=";
}
//-->
</script>

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
   <!-- 게시판 내용 뷰-->
    <div class="tableViewLayout rndRecruit">
            <div class="title">
                <strong><?=$part_title_msg?> <?=$row[w_title]?></strong>
                <span class="date"><?=substr($row[w_date], 0, 10)?></span>
            </div>

            <ul class="info">
                <li class="f-clear">
                    <dl>
                        <dt class="center">작성자</dt>
                        <dd><a href="mailto:<?=$row[w_email]?>"><?=$row[w_name]?></a></dd>
                    </dl>
                    <dl class="rbox">
                        <dt>조회수</dt>
                        <dd><?=$row[w_read]?></dd>
                    </dl>
                </li>
               
                <?=$noappend_check_start?>
                <?php for($i=0; $i<$file_num; $i++){?>
                    <li class="f-clear">
                    <dl>
                        <dt class="center">첨부 <?=$arr[$i]["k"]?></dt>
                        <dd><a href="down.php?kind_code=<?=$kind_code?>&w_seq=<?=$w_seq?>&sequence=<?=$arr[$i][file_sequence]?>" target="_blank"><?=$arr[$i][file_orgname]?></a> (<?=$arr[$i][file_size]?>)</dd>
                    </dl>
                </li>
                <?php }?>
                <?=$noappend_check_end?>
            </ul>

            <div class="cont">
            <?php if($kind_code==200){?>
            <?php if($row[w_email]){?>
            <embed src="<?=$row[w_email]?>" wmode="transparent"></embed><br><br>
            <?php }?>
            <?php }?>
            <?=$file_preview_name?>
            <?=$nogallery_check_start?>
            <?=$gallery_img_msg?>
            <?=$nogallery_check_end?>
            <?=$content?>
            </div>
            
            <div class="apply_action center">
            
            </div>
                <ul class="listPrevNext">
                       <?=$noprev_check_start?>
                        <li class="prev"><span class="h">이전글</span><span class="tit"><?=$part_title_msg2?>
            <a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row2[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row2[w_title]?></a></span><span class="date"><?=substr($row2[w_date], 0, 10)?></span></li>
                         <?=$noprev_check_end?>
                         <?=$nonext_check_start?>
                        <li class="next"><span class="h">다음글</span><span class="tit"><?=$part_title_msg3?>
            <a href="view.php?kind_code=<?=$kind_code?>&w_seq=<?=$row3[w_seq]?>&page=<?=$page?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>"><?=$row3[w_title]?></a></span><span class="date"><?=substr($row3[w_date], 0, 10)?></span></li>
                        <?=$nonext_check_end?>	
                       </ul>
               
             	  <div class="btn_board_a">
                        <?=$nowrite_check_start?>
                        <a href="javascript:view_chk('edit');" class="btn_board" >수정</a>
                        <?php if( strlen($_SESSION[ok_id])>0 && ($_SESSION[ok_id]==$row[w_id]) ){?>
                        <a href="javascript:view_chk('direct_del');" class="btn_board" >삭제</a>
                        <?php }else{?>
                         <a href="javascript:view_chk('del');" class="btn_board" >삭제</a>
                        <?php }?>
                        <?=$nowrite_check_end?>
		  				<?=$noreply_check_start?>
                        <a href="javascript:view_chk('reply');" class="btn_board">답변</a>
                        <?=$noreply_check_end?>
						<?=$nowrite_check_start?>
                        <a href="write.php?kind_code=<?=$kind_code?>" class="btn_board">쓰기</a>
                        <?=$nowrite_check_end?>
                        <a href="list.php?<?=$view_href?>" class="btn_board">목록</a>
                   </div>
                    
                    
               
                <div class="btn_wrap">
                
            </div> 
        </div>
    <!-- //게시판 내용 뷰-->
</form>

<?php //include("view_list_prevnext.php");?>
<?php
if($tmp_row[kind_commentcheck]=="1") include("comment_view.php");
?>
<?php //include("view_list_main.php");?>
<?php include("foot_board.php");?>
