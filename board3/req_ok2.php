<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("../inc/function.php");

if(!$req_part) $req_part="1";
if($req_phone1) $req_phone=$req_phone1."-".$req_phone2."-".$req_phone3;
if($req_hp1) $req_hp=$req_hp1."-".$req_hp2."-".$req_hp3;
if($req_fax1) $req_fax=$req_fax1."-".$req_fax2."-".$req_fax3;
if($req_addr1) $req_addr=$req_post1."-".$req_post2." ".$req_addr1." ".$req_addr2;

$req_addcontent="";
if($req_depart) $req_addcontent.="부서 : ".$req_depart."\n";
if($req_position) $req_addcontent.="직위 : ".$req_position."\n";
$req_content=$req_addcontent.$req_content;

$req_addfile=$_FILES['req_addfile']['tmp_name'];
$req_addfile_name=$_FILES['req_addfile']['name'];
$req_addfile_size=$_FILES['req_addfile']['size'];

$nowtime=time();

//첨부 파일이 있으면...
if($req_addfile_size>0)
{
	$file_ext_arr=get_ext("$req_addfile_name");
	$file_name="req_addfile_".$nowtime."_".$file_ext_arr[0].$file_ext_arr[1];

	if(file_exists("$req_addfile_dir/$file_name"))
	{
		unlink("$req_addfile_dir/$file_name");
	}

	move_uploaded_file($req_addfile, "$req_addfile_dir/$file_name");

	$req_addfile_sql="req_addfile='$file_name'";
}
else
{
	$req_addfile_sql="req_addfile=''";
}

if($mode=="reg")
{
	$sql="insert into $request2_db set
					req_no='',
					req_part='$req_part', /* 분류 */
					req_office='$req_office', /* 회사명 */
					req_memid='$req_memid', /* 아이디 */
					req_name='$req_name', /* 이름 */
					req_email='$req_email', /* 이메일 */
					req_phone='$req_phone', /* 연락처 */
					req_hp='$req_hp', /* 핸드폰 */
					req_fax='$req_fax', /* 팩스 */
					req_addr1='$req_addr1', /* 주소 */
					req_addr2='$req_addr2', /* 주소 */
					req_title='$req_title', /* 제목 */
					req_content='$req_content', /* 내용 */
					req_etc='$req_etc', /* 기타 */
					req_reply='', /* 답변 */
					req_replycheck='0', /* 답변여부 */
					req_spare1='$req_spare1', /* 예비1 */
					req_spare2='$req_spare2', /* 예비2 */
					req_spare3='$req_spare3', /* 예비3 */
					req_spare4='$req_spare4', /* 예비4 */
					req_spare5='$req_spare5', /* 예비5 */
					req_spare6='$req_spare6', /* 예비6 */
					req_spare7='$req_spare7', /* 예비7 */
					req_date=now(), /* 날짜 */
					$req_addfile_sql /* 첨부파일 */";
	mysql_query($sql, $connect);

	echo("
		<script language='javascript'>
			alert('전송이 완료되었습니다.');
			location.href='/';
		</script>
		");
}

?>