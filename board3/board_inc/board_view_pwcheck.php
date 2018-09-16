<?php

$tmp_lock_check_sql="select w_group from $board_db where w_seq='$w_seq'";
$tmp_lock_check_result=mysql_query($tmp_lock_check_sql, $connect);
$tmp_lock_check_row=mysql_fetch_array($tmp_lock_check_result);
$w_group=$tmp_lock_check_row[w_group];

$lock_check_sql="select w_lockyn from $board_db where w_seq='$w_group'";
$lock_check_result=mysql_query($lock_check_sql, $connect);
$lock_check_row=mysql_fetch_array($lock_check_result);

if($lock_check_row[w_lockyn]=="y")
{
	$href="kind_code=$kind_code&page=$page&w_seq=$w_seq";
	$href.="&search_name=$search_name&search_part=$search_part";

	if($mode=="unlock")
	{
		if(strlen($w_group)>0)
		{
			$lock_check_sql2="select w_passwd from $board_db where w_group='$w_group'";
			$lock_check_result2=mysql_query($lock_check_sql2, $connect);
			$lock_check_row2=mysql_fetch_array($lock_check_result2);
		}
		else
		{
			$lock_check_sql2="select w_passwd from $board_db where w_seq='$w_seq'";
			$lock_check_result2=mysql_query($lock_check_sql2, $connect);
			$lock_check_row2=mysql_fetch_array($lock_check_result2);
		}

		if($lock_check_row2[w_passwd]!=$passwd)
		{
			echo("
				<script language='javascript'>
					alert('비밀번호가 일치하지 않습니다.');
					history.back();
				</script>
					");
			exit();
		}
	}
	else
	{
		echo("
			<script language='javascript'>
				alert('비밀번호를 입력하지 않으면 접근할 수 없습니다.');
				location.href='list.php?$href';
			</script>
				");
		exit();
	}
}

?>