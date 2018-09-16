<?php

//가로기준 이미지 사이즈 조절
function width_resize($file, $limit_w)
{
	$size=GetImageSize($file);
	$width=$size[0];
	$height=$size[1];

	if($width>$limit_w)
	{
		$percent=$width/$limit_w;
	}
	else
	{
		$percent=1;
	}

	$width_new=$width/$percent;
	$height_new=$height/$percent;
	$new_size=array($width_new, $height_new);
	return $new_size;
}

//가로/세로 기준 이미지 사이즈 조절
function img_resize($file, $limit_w, $limit_h)
{
	$size=GetImageSize($file);
	$width=$size[0];
	$height=$size[1];

	if($width>$limit_w || $height>$limit_h)
	{
		if($width>$height)
		{
			$percent=$width/$limit_w;
		}
		else if($height>$width)
		{
			$percent=$height/$limit_w;
		}
		else
		{
			$percent=$width/$limit_w;
		}
	}
	else
	{
		$percent=1;
	}

	$width_new=$width/$percent;
	$height_new=$height/$percent;
	$new_size=array($width_new, $height_new);
	return $new_size;
}

/* new 아이콘 생성 */
function new_icon($w_date, $w_title)
{
	//오늘 날짜 구하기(타임스탬프)
	list($year, $month, $day, $hour, $min, $sec)=explode("-", date("Y-m-d-H-i-s"));
	$today=mktime($hour, $min, $sec, $month, $day, $year);

	//글쓴 날짜 구하기(타임스탬프)
	$reg_day=trim($w_date);
	$reg_day=str_replace(" ", "-", $reg_day);
	$reg_day=str_replace(":", "-", $reg_day);
	list($year2, $month2, $day2, $hour2, $min2, $sec2)=explode("-", $reg_day);
	$reg_day=mktime($hour2, $min2, $sec2, $month2, $day2, $year2);

	//오늘 날짜와 글쓴 날짜의 차이 구하기(초단위)
	$gap_sec=$today-$reg_day;
	//오늘 날짜와 글쓴 날짜의 차이 구하기(일단위)
	$gap_day=$gap_sec/86400;

	if($gap_day<7)
	{
		$w_title=$w_title." <img src='board_img/new.gif' align='absmiddle'>";
	}
	return $w_title;
}

/* 파일 사이즈 계산하기 */
function count_filesize($size)
{
	//파일이 1MB보다 작으면 KB단위로 표시하고, 소숫점 아래 둘째 자리에서 자른다.
	if($size<(1024*1024))
	{
		return sprintf("%0.2f KB", $size/1024);
	}
	//파일이 1MB보다 크면 MB단위로 표시하고 소숫점 아래 둘째 자리에서 자른다.
	else
	{
		return sprintf("%0.2f MB", $size/(1024*1024));
	}
}

/* 문자열 자르기 함수 */
function cut_str($str, $length) //인자값=(전체 문자열, 잘라낼 갯수)
{
	if(strlen($str)<=$length) 
	{
		return $str;
	}
	for($i=0; $i<$length; $i++) 
	{
		if(ord($str[$i])>127) 
		{
			$over++;
		}
	}
	//$str=chop(substr($str, 0, $length-$over%2))."...";
	//UTF-8 일때
	$str=chop(substr($str, 0, $length-$over%3))."...";
	return $str;
}

/* 삭제하려는 게시물의 답글이 있나 알아보는 함수 */
function record_chk($table_name, $group, $top, $step)
{
	//삭제하려는 게시물과 같은 group 중에서 top값이 1크고, step값도 1큰 게시물이 있나 구한다.
	$rec_sql="select w_seq from $table_name
							where w_group=$group
							and w_top=$top+1
							and w_step=$step+1";
	$rec_result=mysql_query($rec_sql);
	$value=mysql_num_rows($rec_result);
	return $value; //결과값이 없으면 0, 있으면 1 반환
}

