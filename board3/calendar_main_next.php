<?php

if(!$i2year)
{
	$i2year  = date("Y");
}
if (!$i2month)
{
	if(date("m") == 12)
	{
	  $i2month = 1;
	  $i2year = date("Y") + 1;
	}
	else
	{
		$i2month = date("m") + 1;
	}
}
if (!$i2day)
{
    $i2day  = 1;
}
if (!$i2time)
{
    $i2time  = date("H:i:s");
}

$year = sprintf("%04d", $i2year);
$month = sprintf("%02d", $i2month);
$day = sprintf("%02d", $i2day);

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
#tooltip2 {
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
function showtip2(text) {
	 tooltip2.innerHTML=text;
	 tooltip2.style.display='inline';
}
function hidetip2() {
	 tooltip2.style.display='none';
}
function movetip2() {
	 tooltip2.style.pixelTop=event.y+document.body.scrollTop;
	 //tooltip2.style.pixelLeft=event.x+document.body.scrollLeft-300;
}
document.onmousemove=movetip;
</script>
<span id=tooltip2></span>

<table width='650' border='0' cellpadding='0' cellspacing='7' bgcolor='#efefef' style='word-break:break-all;'>
  <tr>
    <td><table width='100%' border='0' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF'>
      <tr>
        <td height='30' align='center'><b>&nbsp;&nbsp; ".$year."년 ".$month."월 &nbsp;&nbsp;</b></td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='2' cellpadding='3'>
          <tr align='center' valign='top' height='60'>
            <td width='14%' height='34' class=red><b>Sun</b></td>
            <td width='14%' height='34' class=gray><b>Mon</b></td>
            <td width='14%' height='34' class=gray><b>Tue</b></td>
            <td width='14%' height='34' class=gray><b>Wed</b></td>
            <td width='14%' height='34' class=gray><b>Thu</b></td>
            <td width='14%' height='34' class=gray><b>Fri</b></td>
            <td width='14%' height='34' class=blue><b>Sat</b></td>
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
		$dayno = date("w", mktime(0, 0, 0, $month, $forday, $year));

		for ($i = 1; $i <= $dayno; $i++)
		{
			echo("<td width='14%' height='70' bgcolor='#efefef'><p>&nbsp;</p></td>");
		}
	}

	//일요일이면
	if($dayno=="0")
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
	
	if($dayno == 7)
	{
		echo("</tr>");

		if($forday <= $maxday)
		{
			echo("<tr align='center' valign='top' height='60'>");
		}
		$dayno = 0;
	}
}

if($dayno != 0)
{
	$leftday = 7 - $dayno;

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
