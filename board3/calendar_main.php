<?php

if(!$iyear)
{
	$iyear  = date("Y");
}
if (!$imonth)
{
    $imonth = date("m");
}
if (!$iday)
{
    $iday  = date("d");
}
if (!$itime)
{
    $itime  = date("H:i:s");
}

$year = sprintf("%04d", $iyear);
$month = sprintf("%02d", $imonth);
$day = sprintf("%02d", $iday);

$maxday = date(t, mktime(0, 0, 0, $month, 1, $year));

$prevmonth = $month - 1;
$nextmonth = $month + 1;
$prevyear = $year;
$nextyear = $year;

if($month == 1)
{
  $prevmonth = 12;
  $prevyear = $year - 1;
}

else if($month == 12)
{
  $nextmonth = 1;
  $nextyear = $year + 1;
}

echo("
<style type='text/css'>

table{
	font-size: 12px;
	color: #666666;
}

.red{
	color: #FFFFFF;
	background: #990000;
}

.blue{
	color: #FFFFFF;
	background: #003366;
}

.gray{
	color: #4e4e4e;
	background: #efefef;
}

img{border:none;}

</style>

<script language=javascript>
function showtip(for_nowday, for_no) {
	 window.open('calendar_view.php?for_nowday='+for_nowday+'&for_no='+for_no,'calendar_view','resizable=no,scrollbars=yes,status=yes,width=500,height=600');
}
</script>
<div id='calendar'>
<header>
	<h3> <span>".$year."</span>년 <span>".$month."</span>월 </h3>
	<div class='btnMove'>
		<a href=$PHP_SELF?iyear=$prevyear&imonth=$prevmonth class='btnPrev'><img src='img/btn_prev.gif' align='absmiddle'></a>
		<a href=$PHP_SELF?iyear=$nextyear&imonth=$nextmonth class='btnNext'><img src='img/btn_next.gif' align='absmiddle'></a>
	</div>
</header>
<table>
<caption>일정표</caption>
<colgroup>
	<col />
	<col />
	<col />
	<col />
	<col />
	<col />
	<col />
</colgroup>

	<thead>
		<tr>
			<th scope='col'>일</th>
			<th scope='col'>월</th>
			<th scope='col'>화</th>
			<th scope='col'>수</th>
			<th scope='col'>목</th>
			<th scope='col'>금</th>
			<th scope='col'>토</th>
		</tr>
	</thead>
	
<tbody>          
                        
      <tr>
");

for($forday=1; $forday<=$maxday; $forday++)
{
	$for_nowday=$year.$month.sprintf("%02d", $forday);

	if ($forday == "1")
	{
		$dayno = date("w", mktime(0, 0, 0, $month, $forday, $year));

		for ($i = 1; $i <= $dayno; $i++)
		{
			echo("<td class='no'>&nbsp;</td>");
		}
	}

	//일요일이면
	if($dayno=="0")
	{
		$for_color="#d30000";
	}
	//토요일이면
	else if($dayno=="6")
	{
		$for_color="#1c53c3";
	}
	//평일이면
	else
	{
		$for_color="#535353";
	}

	$for_title_msg="";
	$for_content_msg="";
	$for_msg="&nbsp;";
	$for_bgcolor="#efefef";

	$for_sql="select sch_no, sch_yn, sch_title, sch_content from $schedule_db
									where sch_date='$for_nowday'
									";
	$for_result=mysql_query($for_sql, $connect);
	
	while($for_row=mysql_fetch_array($for_result))
	{
		if($for_row[sch_title])
		{
			//$for_msg=nl2br($for_row[sch_title]);
			if($for_row[sch_yn]=="2") $for_color="#d30000";

			$for_bgcolor="#C8C8E3";
			$for_no=$for_row[sch_no];

			$for_title_msg.="<a href=\"javascript:showtip('$for_nowday','$for_no');\">".str_replace("\r\n", "<br>", $for_row[sch_title])."</a><br>";
			//$for_content_msg.=str_replace("\r\n", "<br>", $for_row[sch_content]);
		}

	}

	echo("<td bgcolor='$for_bgcolor' style=\"cursor:default;\" class=\"black\"><font color='$for_color'><strong>$forday</strong><ul><li>$for_title_msg</li></ul></font></td>");

	/*
	if($forday == $iday)
	{
		echo("
			<td height='70' bgcolor='$for_color'>
			<a href=$PHP_SELF?mode=view&iyear=$year&imonth=$month&iday=$forday>
			<font color='red'><b>$forday</b><br>$for_msg</font></a></td>
			");
	}
	else
	{
		echo("
			<td height='70' bgcolor='$for_color'>
			<a href=$PHP_SELF?mode=view&iyear=$year&imonth=$month&iday=$forday>
			 <b>$forday</b><br>$for_msg</a></td>
			");
	}
	*/
	
	$dayno++;
	
	if($dayno == 7)
	{
		echo("</tr>");

		if($forday <= $maxday)
		{
			echo("<tr>");
		}
		$dayno = 0;
	}
}

if($dayno != 0)
{
	$leftday = 7 - $dayno;

	for($i = 1; $i <= $leftday; $i++)
	{
		echo("<td class='no'>&nbsp;</td>");
	}
	
	echo("</tr>");
}

echo("
			
  </tr>
</table>
</div>
");

?>