<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");

if($tmp_row[kind_wpower]=="2")
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

if($mode=="comment_input")
{
	$ip=getenv("REMOTE_ADDR");

	if($_SESSION[ok_name]) $comment_name=$_SESSION[ok_name];

	if ( isset($_POST['zsfCode']) )
	{
		$zsfCode = stripslashes(trim($_POST['zsfCode']));
		include 'zmSpamFree.php';
		/*
		zsfCheck 함수는 두 개의 인수를 사용할 수 있다.
		$_POST['zsfCode'] : 사용자가 입력한 스팸방지코드 값
		'DemoPage' : 관리자가 로그파일에 남겨놓고 싶은 메모, 예를 들어 bulletin 게시판의 comment 쓰기시 
		스팸방지코드를 입력했다 한다면 'bulletin|comment'라고 써 놓으면, 어떤 게시판의 어떤 상황에서 
		스팸차단코드가 맞거나 틀렸는지 알 수 있을 것이다.
		이외에 '제목의 일부'나 '글 내용의 일부'를 같이 넣으면, 어떤 스팸광고글이 차단되었는지도 확인할 수 있다.
		참고로 이 인수는 생략 가능하다.
		*/

		# $_POST['zsfCode']는 입력된 스팸방지코드 값이고, 'DemoPage'는 기타 기록하고픈
		$check_result = zsfCheck ( $_POST['zsfCode'],'DemoPage' );	

		if ( !$check_result ) 
		{ 
			echo "<script>alert('보안코드가 맞지 않습니다. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('보안코드를 입력하지 않았습니다. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
		exit;
	}

	//게시물 입력하기
	$sql="insert into $board_comment_db set
						comment_no='', /* 고유 번호 */
						comment_wcode='$kind_code', /* 게시판 코드 */
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

	$board_db="board_".$kind_code;

	$sql="update $board_db set
				w_repnum=w_repnum+1
				where w_seq='$w_seq'";
	mysql_query($sql, $connect);

	echo("
		<script language='javascript'>
			location.href='view.php?w_seq=$w_seq&kind_code=$kind_code';
		</script>
			");

} //end if($mode=="comment_input")

if($mode=="comment_del")
{
	$sql="select comment_pw from $board_comment_db where comment_no='$delno'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	if($row[comment_pw]!=$comment_pw)
	{
		echo("
			<script language='javascript'>
				alert('비밀번호가 일치하지 않습니다.');
				history.back();
			</script>
				");
		exit();
	}

	//게시물 입력하기
	$sql="delete from $board_comment_db
						where comment_no='$delno'
						and comment_wcode='$kind_code'
						and comment_wseq='$w_seq'";
	mysql_query($sql);

	$board_db="board_".$kind_code;

	$sql="update $board_db set
				w_repnum=w_repnum-1
				where w_seq='$w_seq'";
	mysql_query($sql, $connect);

	echo("
		<script language='javascript'>
			location.href='view.php?w_seq=$w_seq&kind_code=$kind_code';
		</script>
			");

} //end if($mode=="comment_del")

?>
