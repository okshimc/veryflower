<?php

#######################################################################
#######################/* 페이지 나누기 함수 */########################
#######################################################################

function page_list() //페이지 나누기 함수
{
	//전역변수 설정 (총 페이지수, 한 페이지당 링크수, 현재 페이지, 페이지 이동시 넘겨줄 링크)
	GLOBAL $total_page, $page_set, $page, $default_href;
	GLOBAL $first_img, $prev_img, $next_img, $end_img;

	/* 페이지의 시작과 끝 설정 */
	$start_page=$page_set*intval(($page-1)/$page_set)+1; //링크되는 페이지의 시작 번호
	$temp_end_page=$start_page+$page_set-1;

	if($temp_end_page>$total_page) 
	{
	   $end_page=$total_page; //링크되는 페이지의 마지막 번호
	}
	else 
	{
	   $end_page=$temp_end_page; //링크되는 페이지의 마지막 번호
	}

	
	/* 이전 10개 링크 설정 */
	if($start_page>1) 
	{
		$prev_page=$start_page-1;
		$prev_href=$default_href."page=$prev_page";
		$first_href=$default_href."page=1";
		echo("
			<a href='$first_href'><img src='$first_img' border='0' align='absmiddle'></a>&nbsp;
			<a href='$prev_href'><img src='$prev_img' border='0' align='absmiddle'></a>&nbsp;&nbsp;
				");
	}
	else 
	{
		echo("
			<img src='$first_img' border='0' align='absmiddle'>&nbsp;
			<img src='$prev_img' border='0' align='absmiddle'>&nbsp;&nbsp;
				");
	}

	/* 이전 페이지 링크 설정
	if($page>1) 
	{
		$before_page=$page-1;
		$before_href=$default_href."&page=$before_page";
		echo("
			<a href='$before_href' class='par'>[이전]</a>&nbsp;
				");
	}
	else 
	{
		echo("
			<font class='gray'>[이전]</font>&nbsp;
				");
	}
	*/

	/* 하단 페이지 링크 10개 설정 */
	for($i=$start_page; $i<=$end_page; $i++) 
	{
	   if($i==$page) 
		{
		   echo("
				<b>[$i]</b>
					");
		 }
		else 
		{
			$current_href=$default_href."page=$i";
			echo("
				<a href='$current_href'>[$i]</a>
					");
		 }
	} //for문 닫기

	/* 다음 페이지 링크 설정
	if($page<$total_page) 
	{
		$after_page=$page+1;
		$after_href=$default_href."&page=$after_page";
		echo("
			&nbsp;<a href='$after_href' class='par'>[다음]</a>
				");
	}
	else 
	{
		echo("
			&nbsp;<font class='gray'>[다음]</font>
				");
	}
	*/

	/* 다음 10개 링크 설정 */
	if($end_page<$total_page) 
	{
		$next_page=$end_page+1;
		$next_href=$default_href."page=$next_page";
		$last_href=$default_href."page=$total_page";
		echo("
			&nbsp;&nbsp;<a href='$next_href'><img src='$next_img' border='0' align='absmiddle'></a>
			&nbsp;<a href='$last_href'><img src='$end_img' border='0' align='absmiddle'></a>
				");
	}
	else 
	{
		echo("
			&nbsp;&nbsp;<img src='$next_img' border='0' align='absmiddle'>
			&nbsp;<img src='$end_img' border='0' align='absmiddle'>
				");
	}

} //function page_list()함수 닫기

#######################################################################
#####################/* 페이지 나누기 함수 끝 */#######################
#######################################################################

?>
