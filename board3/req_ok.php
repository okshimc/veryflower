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
if($req_spare4_start) $req_spare4=$req_spare4_start." ~ ".$req_spare4_end;

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
	$sql="insert into $request_db set
					req_no='',
					req_part='$req_part', /* 분류 */
					req_cate='$req_cate',
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

	if(strlen($req_name)>0)
	{
		$home_path="http://".$_SERVER[SERVER_NAME];
		$homeinfo_name=$_SERVER[SERVER_NAME];
		$skin_email_path=$home_path."/user_img/email";

		$html="
		<html>
		<head>
		<title>Untitled Document</title>
		<style type='text/css'>
		<!--
		table{
			font-size: 12px;
			color: #4e4e4e;
			padding: 0px;
			line-height:1.4;
		}

		.t1{
			background: url($skin_email_path/line_bg.gif);
			padding: 20px 15px;
		}

		.dot_b{
			border-bottom: 1px dotted #999999;
			height:50px;
		}

		.tabg1 {
			background-color: #cccccc;
		}
		.tabg2 {
			background-color: #999999;
		}
		.tdbg1 {
			background-color: #f5f5f5;
		}
		-->
		</style>
		</head>

		<body>
		<table width='800' align='left'>
		  <tr>
			<td class=t1><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='155'><img src='$skin_email_path/img_l.gif' width='145' height='240'></td>
				<td align='center' bgcolor='#FFFFFF'><table width='94%'  border='0' cellspacing='0' cellpadding='4'>
				  <tr>
					<td height=30 valign=top><b>$req_name 님의 온라인 예약이 </b> 신청되었습니다.</b></td>
				  </tr>
				  <tr>
					<td></td>
				  </tr>
				  <tr>
					<td>

					<table width='90%' border='0' align='left' cellpadding='4' cellspacing='1' class='tabg1'>
						<tr> 
						  <td width='25%' class='tdbg1'><div align='center'>성 명</div></td>
						  <td bgcolor='#FFFFFF'>$req_name</td>
						</tr>
						<tr> 
						  <td width='25%' class='tdbg1'><div align='center'>이메일</div></td>
						  <td bgcolor='#FFFFFF'>$req_email</td>
						</tr>
						<tr> 
						  <td class='tdbg1'><div align='center'>전화번호</div></td>
						  <td bgcolor='#FFFFFF'>$req_phone</td>
						</tr>
						<tr> 
						  <td class='tdbg1'><div align='center'>휴대폰</div></td>
						  <td bgcolor='#FFFFFF'>$req_hp</td>
						</tr>
						<tr> 
						  <td width='25%' class='tdbg1'><div align='center'>차량모델</div></td>
						  <td bgcolor='#FFFFFF'>$req_title $req_cate</td>
						</tr>
						<tr> 
						  <td class='tdbg1'><div align='center'>내 용</div></td>
						  <td height='150' valign='top' bgcolor='#FFFFFF'>".nl2br($req_content)."</textarea></td>
						</tr>
					  </table>

					</td>
				  </tr>
				  <tr>
					<td></td>
				  </tr>
				  <tr>
					<td align=center class=dot_b><a href='$home_path' target='_blank'><img src='$skin_email_path/btn_home.gif' width=110 height=25 border='0' align=absmiddle></a></td>
					</tr>
				  <tr>
					<td>
					Copyright ⓒ 회사명 All rights reserved.</td>
					</tr>
				</table></td>
			  </tr>
			</table></td>
		  </tr>
		</table>
		</body>
		</html>
		";

		$to = "회사명";
		//$to_email = "shmode@empal.com";
		$to_email = "";
		$from = $req_name;
		$from_email = $req_email;
		$subject = "$req_name 님의 온라인 예약이 신청되었습니다.";
		$body = $html;

		$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
		$from = "=?UTF-8?B?".base64_encode($from)."?=";
		$to = "=?UTF-8?B?".base64_encode($to)."?=";

		$mailheaders="Return-Path: $from_email\r\n";
		$mailheaders.="From: $from <$from_email>\r\n";
		$mailheaders.="Content-Type: text/html; charset=euc-kr\r\n";

		mail($to_email, $subject, $body, $mailheaders);
	}

	echo("
		<script language='javascript'>
			alert('전송이 완료되었습니다.');
			location.href='/';
		</script>
		");
}

?>