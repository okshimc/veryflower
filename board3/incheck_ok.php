<?php
session_start();
include("../inc/dbcon.php");

$tmp_row[kind_wpower]="1";

if($_SESSION[ok_name]) $comment_name=$_SESSION[ok_name];

if($mode=="comment_input")
{
	$ip=getenv("REMOTE_ADDR");

	//게시물 입력하기
	$sql="insert into incheck_comment set
						comment_no='', /* 고유 번호 */
						comment_wcode='7', /* 게시판 코드 */
						comment_wseq='$w_seq', /* 게시물 번호 */
						comment_memberyn='y', /* 회원여부 */
						comment_id='$_SESSION[ok_id]', /* 아이디 */
						comment_name='$comment_name', /* 이름 */
						comment_pw='$comment_pw', /* 비밀번호 */
						comment_content='$comment_content', /* 내용 */
						comment_date=now(), /* 작성일 */
						comment_ip='$ip', /* 아이피 */
						comment_read='0' /* 조회수 */
						";
	mysql_query($sql);

	echo("
		<script language='javascript'>
			location.href='list_incheck.php?kind_code=$kind_code';
		</script>
			");

} //end if($mode=="comment_input")

if($mode=="comment_del")
{
	$sql="select comment_id, comment_pw from incheck_comment where comment_no='$delno'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	if($_SESSION[ok_id])
	{
		if($row[comment_id]!=$_SESSION[ok_id])
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
		if($passwd!=$row[comment_pw])
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

	//게시물 삭제하기
	$sql="delete from incheck_comment
				where comment_no='$delno'
				and comment_wcode='7'
				and comment_wseq='$w_seq'";
	mysql_query($sql);

	echo("
		<script language='javascript'>
			location.href='list_incheck.php?kind_code=$kind_code';
		</script>
			");

} //end if($mode=="comment_del")

?>
