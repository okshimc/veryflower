<?php include("top_schedule.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td align="center" valign="top"><br>
	  <table width="560" border="0" cellspacing="0" cellpadding="0">
		<tr> 
		  <td height="94" align="center" background="img/daily_title.gif" style="padding-bottom:44"> 
			<table>
			  <td width="60"><a href="<?=$PHP_SELF?>?iyear=<?=$prevyear?>&imonth=<?=$prevmonth?>"><img src="img/daily_prevYear.gif" width="48" height="13" border="0" align="absmiddle"></a></td>
			  <td class=tahoma18bold><?=$year?>.<?=$month?></td>
			  <td width="60" align="right"><a href="<?=$PHP_SELF?>?iyear=<?=$nextyear?>&imonth=<?=$nextmonth?>"><img src="img/daily_nextYear.gif" width="48" height="13" border="0" align="absmiddle"></a></td>
			</table></td>
		</tr>
		<tr> 
		  <td><table width="560" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
				<td><table width="560" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td height="7"></td>
					</tr>
					<!--list start-->

					<tr> 
					  <td><table width="560" border="0" cellspacing="7" cellpadding="0">
						  <tr valign="top">

<?php

$today_day = date("Ymd");

for($forday=1; $forday<=$maxday; $forday++)
{
	$for_nowday=$year.$month.sprintf("%02d", $forday);

	if($dayno=="0")
	{
		$for_class="pink16";
	}
	else if($dayno=="6")
	{
		$for_class="blue16";
	}
	else
	{
		$for_class="gray16";
	}

	$for_sql="select * from $schedule_db where sch_date='$for_nowday'";
	$for_result=mysql_query($for_sql, $connect);
	
	$for_msg="&nbsp;";
	$for_color="#F3FAFA";
	while($for_row=mysql_fetch_array($for_result))
	{
		if($for_row[sch_no])
		{
			$for_msg=$for_msg."<a href='schedule_view.php?mode=view&iyear=$year&imonth=$month&iday=$forday&sch_no=$for_row[sch_no]'>".nl2br($for_row[sch_title])."</a><br>";
			$for_color="#F3FAFA";
		}

		if($for_row[sch_yn]=="2") $for_class="pink16";

		$for_i++;
	}

	if ($forday == "1")
	{
		$dayno = date("w", mktime(0, 0, 0, $month, $forday, $year));

		for ($i = 1; $i <= $dayno; $i++)
		{
			echo("
				<td width='80' height='50' bgcolor='$for_color'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr> 
					  <td align='right' class='gray16'>&nbsp;</td>
					</tr>
					<tr> 
					  <td class='dotum11'>&nbsp;</td>
					</tr>
				  </table></td>
				");
		}
	}

	echo("
		<td width='80' height='50' bgcolor='$for_color'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr> 
			  <td align='right' class='$for_class'>$forday</td>
			</tr>
			<tr> 
			  <td class='dotum11'>$for_msg</td>
			</tr>
		  </table></td>
		");

	$dayno++;
	
	if($dayno == 7)
	{
		echo("
				  </tr>
				</table></td>
			</tr>
			<tr> 
			  <td height='1' bgcolor='#E2E2E2'></td>
			</tr>
			");

		if($forday <= $maxday)
		{
			echo("
				<tr> 
				  <td><table width='560' border='0' cellspacing='7' cellpadding='0'>
					  <tr valign='top'>
				");
		}
		$dayno = 0;
	}
}

if($dayno != 0)
{
	$leftday = 7 - $dayno;

	for($i = 1; $i <= $leftday; $i++)
	{
		echo("
			<td width='80' height='50' bgcolor='$for_color'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr> 
				  <td align='right' class='gray16'>&nbsp;</td>
				</tr>
				<tr> 
				  <td class='dotum11'>&nbsp;</td>
				</tr>
			  </table></td>
			");
	}
	
	echo("
			  </tr>
			</table></td>
		</tr>
		<tr> 
		  <td height='1' bgcolor='#E2E2E2'></td>
		</tr>
		");
}

?>

						  </table></td>
					  </tr>
					  <tr> 
						<td height="1" bgcolor="#E2E2E2"></td>
					  </tr>
					</table></td>
				</tr>
				<tr> 
				  <td>&nbsp;</td>
				</tr>
			  </table></td>
		  </tr>
		</table></td>
	</tr>
 </table>
<p>&nbsp;</p>

<?php include("foot_schedule.php");?>
