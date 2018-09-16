<?php
session_start();
include("../inc/dbcon.php");
include("../inc/db_sql.php");
include("../inc/function.php");

if($mode=="insert")
{
	$sql="select mem_id, mem_name, mem_email
							from $member_db
							where mem_id='$_SESSION[ok_id]'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	$sql2="insert into $brand_value_db set
					value_no='', /* 일련번호 */
					value_brandcode='$brand_code', /* 상품 코드 */
					value_brandname='$brand_name', /* 상품 이름 */
					value_id='$row[mem_id]', /* 회원 아이디 */
					value_name='$row[mem_name]', /* 회원 이름 */
					value_email='$row[mem_email]', /* 회원 이메일 */
					value_subject='$subject', /* 상품평 제목 */
					value_rate='$rate', /* 상품 평가 */
					value_grade='', /* 상품평 평가 */
					value_comment='$comment', /* 상품평 내용 */
					value_date=now() /* 작성일 */";
	mysql_query($sql2, $connect);

	echo("
		<script language='javascript'>
			location.replace('value_list.php');
		</script>
		");
}
else if($mode=="update")
{
	$sql="select mem_id, mem_name, mem_email
							from $member_db
							where mem_id='$_SESSION[ok_id]'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	$sql2="select value_id from $brand_value_db where value_no='$value_no'";
	$result2=mysql_query($sql2, $connect);
	$row2=mysql_fetch_array($result2);

	if($row[mem_id]!=$row2[value_id])
	{
		echo("
			<script language='javascript'>
				alert('해당 상품평을 수정할수 있는 권한이 없습니다.');
				history.back();
			</script>
				");
		exit();
	}

	$sql3="update $brand_value_db set
					value_name='$row[mem_name]', /* 회원 이름 */
					value_email='$row[mem_email]', /* 회원 이메일 */
					value_subject='$subject', /* 상품평 제목 */
					value_rate='$rate', /* 상품 평가 */
					value_comment='$comment' /* 상품평 내용 */
					where value_no='$value_no'";
	mysql_query($sql3, $connect);

	echo("
		<script language='javascript'>
			location.replace('value_list.php');
		</script>
		");

}
else if($mode=="delete")
{
	$sql="select mem_id from $member_db
						where mem_id='$_SESSION[ok_id]'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	$sql2="select value_id from $brand_value_db where value_no='$value_no'";
	$result2=mysql_query($sql2, $connect);
	$row2=mysql_fetch_array($result2);

	if($row[mem_id]!=$row2[value_id])
	{
		echo("
			<script language='javascript'>
				alert('해당 상품평을 삭제할수 있는 권한이 없습니다.');
				history.back();
			</script>
				");
		exit();
	}

	$sql3="delete from $brand_value_db
						where value_no='$value_no'
						and value_id='$_SESSION[ok_id]'";
	mysql_query($sql3, $connect);

	echo("
		<script language='javascript'>
			location.replace('value_list.php');
		</script>
		");
}

mysql_close($connect);

?>