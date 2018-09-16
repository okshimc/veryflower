<?php
session_start();
include("../inc/dbcon.php");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="post.css" rel="stylesheet" type="text/css">
<script language='javascript'>

//동이름 입력여부 체크하고 전송
function search_chk() 
{
	if(document.addr_form.search_addr.value=="")
	{
		alert("찾으실 동이름을 입력하세요.");
		document.addr_form.search_addr.focus();
		return;
	}
	document.addr_form.submit();
}

//동이름 적용하고 창닫기
function put_post(post_num1, post_num2, address)
{
	opener.document.req_form.req_post1.value=post_num1;
	opener.document.req_form.req_post2.value=post_num2;
	opener.document.req_form.req_addr1.value=address;
	opener.document.req_form.req_addr2.focus();
	window.close();
}

</script>
<title>우편번호검색</title></head>

<body>
<table width="420"  border="0" cellspacing="0" cellpadding="0">
  <form name="addr_form" method="post" action="<?=$PHP_SELF?>">
    <tr>
      <td height="90" align="center" valign="top"><img src="img/T.gif" width="420" height="80"></td>
    </tr>
    <tr>
      <td class=p_tb><table width="380" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="#F5F5F5">
          <tr>
            <td align="center" bgcolor="#FFFFFF"><input name="search_addr" type="text" size="20">
&nbsp;<a href="javascript:search_chk();"><img src="img/search.gif" width="70" height="20" border="0" align="absmiddle"></a>&nbsp;<a href="javascript:window.close();"><img src="img/close.gif" width="63" height="20" border="0" align="absmiddle"></a></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td class=p_tb2><table width="380" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr align="center"  bgcolor="f5f5f5">
            <td width="70">우편번호</td>
            <td width="2"><img src="img/part_line.gif" width="2" height="21"></td>
            <td>주 소</td>
          </tr>
          <?php
/* 동이름 검색어가 있으면 검색후 출력하기 */

if($search_addr) 
{
	$sql="select * from $zipcode_db where dong like '%$search_addr%' order by no asc";
	$result=mysql_query($sql, $connect);

	while($row=mysql_fetch_array($result)) 
	{
		$post_arr=explode("-", $row[zipcode]);
		$post_num1=$post_arr[0];
		$post_num2=$post_arr[1];
		$address=$row[sido]." ".$row[gugun]." ".$row[dong];
		$address_all=$row[sido]." ".$row[gugun]." ".$row[dong]." ".$row[bunji];

		echo("
              <tr align='center'> 
                <td>$row[zipcode]</td>
				<td><img src='img/part_line.gif' width='2' height='21'></td>	
                <td><div align='left'>&nbsp;<a href=\"javascript:put_post('$post_num1','$post_num2','$address');\">$address_all</a></div></td>
              </tr>
              <tr align='center'> 
                <td colspan='3' background='img/dot_line.gif'></td>
              </tr>
			");
	}


} //if($search_addr)문 닫기

/* 동이름 검색어가 있으면 검색후 출력하기 끝 */

?>
      </table></td>
    </tr>
  </form>
</table>
</body>
</html>
