<? $top_menu="sub" ?>
<? $page_num_depth_01="4" ?>
<? $page_num_depth_02="2" ?>
<? $sub_visual="4" ?>
<?php
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");

$sql="select * from $agency_db
				where agency_no='$agency_no'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>
<?php include("../include/title.php");?>
</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<?php include("../include/js.php");?>
</head>
<body>
<!--헤드--><? include "../include/top_menu.php"?><!--//헤드-->
<!--메인비쥬얼-->
<? include "../include/sub_visual.php"?>
<!--//메인비쥬얼-->
<!--내용-->
<div id="container_sub">
	<div class="content_sub">
		<p class="navi"><img src="../image/sub/icon_navi.gif" align="absmiddle"> Home > 매장찾기 > <strong>매장찾기</strong></p>
		<h1><img src="../image/branch/title_02.gif" width="73" height="29"></h1>
		<div class="contents">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="shop_t01"><?=$row[agency_name]?></td>
                  </tr>
                  <tr>
                    <td class="p_t20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="shop_gall"><?=$row[agency_content]?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
			  </tr>
			  <tr>
				<td class="p_t30" align="center"><a href="list_agency.php?part=<?=$part?>&search_part=<?=$search_part?>&search_name=<?=$search_name?>&page=<?=$page?>" onFocus="blur();"><img src="image/btn_branch_list.gif"></a></td>
			  </tr>
          </table>
		</div>
	</div>
	<? include "../include/left_menu.php"?>
</div>
<!--//내용-->
<!--풋터-->
<? include "../include/footer.php"?>
<!--//풋터-->
</body>
</html>
