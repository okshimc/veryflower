<?php
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");

if(!$vote_no)
{
	$chk_sql="select * from $vote_db
				where vote_status='1'
				and vote_startday<=now()
				and vote_endday>=now()
				order by vote_no desc
				limit 1";
	$chk_result=mysql_query($chk_sql, $connect);
	$chk_row=mysql_fetch_array($chk_result);
	if($chk_row[vote_no]) $vote_no=$chk_row[vote_no];
	else error_alert("선택하신 설문조사가 없습니다.");
}

$chk_sql="select vote_status, vote_endday
				from $vote_db
				where vote_no='$vote_no'";
$chk_result=mysql_query($chk_sql);
$chk_row=mysql_fetch_array($chk_result);

if($chk_row[vote_status]!="1")
{
	$mode="view";
}

$ymd_arr=explode("-", $chk_row[vote_endday]);
$endday_time=mktime(0, 0, 0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
$today_time=time();

if($endday_time<$today_time)
{
	$chk_sql="update $vote_db set vote_status='2' where vote_no=$vote_no";
	mysql_query($chk_sql);
	$mode="view";
}

if($mode=="update")
{
	$ans_field="vote_ans".$ans_no;

	$sql="update $vote_db set $ans_field=$ans_field+1 where vote_no=$vote_no";
	mysql_query($sql);

	echo("
		<script language='javascript'>
		function getCookieVal(offset) 
		{
			var endstr = document.cookie.indexOf (';', offset);
			if (endstr == -1) endstr = document.cookie.length;
			return unescape(document.cookie.substring(offset, endstr));
		}

		function GetCookie(name) //설정된 쿠키값 가져오는 함수
		{
			var arg = name + '=';
			var alen = arg.length;
			var clen = document.cookie.length;
			var i = 0;
			while(i < clen) 
			{
				var j = i + alen;
				if(document.cookie.substring(i, j) == arg) 
				{
					return getCookieVal(j);
				}
				i = document.cookie.indexOf(' ', i) + 1;
				if(i == 0) 
				{
					break;
				}
			}
			return null;
		}

		function SetCookie(name, value) //쿠키값 설정하는 함수
		{
			var argv = SetCookie.arguments;
			var argc = SetCookie.arguments.length;
			var expires = (2 < argc) ? argv[2] : null;
			var path = (3 < argc) ? argv[3] : null;
			var domain = (4 < argc) ? argv[4] : null;
			var secure = (5 < argc) ? argv[5] : false;
			document.cookie = name + '=' + escape(value) + 
			((expires == null) ? '' : ('; expires=' + expires.toGMTString())) + 
			((path == null) ? '' : ('; path=' + path)) + 
			((domain == null) ? '' : ('; domain=' + domain)) + 
			((secure == true) ? '; secure' : '');
		}

		function set_cookie() 
		{
			var ExpDate = new Date();
			ExpDate.setTime(ExpDate.getTime() + 1000*60*60*24);
			/*
			위의 예제는 만료일을 쿠키가 생성되는 현재 시간 + 1일로 설정합니다.
			만약, 만료일을 쿠키가 생성된 후 1시간으로 설정하겠다면 위의 예제에서 24(시간)를 
			1(시간) 로 바꾸어 주면 됩니다.
			*/
			SetCookie('voted', 'already', ExpDate, '/');
			/*
			SetCookie(name, value, [expires], [path], [domain], [secure]);
			*/
			var voted_val=GetCookie('voted');
		}
		</script>
	");


	if($ans_no)
	{
		echo("
			<script language='javascript'>
				set_cookie();
			</script>
			");
	}

	go_url("view_vote.php?mode=view&vote_no=$vote_no&page=$page");
}
else if($mode=="view")
{
	$sql="select * from $vote_db where vote_no='$vote_no'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$total_vote=$row[vote_ans1]+$row[vote_ans2]+$row[vote_ans3]+$row[vote_ans4]+$row[vote_ans5]+$row[vote_ans6]+$row[vote_ans7]+$row[vote_ans8]+$row[vote_ans9]+$row[vote_ans10];

	for($i=1; $i<=$row[vote_exnum]; $i++)
	{
		$ex_name="vote_ex".$i;
		$img_name="vote_stick".$i.".gif";
		$ans_name="vote_ans".$i;
		$total+=$row[$ans_name];

		if($row[$ans_name]!=0)
		{
			$ans_percent=($row[$ans_name]/$total_vote)*100;
			$ans_percent=sprintf("%0.1f", $ans_percent);
		}
		else if($row[$ans_name]==0)
		{
			$ans_percent=0;
		}
		$width=$ans_percent*2;

		$arr[$i][v]=$i;
		$arr[$i][ex_name]=$row[$ex_name];
		$arr[$i][ans_num]=$row[$ans_name];
		$arr[$i][img_name]=$img_name;
		$arr[$i][width]=$width;
		$arr[$i][ans_percent]=$ans_percent;
	}
}
else
{
	$sql="select * from $vote_db where vote_no='$vote_no'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	if($row[vote_no])
	{
		for($i=1; $i<=$row[vote_exnum]; $i++)
		{
			$vname="vote_ex".$i;
			if(strlen($row[$vname])>0)
			{
				$arr[$i][vote_ansno]=$i;
				$arr[$i][vote_question]=$row[$vname];
			}
		}
	}
}

if($mode=="view") include("view_vote_result_main.php");
else include("view_vote_main.php");

?>
