<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_rpower]=="2")
{
	if(!$_SESSION[ok_id])
	{
		echo("
			<script language='javascript'>
				alert('회원 로그인후 이용할 수 있습니다.');
				history.back();
			</script>
			");
		exit();
	}
}

if($tmp_row[kind_rpower]=="3")
{
	echo("
		<script language='javascript'>
			alert('글보기 권한이 없습니다.');
			history.back();
		</script>
		");
	exit();
}

$table_name="board_".$kind_code;

$sql="select * from $board_file_db
				where file_wcode='$kind_code'
				and file_wseq='$w_seq'
				and file_sequence='$sequence'";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$row[file_orgname]=iconv("UTF-8","EUC-KR",$row[file_orgname]);

$pds_regname=$row[file_regname];
$pds_orgname=$row[file_orgname];

$board_upload_new_dir=$board_upload_dir."/".$row[file_path];

$href="page=$page&board_code=$board_code&search_part=$search_part&search_name=$search_name";

$dn_yn="attachment"; // 다운로드
//$dn_yn="inline"; // 브라우져가 인식하면 화면에 출력 

/* 파일 다운로드 함수 */
function pds_down($pds_regname, $pds_orgname, $board_upload_new_dir, $dn_yn)
{
	//echo $_SERVER[HTTP_USER_AGENT]; exit();
	//echo $pds_size; exit();
	if(file_exists("$board_upload_new_dir/$pds_regname"))
	{
		$pds_size=filesize("$board_upload_new_dir/$pds_regname");

		if(preg_match("/MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0/i", $_SERVER[HTTP_USER_AGENT]))
		{
			if(strstr($_SERVER[HTTP_USER_AGENT], "MSIE 5.5"))
			{
				Header("Content-Type: doesn/matter");
				Header("Content-Length: ".(string)($pds_size));
				Header("Content-Disposition: filename=$pds_orgname");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
			if(strstr($_SERVER[HTTP_USER_AGENT], "MSIE 5.0"))
			{
				Header("Content-type: file/unknown");
				header("Content-Disposition: $dn_yn; filename=$pds_orgname");
				Header("Content-Description: PHP3 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER[HTTP_USER_AGENT], "MSIE 5.1"))
			{
				Header("Content-type: file/unknown");
				header("Content-Disposition: $dn_yn; filename=$pds_orgname");
				Header("Content-Description: PHP3 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			if(strstr($_SERVER[HTTP_USER_AGENT], "MSIE 6.0"))
			{
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)($pds_size)); //다운로드 진행 상태 표시
				Header("Content-Disposition: $dn_yn; filename=$pds_orgname");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
		}
		else
		{
			Header("Content-type: file/unknown");
			Header("Content-Length: ".(string)($pds_size));
			Header("Content-Disposition: $dn_yn; filename=$pds_orgname");
			Header("Content-Description: PHP3 Generated Data");
			Header("Pragma: no-cache");
			Header("Expires: 0");
		}

		/*
		$fp=fopen("$board_upload_new_dir/$pds_regname", "rb");
		fpassthru($fp);
		fclose($fp);
		*/

		// 파일 전송
		if(is_file("$board_upload_new_dir/$pds_regname"))
		{
			$fp = fopen("$board_upload_new_dir/$pds_regname", "rb");
			if(!fpassthru($fp)) fclose($fp);
		}
		else
		{
			echo "해당 파일이 존재하지 않습니다.";
		}
	}
	else
	{
		echo("
			<script language='javascript'>
				alert('해당 파일이 존재하지 않습니다.');
				history.back();
			</script>
				");
		exit();
	}
}

pds_down($pds_regname, $pds_orgname, $board_upload_new_dir, $dn_yn);

/* 다운로드수 증가 시켜주기 */
$read_sql="update $table_name set
					w_down=w_down+1
					where w_seq='$w_seq'";
mysql_query($read_sql);

mysql_free_result($result);
mysql_close($connect);

?>