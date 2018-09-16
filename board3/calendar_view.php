<?php
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");

$sql="select sch_yn, sch_title, sch_content from $schedule_db
								where sch_date='$for_nowday'
								";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="board.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="calendar_view_a">
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="calendar_view">
  <tr>
    <th width="40">제목</th>
    <td><?=nl2br($row[sch_title])?></td>
  </tr>
  <tr>
    <th>내용</th>
    <td class="td_h"><?=nl2br($row[sch_content])?></td>
  </tr>
</table>
    </td>
  </tr>
</table>
<div class="btn_view_a"><a href="javascript:window.close();" class="btn_view">창닫기</a></div>
</body>
</html>