/* 지정한 주소로 돌아가기 */
function go_url($url) 
{
	echo("
		<script language='javascript'>
			location.href='$url';
		</script>
		");
}

/* 에러메세지 출력후 돌아가기 */
function error_alert($error_msg) 
{
	echo("
		<script language='javascript'>
			alert('$error_msg');
			history.back();
		</script>
		");

	exit();
}

/* 파일 확장자 구하는 함수 */
function get_ext($file_name)
{
	$lower=strtolower($file_name); //파일이름 소문자로...
	$pos=strrpos($lower, "."); //파일이름에서 마지막에 "."이 나오는 위치
	$ext=substr($lower, $pos); //파일이름에서 마지막 "."부터 끝까지가 확장자
	$name=substr($lower, 0, $pos); //파일이름에서 0부터 마지막 "."이전까지가 순수 파일이름

	return array($name, $ext);
}

/* 파일 확장자별로 보여줄 아이콘 결정하기 */
function select_icon($pds_dir, $pds_name)
{
	if(is_file("$pds_dir/$pds_name")) //파일이 있으면...
	{
		//strrchr()함수=해당 문자열의 마지막 위치를 파악해서 그 이후 부분을 돌려준다.
		$ext=strrchr($pds_name, ".");
		//$ext=strtolower($ext);

		switch($ext)
		{
			case ".mp3" :
			case ".mp2" :

				$icon="mp3.gif";
			break;

			case ".wav" :
				$icon="wav.gif";
			break;

			case ".mpeg" :
			case ".mpg" :
			case ".asf" :
				$icon="video.gif";
			break;

			case ".zip" :
				$icon="zip.gif";
			break;

			case ".rar" :
				$icon="rar.gif";
			break;

			case ".gif" :
				$icon="gif.gif";
			break;

			case ".jpg" :
				$icon="jpg.gif";
			break;

			case ".bmp" :
				$icon="bmp.gif";
			break;

			case ".exe" :
				$icon="exe.gif";
			break;

			case ".html_" :
				$icon="html.gif";
			break;

			case ".hwp" :
				$icon="hwp.gif";
			break;

			case ".doc" :
				$icon="doc.gif";
			break;

			case ".xls" :
				$icon="xls.gif";
			break;

			case ".txt" :
				$icon="txt.gif";
			break;

			default :
				$icon="unknown.gif";
			break;
		} //end switch
	}
	else //파일이 없으면...
	{
		$icon="nothing.gif";
	}
	return $icon;
} //end function

//$ty==true <- 끝에 .. 붙임.
function strcut($str, $limit, $ty) { 
        if (strlen($str)>$limit) { 
            $j=0; 
            while($j<$limit) { 
                if (ord($str[$j])>=127) { 
                    $j += 2; 
                } else { 
                    $j++; 
                } 
            } 
            $str = substr($str,0,$j); 
            if ($ty) { 
                return $str.".."; 
            } else { 
                return $str; 
            } 
        } else { 
            return $str; 
        } 
} 

function strcuttag($str, $limit, $ty) { 
		$str = ereg_replace("<[^>]*>","",$str);
        if (strlen($str)>$limit) { 
            $j=0; 
            while($j<$limit) { 
                if (ord($str[$j])>=127) { 
                    $j += 2; 
                } else { 
                    $j++; 
                } 
            } 
            $str = substr($str,0,$j); 
            if ($ty) { 
                return $str.".."; 
            } else { 
                return $str; 
            } 
        } else { 
            return $str; 
        } 
} 

/* new 아이콘 생성(새로 추가한 함수) */
function new_icon_show($check_date, $check_day, $icon_url)
{
	//오늘 날짜 구하기(타임스탬프)
	list($year, $month, $day, $hour, $min, $sec)=explode("-", date("Y-m-d-H-i-s"));
	$today=mktime($hour, $min, $sec, $month, $day, $year);

	//글쓴 날짜 구하기(타임스탬프)
	$reg_day=trim($check_date);
	$reg_day=str_replace(" ", "-", $reg_day);
	$reg_day=str_replace(":", "-", $reg_day);
	list($year2, $month2, $day2, $hour2, $min2, $sec2)=explode("-", $reg_day);
	$reg_day=mktime($hour2, $min2, $sec2, $month2, $day2, $year2);

	//오늘 날짜와 글쓴 날짜의 차이 구하기(초단위)
	$gap_sec=$today-$reg_day;
	//오늘 날짜와 글쓴 날짜의 차이 구하기(일단위)
	$gap_day=$gap_sec/86400;

	if($gap_day<$check_day)
	{
		$new_icon_msg=$icon_url;
	}
	return $new_icon_msg;
}

?>