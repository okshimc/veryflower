<? $top_menu="sub" ?>
<? $page_num_depth_01="4" ?>
<? $page_num_depth_02="2" ?>
<? $sub_visual="4" ?>
<?php
if($agency_type=="2") $page_num_depth_02="1";
?>
<?php include("../include/head.php");?>

<body>
<div id="wrap">
	<!-- 헤더 -->
	<?php include("../include/header.php");?>
	<!-- //헤더 -->
    <!-- 서브 컨텐츠 -->
	<div id="sub_contants">
		<!-- left 컨텐츠 -->
		<div id="le_con">
			<!-- lnb -->
			<?php include("../include/lnb.php");?>
			<!-- //lnb -->
		</div>
		<!-- //left 컨텐츠 -->
		<!-- right 컨텐츠 -->
		<div id="ri_con">
			<!-- 네비 -->
			<div class="navi">
				<ul>
					<li>HOME</li>
					<li><img src="../image/common/navi_arrow.gif"></li>
					<li>회원사 커뮤니티</li>
					<li><img src="../image/common/navi_arrow.gif"></li>
					<li><span><?=$board_name?></span></li>
				</ul>
			</div>
			<!-- //네비 -->
			<!-- 타이틀 -->
			<div class="title"><img src="../image/<?=$board_title_img1?>"></div>
			<!-- //타이틀 -->
			<!-- 컨텐츠 -->
			<div class="con">

<SCRIPT LANGUAGE="JavaScript">
function search_chk()
{
	document.agency_form.action="";
	document.agency_form.submit();
}

function zoom_open(img)
{
	window.open("zoom_agency.php?img="+img,"zoom","resizable=no,scrollbars=yes,status=yes,width=420,height=400");
}
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--agency_form start-->
<form name="agency_form" method="post" action="">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="image/search_t.gif"></td>
      </tr>
      <tr>
        <td class="search_area"><table width="82%" border="0" align="center" cellspacing="0" cellpadding="0">
            <tr>
              <td width="10%"><img src="image/search_title.gif" align="absmiddle"></td>
              <td class="p_l10">
			    <select name="search_part" class="select_02" style="width:100px;height:22">
				  <option value=""> --검색선택--</option>
				  <option value="agency_name">대리점</option>
				  <option value="agency_area">주소</option>
				  <option value="agency_phone">전화번호</option>
                </select>
              </td>
              <td class="p_l10"><input type="text" style="width:280px" class="search_box" name="search_name" /></td>
              <td class="p_l5"><a href="javascript:search_chk();"><img src="image/btn_seach.gif"></a></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="image/search_b.gif"></td>
      </tr>
    </table></td>
  </tr>
  <?php if($agency_type!="2"){?>
  <tr>
    <td align="center" class="p_t20"><table width="96%" border="0" align="center" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="image/search_t.gif"></td>
      </tr>
      <tr>
        <td align="center" class="ip_box_cen p_t10 p_b10"><table width="70%" border="0" align="center" cellspacing="0" cellpadding="0">
          <tr>
            <td width="340" valign="top"><script>flash_contents('../flash/map.swf','250','350','');</script></td>
            <td valign="top" class="p_t60" align="left"><img src="image/guide_img01.gif"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="image/search_b.gif"></td>
      </tr>
    </table></td>
  </tr>
  <?php }?>
  <tr>
    <td class="p_t40"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="board_bar"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="10%" align="center"><img src="image/b_t_area.gif"></td>
                    <td width="1%" align="left"><img src="image/bar_line.gif"></td>
                    <td width="16%" align="center"><img src="image/b_t_agency.gif"></td>
                    <td width="1%" align="left"><img src="image/bar_line.gif"></td>
                    <td width="40%" align="center"><img src="image/b_t_add.gif"></td>
                    <td width="1%" align="left"><img src="image/bar_line.gif"></td>
                    <td width="15%" align="center"><img src="image/b_t_tel.gif"></td>
                    <td width="1%" align="left"><img src="image/bar_line.gif"></td>
                    <td width="15%" align="center"><img src="image/b_t_fax.gif"></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">

			  <?php for($i=0; $i<$total_num; $i++):?>
              <tr>
                <td class="board_center"><table width="96%" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10%" align="center"><?=$arr[$i]["agency_local"]?></td>
                    <td width="16%" align="center"><a href="list_agency_view.php?<?=$arr[$i][view_href]?>"><?=$arr[$i]["agency_name"]?></a></td>
                    <td width="40%" align="left" class="p_l10"><?=$arr[$i]["agency_area"]?></td>
                    <td width="16%" align="center"><?=$arr[$i]["agency_phone"]?></td>
                    <td width="15%" align="center"><?=$arr[$i]["agency_site"]?></td>
                  </tr>
                </table></td>
              </tr>
			  <?php endfor;?>

            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top" class="board_num"><table border="0" align="center" cellspacing="0" cellpadding="0">
		  <tr>
			<td><?=$page_arr["first1"]?><img src="image/arrow_l_d.gif"><?=$page_arr["first2"]?></td>
			<td class="p_l5 p_r5"><?=$page_arr["prev1"]?><img src="image/arrow_l.gif"><?=$page_arr["prev2"]?></td>
			<td align="center" class="pl5_pr5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td align="center"><?=$page_arr["list"]?></td>
				</tr>
			</table></td>
			<td class="p_l5 p_r5"><?=$page_arr["next1"]?><img src="image/arrow_r.gif"><?=$page_arr["next2"]?></td>
			<td><?=$page_arr["end1"]?><img src="image/arrow_r_d.gif"><?=$page_arr["end2"]?></td>
		  </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</form>
</table>

			</div>
			<!-- //컨텐츠 -->
		</div>
		<!-- //right 컨텐츠 -->
	</div>
	<!-- //서브 컨텐츠 -->
	<!-- 푸터 -->
	<?php include("../include/footer.php");?>
	<!-- //푸터 -->
	<!-- 퀵메뉴 -->
	<?php include("../include/quick.php");?>
	<!-- //퀵메뉴 -->
</div>
</body>
</html>
