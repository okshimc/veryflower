<?php

#######################################################################
#######################/* 페이지 나누기 함수 */########################
#######################################################################

function page_list() //페이지 나누기 함수
{
	//전역변수 설정 (총 페이지수, 한 페이지당 링크수, 현재 페이지, 페이지 이동시 넘겨줄 링크)
	GLOBAL $total_page, $page_set, $page, $default_href;

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
		$page_list_href["first1"]="<a href='$first_href'>";
		$page_list_href["first2"]="</a>";
		$page_list_href["prev1"]="<a href='$prev_href'>";
		$page_list_href["prev2"]="</a>";
	}
	else 
	{
		$page_list_href["first1"]="<span class='disabled'>";
		$page_list_href["first2"]="</span>";
		$page_list_href["prev1"]="<span class='disabled'>";
		$page_list_href["prev2"]="</span>";
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
	$page_list_href["list"]="";
	for($i=$start_page; $i<=$end_page; $i++)
	{
	   if($i==$page)
		{
		   $current_href=$default_href."page=$i";
		   $page_list_href["list"].="<span class='current'>$i</span>";
		 }
		else
		{
			$current_href=$default_href."page=$i";
			$page_list_href["list"].="<a href='$current_href'>$i</a>";
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
		$end_href=$default_href."page=$total_page";
		$page_list_href["next1"]="<a href='$next_href'>";
		$page_list_href["next2"]="</a>";
		$page_list_href["end1"]="<a href='$end_href'>";
		$page_list_href["end2"]="</a>";
	}
	else 
	{
		$page_list_href["next1"]="<span class='disabled'>";
		$page_list_href["next2"]="</span>";
		$page_list_href["end1"]="<span class='disabled'>";
		$page_list_href["end2"]="</span>";
	}

	return($page_list_href);

} //function page_list()함수 닫기

function page_list_pagei() //페이지 나누기 함수
{
	//전역변수 설정 (총 페이지수, 한 페이지당 링크수, 현재 페이지, 페이지 이동시 넘겨줄 링크)
	GLOBAL $total_page, $page_set, $page, $default_href;

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
		$page_list_href["first1"]="<a href=\"$first_href\">";
		$page_list_href["first2"]="</a>";
		$page_list_href["prev1"]="<a href=\"$prev_href\">";
		$page_list_href["prev2"]="</a>";
	}
	else 
	{
		$page_list_href["first1"]="<a href=\"javascript:;\">";
		$page_list_href["first2"]="</a>";
		$page_list_href["prev1"]="<a href=\"javascript:;\">";
		$page_list_href["prev2"]="</a>";
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
	$page_list_href["list"]="";
	for($i=$start_page; $i<=$end_page; $i++)
	{
	   if($i==$page)
		{
		   $current_href=$default_href."page=$i";
		   $page_list_href["list"].="<a href=\"$current_href\" class=\"active\">$i</a> ";
		 }
		else
		{
			$current_href=$default_href."page=$i";
			$page_list_href["list"].="<a href=\"$current_href\">$i</a> ";
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
		$end_href=$default_href."page=$total_page";
		$page_list_href["next1"]="<a href=\"$next_href\">";
		$page_list_href["next2"]="</a>";
		$page_list_href["end1"]="<a href=\"$end_href\">";
		$page_list_href["end2"]="</a>";
	}
	else 
	{
		$page_list_href["next1"]="<a href=\"javascript:;\">";
		$page_list_href["next2"]="</a>";
		$page_list_href["end1"]="<a href=\"javascript:;\">";
		$page_list_href["end2"]="</a>";
	}

	return($page_list_href);

} //function page_list()함수 닫기

#######################################################################
#####################/* 페이지 나누기 함수 끝 */#######################
#######################################################################

?>
