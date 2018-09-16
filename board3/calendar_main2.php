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
#tooltip {
	position:absolute;
	top:0;
	left:0;
	border:solid 1 black;
	background:gray;
	color:white;
	font-size:9pt;
	/* width:300; */
	height:auto;
	padding:2;
	overflow:hidden;
	z-index:10;
	display:none;
}

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
function showtip(text) {
	 tooltip.innerHTML=text;
	 tooltip.style.display='inline';
}
function hidetip() {
	 tooltip.style.display='none';
}
function movetip() {
	 tooltip.style.pixelTop=event.y+document.body.scrollTop;
	 //tooltip.style.pixelLeft=event.x+document.body.scrollLeft-300;
}
document.onmousemove=movetip;
</script>
<span id=tooltip></span>

<table width='650' border='0' cellpadding='0' cellspacing='7' bgcolor='#efefef' style='word-break:break-all;'>
  <tr>
    <td><table width='100%' border='0' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF'>
      <tr>
        <td height='30' align='center'><b><a href=$PHP_SELF?iyear=$prevyear&imonth=$prevmonth><img src='../images/prev_year.gif' align='absmiddle'></a>&nbsp;&nbsp; ".date("F", mktime(1,1,1,$month,$day,$year))." ".$year." &nbsp;&nbsp;<a href=$PHP_SELF?iyear=$nextyear&imonth=$nextmonth><img src='../images/next_year.gif' align='absmiddle'></a></b></td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='2' cellpadding='3'>
          <tr align='center' valign='top' height='60'>
            <td width='14%' height='34' class=gray><b>Mon</b></td>
            <td width='14%' height='34' class=gray><b>Tue</b></td>
            <td width='14%' height='34' class=gray><b>Wed</b></td>
            <td width='14%' height='34' class=gray><b>Thu</b></td>
            <td width='14%' height='34' class=gray><b>Fri</b></td>
            <td width='14%' height='34' class=blue><b>Sat</b></td>
            <td width='14%' height='34' class=red><b>Sun</b></td>
          </tr>
        </table>
		
		<table width='100%' border='0' cellspacing='2' cellpadding='3'>
          <tr align='center' valign='top' height='60'>
");

for($forday=1; $forday<=$maxday; $forday++)
{
	$for_nowday=$year.$month.sprintf("%02d", $forday);

	if ($forday == "1")
	{
		// 변경전 -> 0:일 1:월 2:화 ~ 6:토
		// 변경후 -> 1:월 2:화 ~ 6:토 7:일
		$dayno = date("w", mktime(0, 0, 0, $month, $forday, $year));
		if($dayno=="0") $dayno = "7";

		for ($i = 1; $i < $dayno; $i++)
		{
			echo("<td width='14%' height='70' bgcolor='#efefef'><p>&nbsp;</p></td>");
		}
	}

	//일요일이면
	if($dayno=="7")
	{
		$for_color="#FF0000";
	}
	//토요일이면
	else if($dayno=="6")
	{
		$for_color="#3333FF";
	}
	//평일이면
	else
	{
		$for_color="#535353";
	}

	$for_sql="select sch_yn, sch_title, sch_content from $schedule_db
									where sch_date='$for_nowday'
									and sch_yn='1'";
	$for_result=mysql_query($for_sql, $connect);
	$for_row=mysql_fetch_array($for_result);

	if($for_row[sch_title])
	{
		//$for_msg=nl2br($for_row[sch_title]);
		$for_bgcolor="#C8C8E3";
		$for_title_msg=str_replace("\r\n", "<br>", $for_row[sch_title]);
		$for_content_msg=str_replace("\r\n", "<br>", $for_row[sch_content]);
		if(strlen($for_row[sch_content])<20)
		{
			$style_msg="tooltip.style.width=100; tooltip.style.pixelLeft=event.x+document.body.scrollLeft-100;";
		}
		else if(strlen($for_row[sch_content])>20 && strlen($for_row[sch_content])<50)
		{
			$style_msg="tooltip.style.width=200; tooltip.style.pixelLeft=event.x+document.body.scrollLeft-200;";
		}
		else
		{
			$style_msg="tooltip.style.width=300; tooltip.style.pixelLeft=event.x+document.body.scrollLeft-300;";
		}

		echo("<td width='14%' height='70' bgcolor='$for_bgcolor' style=\"cursor:default;\" onMouseOver=\"showtip('$for_content_msg');$style_msg\" onMouseOut=\"hidetip();\" class=\"black\"><div align=center><font color='$for_color'>$forday<br>$for_title_msg</font></div></td>");
	}
	else
	{
		$for_msg="&nbsp;";
		$for_bgcolor="#efefef";

		echo("<td width='14%' height='70' bgcolor='$for_bgcolor' style=\"cursor:default;\" class=\"black\"><div align=center><font color='$for_color'>$forday</font></div></td>");
	}

	/*
	if($forday == $iday)
	{
		echo("
			<td width='14%' height='70' bgcolor='$for_color'>
			<a href=$PHP_SELF?mode=view&iyear=$year&imonth=$month&iday=$forday>
			<font color='red'><b>$forday</b><br>$for_msg</font></a></td>
			");
	}
	else
	{
		echo("
			<td width='14%' height='70' bgcolor='$for_color'>
			<a href=$PHP_SELF?mode=view&iyear=$year&imonth=$month&iday=$forday>
			 <b>$forday</b><br>$for_msg</a></td>
			");
	}
	*/
	
	$dayno++;
	
	if($dayno == 8)
	{
		echo("</tr>");

		if($forday <= $maxday)
		{
			echo("<tr align='center' valign='top' height='60'>");
		}
		$dayno = 1;
	}
}

if($dayno != 8)
{
	$leftday = 8 - $dayno;

	for($i = 1; $i <= $leftday; $i++)
	{
		echo("<td width='14%' height='70' bgcolor='#efefef'><p>&nbsp;</p></td>");
	}
	
	echo("</tr>");
}

echo("
			</table>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
");

?>
