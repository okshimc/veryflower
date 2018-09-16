<?php
header("Content-type: text/html; charset=utf-8");
session_start();
include("../inc/dbcon.php");
include("board_inc/board_function.php");
include("board_inc/board_kind_top.php");
include("thumbnail_class.php");

$ymd_dir=date("Ymd");
$board_upload_new_dir=$board_upload_dir."/".$ymd_dir;

if(!is_dir($board_upload_dir."/".$ymd_dir))
{
	mkdir($board_upload_dir."/".$ymd_dir, 0777);
}

$board_db="board_".$kind_code;
$href="page=$page&kind_code=$kind_code&search_part=$search_part&search_name=$search_name";

//if(!$tagyn) $tagyn="n";
$tagyn="y";
if(!$lockyn) $lockyn="n";
if(!$noticeyn) $noticeyn="0";

if($_SESSION[ok_id]) $memberyn="y";
else $memberyn="n";

/* 게시물 삭제를 선택한 경우 */
if($mode=="del")
{
	$sql="select w_id, w_passwd from $board_db where w_seq='$w_seq'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	if(strlen($row[w_id])>0)
	{
		if($row[w_id]!=$_SESSION[ok_id])
		{
			echo("
				<script language='javascript'>
					alert('회원님이 작성하신 글만 수정/삭제 가능합니다.');
					history.back();
				</script>
					");
			exit();
		}
	}
	else
	{
		if($row[w_passwd]!=$passwd)
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

	//일단 삭제하려는 게시물의 제목과 내용을 없앤다
	$zero_sql="update $board_db set
						w_title='', w_content=''
						where w_seq='$w_seq'";
	mysql_query($zero_sql);

	//삭제하려는 게시물의 w_group/w_top/w_step 값을 구한다
	$sql="select w_group, w_top, w_step from $board_db
										where w_seq='$w_seq'";
	$result=mysql_query($sql);

	//첨부파일 삭제 해주기
	if(strlen($kind_code)>0 && strlen($w_seq)>0)
	{
		$file_sql="select *
							from $board_file_db
							where file_wcode='$kind_code'
							and file_wseq='$w_seq'";
		$file_result=mysql_query($file_sql, $connect);

		while($file_row=mysql_fetch_array($file_result))
		{
			if($file_row[file_regname])
			{
				unlink("$board_upload_dir/$file_row[file_path]/$file_row[file_regname]");
			}
		}

		$file_sql="delete from $board_file_db
							where file_wcode='$kind_code'
							and file_wseq='$w_seq'";
		mysql_query($file_sql, $connect);
	}

	//삭제하려는 게시물의 w_group/w_top/w_step 값이 있으면...
	if($row=mysql_fetch_array($result))
	{
		$group=$row[w_group]; //그룹값
		$top=$row[w_top]; //상하 정렬값
		$step=$row[w_step]; //좌우 정렬값
		//삭제하려는 게시물의 답글이 있나 알아보는 함수(없으면 0, 있으면 1을 반환)
		$value=record_chk($board_db, $group, $top, $step);

		if(!$value) //삭제하려는 게시물의 답글이 없으면...
		{
			//삭제하려는 게시물과 group값은 같고, top값은 작거나 같은 게시물이 있나 알아보기
			$sql2="select w_title, w_top, w_step
									from $board_db
									where w_group='$group'
									and w_top<='$top'
									order by w_top desc";
			$result2=mysql_query($sql2);

			//위의 결과값이 있으면...
			while($row2=mysql_fetch_array($result2))
			{
				$top2=$row2[w_top]; //상하 정렬값
				$step2=$row2[w_step]; //좌우 정렬값
				$title2=$row2[w_title]; //게시물 제목
				//삭제하려는 게시물의 답글이 있나 알아보는 함수(없으면 0, 있으면 1을 반환)
				$value2=record_chk($board_db, $group, $top2, $step2);
				
				//삭제하려는 게시물이 제목도 없고, 답글도 없으면...
				if(!$value2 and !$title2)
				{
					//해당 게시물 안심하고 삭제 해주기
					$del_sql="delete from $board_db
										where w_group='$group'
										and w_top='$top2'
										and w_step='$step2'";
					mysql_query($del_sql);
					
					//삭제한 게시물보다 top값이 큰 게시물은 모조리 1씩 빼주기
					$up_sql="update $board_db set
										w_top=w_top-1
										where w_group='$group'
										and w_top>'$top2'";
					mysql_query($up_sql);
				}
				//삭제하려는 게시물이 제목이 있거나 답글이 있으면...
				else 
				{
					break; //게시물 삭제하지 않고 빠져나간다.
				}
			} //end while
		} //end if(!$value)
	} //end if($row=mysql_fetch_array($result))

	echo("
		<script language='javascript'>
			location.href='list.php?$href';
		</script>
			");

} //end if($mode=='del')


if($mode=="input")
{
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
			echo "<script>alert('보안문자가 맞지 않습니다. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
			exit;
		}
	}
	/*
	else
	{
		echo "<script>alert('보안문자를 입력해 주세요. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
		exit;
	}
	*/

	$ip=getenv("REMOTE_ADDR");

	if($_FILES["upfile"])
	{
		$num_file=count($_FILES["upfile"]);
		//$num_file=count($_FILES["upfile"]["name"]);

		for($i=0; $i<$num_file; $i++)
		{
			if($_FILES["upfile"]["name"][$i])
			{
				$file_ext=get_ext($_FILES["upfile"]["name"][$i]);

				if($tmp_row[kind_gallerycheck]=="1")
				{
					if($file_ext[1]!=".jpg" && $file_ext[1]!=".gif" && $file_ext[1]!=".bmp" && $file_ext[1]!=".png" && $file_ext[1]!=".jpeg")
					{
						echo("
							<script language='javascript'>
								alert('이미지 파일만 업로드 가능합니다.');
								history.back();
							</script>
							");
						exit();
					}
				}
				else
				{
					if($file_ext[1]==".html" || $file_ext[1]==".htm" || $file_ext[1]==".php" || $file_ext[1]==".phps" || $file_ext[1]==".cgi" || $file_ext[1]==".xml")
					{
						echo("
							<script language='javascript'>
								alert('업로드 불가능한 파일이 있습니다.');
								history.back();
							</script>
							");
						exit();
					}
				}
			}
		}
	}

	//게시물 입력하기
	$sql="insert into $board_db set
						w_seq='',
						w_code='$kind_code',
						w_part='$part',
						w_id='$_SESSION[ok_id]',
						w_name='$name',
						w_passwd='$passwd',
						w_email='$email',
						w_title='$title',
						w_content='$w_content',
						w_date=now(),
						w_ip='$ip',
						w_read=0,
						w_group=0,
						w_top=0,
						w_step=0,
						w_tagyn='$tagyn',
						w_lockyn='$lockyn',
						w_memberyn='$memberyn'
						";
	$result=mysql_query($sql);

	$w_seq=mysql_insert_id();

	$sql="update $board_db set
				w_group='$w_seq'
				where w_seq='$w_seq'";
	mysql_query($sql);

	if($_FILES["upfile"])
	{
		$num_file=count($_FILES["upfile"]);
		//$num_file=count($_FILES["upfile"]["name"]);

		for($i=0; $i<$num_file; $i++)
		{
			if($_FILES["upfile"]["name"][$i])
			{
				$file_name[$i]=$_FILES["upfile"]["name"][$i];
				$nowtime=time();
				//$file_name[$i]=str_replace("-", "", $file_name[$i]);
				//$file_name[$i]=str_replace(" ", "", $file_name[$i]);
				//$file_name[$i]=str_replace("/", "", $file_name[$i]);
				//$file_name[$i]=str_replace("_", "", $file_name[$i]);
				//$file_name[$i]=$nowtime.$file_name[$i];
				$file_ext=get_ext($file_name[$i]);
				$file_name[$i]=$nowtime."_".$i.$file_ext[1];
				$to_name=$board_upload_new_dir."/".$file_name[$i];
				$from_name=$_FILES["upfile"]["tmp_name"][$i];
				$file_size[$i]=$_FILES["upfile"]["size"][$i];
				$file_type[$i]=$_FILES["upfile"]["type"][$i];

				if(move_uploaded_file($from_name, $to_name))
				{
					$file_name2[$i]=$_FILES["upfile"]["name"][$i];
				}

				$file_ext=get_ext($file_name[$i]);
				if($file_ext[1]==".jpg" && $file_ext[1]==".gif" && $file_ext[1]==".bmp" && $file_ext[1]==".png" && $file_ext[1]==".jpeg") $img_resize_check="y";

				if($file_name[$i] && $i==0 && $img_resize_check=="y")
				{
					$smallimg_size=img_resize($board_upload_new_dir."/".$file_name[$i], $config_img_width, $config_img_height);
					$smallimg_width=intval($smallimg_size[0]);
					$smallimg_height=intval($smallimg_size[1]);

					$obj = new thumbImage;
					$obj->real_path = $board_upload_new_dir; //저장된 이미지가 있는곳.
					$obj->target_path = $board_upload_new_dir; //썸네일 이미지가 저장될 곳.
					$obj->add_name = "small_"; //없어도 됨. 기본값 thumb
					$obj->image_quality = 75; //없어도 됨. 기본값 75 (75%가 가장 압축대 화질이 괜찮아서)
					#imageResize(파일명, 변환될 확장자, 가로사이즈, 세로사이즈)
					$obj->imageResize($file_name[$i], 'jpg', $smallimg_width, $smallimg_height);
				}

				$file_sql="insert into $board_file_db set
								file_no='',
								file_wcode='$kind_code', /* 게시판 코드 */
								file_wseq='$w_seq', /* 게시물 번호 */
								file_sequence='$i', /* 파일 순서 */
								file_regname='$file_name[$i]', /* 파일명(시간_파일명) */
								file_orgname='$file_name2[$i]', /* 원본 파일명 */
								file_path='$ymd_dir', /* 파일 경로 */
								file_size='$file_size[$i]', /* 파일 크기 */
								file_type='$file_type[$i]', /* 파일 타입 */
								file_down='0' /* 다운로드 수 */";
				mysql_query($file_sql, $connect);
			}
		} //end for($i=0; $i<$num_file; $i++)
	} //end if($_FILES["upfile"])

	echo("
		<script language='javascript'>
			location.href='list.php?$href';
		</script>
			");

} //end if($mode=="input")


if($mode=="edit")
{
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
			echo "<script>alert('보안문자가 맞지 않습니다. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
			exit;
		}
	}
	/*
	else
	{
		echo "<script>alert('보안문자를 입력해 주세요. (광고 게시물 자동등록 방지를 위함)');history.back(-1);</script>";
		exit;
	}
	*/

	$sql="select w_part, w_id, w_passwd, w_group, w_step
						from $board_db
						where w_seq='$w_seq'";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	$w_group=$row[w_group];

	if(strlen($row[w_id])>0)
	{
		if($row[w_id]!=$_SESSION[ok_id])
		{
			echo("
				<script language='javascript'>
					alert('회원님이 작성하신 글만 수정/삭제 가능합니다.');
					history.back();
				</script>
					");
			exit();
		}
	}
	else
	{
		if($row[w_passwd]!=$passwd)
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

	if($row[w_step]>0)
	{
		$sql="select w_part from $board_db
						where w_group='$w_group'
						and w_step='0'";
		$result=mysql_query($sql, $connect);
		$row=mysql_fetch_array($result);
		$part=$row[w_part];
	}

	$ip=getenv("REMOTE_ADDR");

	if($_FILES["upfile"])
	{
		$num_file=count($_FILES["upfile"]);
		//$num_file=count($_FILES["upfile"]["name"]);

		for($i=0; $i<$num_file; $i++)
		{
			if($_FILES["upfile"]["name"][$i])
			{
				$file_ext=get_ext($_FILES["upfile"]["name"][$i]);

				if($tmp_row[kind_gallerycheck]=="1")
				{
					if($file_ext[1]!=".jpg" && $file_ext[1]!=".gif" && $file_ext[1]!=".bmp" && $file_ext[1]!=".png" && $file_ext[1]!=".jpeg")
					{
						echo("
							<script language='javascript'>
								alert('이미지 파일만 업로드 가능합니다.');
								history.back();
							</script>
							");
						exit();
					}
				}
				else
				{
					if($file_ext[1]==".html" || $file_ext[1]==".htm" || $file_ext[1]==".php" || $file_ext[1]==".phps" || $file_ext[1]==".cgi" || $file_ext[1]==".xml")
					{
						echo("
							<script language='javascript'>
								alert('업로드 불가능한 파일이 있습니다.');
								history.back();
							</script>
							");
						exit();
					}
				}
			}
		}
	}

	//게시물 수정하기
	$sql="update $board_db set
						w_part='$part',
						w_id='$_SESSION[ok_id]',
						w_name='$name',
						w_passwd='$passwd',
						w_email='$email',
						w_title='$title',
						w_content='$w_content',
						w_tagyn='$tagyn',
						w_lockyn='$lockyn',
						w_memberyn='$memberyn'
						where w_seq='$w_seq'";
	mysql_query($sql);

	$sql="update $board_db set
						w_part='$part'
						where w_group='$w_group'";
	mysql_query($sql);

	$delno_size=sizeof($delno);
	for($i=0; $i<$delno_size; $i++)
	{
		$tmp_sql="select * from $board_file_db
								where file_wcode='$kind_code'
								and file_wseq='$w_seq'
								and file_sequence='$delno[$i]'";
		$tmp_result=mysql_query($tmp_sql, $connect);
		$tmp_row=mysql_fetch_array($tmp_result);

		if($tmp_row[file_regname])
		{
			unlink("$board_upload_dir/$tmp_row[file_path]/$tmp_row[file_regname]");

			if(file_exists($board_upload_dir."/".$tmp_row[file_path]."/small_".$tmp_row[file_regname]))
			{
				unlink($board_upload_dir."/".$tmp_row[file_path]."/small_".$tmp_row[file_regname]);
			}

			$file_sql="delete from $board_file_db
								where file_wcode='$kind_code'
								and file_wseq='$w_seq'
								and file_sequence='$delno[$i]'";
			mysql_query($file_sql, $connect);
		}
	}

	if($_FILES["upfile"])
	{
		$num_file=count($_FILES["upfile"]);
		//$num_file=count($_FILES["upfile"]["name"]);

		for($i=0; $i<$num_file; $i++)
		{
			if($_FILES["upfile"]["name"][$i])
			{
				$file_name[$i]=$_FILES["upfile"]["name"][$i];
				$nowtime=time();
				//$file_name[$i]=str_replace("-", "", $file_name[$i]);
				//$file_name[$i]=str_replace(" ", "", $file_name[$i]);
				//$file_name[$i]=str_replace("/", "", $file_name[$i]);
				//$file_name[$i]=str_replace("_", "", $file_name[$i]);
				//$file_name[$i]=$nowtime.$file_name[$i];
				$file_ext=get_ext($file_name[$i]);
				$file_name[$i]=$nowtime."_".$i.$file_ext[1];
				$to_name=$board_upload_new_dir."/".$file_name[$i];
				$from_name=$_FILES["upfile"]["tmp_name"][$i];
				$file_size[$i]=$_FILES["upfile"]["size"][$i];
				$file_type[$i]=$_FILES["upfile"]["type"][$i];

				if(move_uploaded_file($from_name, $to_name))
				{
					$file_name2[$i]=$_FILES["upfile"]["name"][$i];
				}

				$file_ext=get_ext($file_name[$i]);
				if($file_ext[1]==".jpg" && $file_ext[1]==".gif" && $file_ext[1]==".bmp" && $file_ext[1]==".png" && $file_ext[1]==".jpeg") $img_resize_check="y";

				if($file_name[$i] && $i==0 && $img_resize_check=="y")
				{
					$smallimg_size=img_resize($board_upload_new_dir."/".$file_name[$i], $config_img_width, $config_img_height);
					$smallimg_width=intval($smallimg_size[0]);
					$smallimg_height=intval($smallimg_size[1]);

					$obj = new thumbImage;
					$obj->real_path = $board_upload_new_dir; //저장된 이미지가 있는곳.
					$obj->target_path = $board_upload_new_dir; //썸네일 이미지가 저장될 곳.
					$obj->add_name = "small_"; //없어도 됨. 기본값 thumb
					$obj->image_quality = 75; //없어도 됨. 기본값 75 (75%가 가장 압축대 화질이 괜찮아서)
					#imageResize(파일명, 변환될 확장자, 가로사이즈, 세로사이즈)
					$obj->imageResize($file_name[$i], 'jpg', $smallimg_width, $smallimg_height);
				}

				$tmp_sql="select * from $board_file_db
									where file_wcode='$kind_code'
									and file_wseq='$w_seq'
									and file_sequence='$i'";
				$tmp_result=mysql_query($tmp_sql, $connect);
				$tmp_row=mysql_fetch_array($tmp_result);

				if($tmp_row[file_regname])
				{
					unlink("$board_upload_dir/$tmp_row[file_path]/$tmp_row[file_regname]");

					$file_sql="update $board_file_db set
									file_sequence='$i', /* 이미지 순서 */
									file_regname='$file_name[$i]', /* 파일명(시간_파일명) */
									file_orgname='$file_name2[$i]', /* 원본 파일명 */
									file_path='$ymd_dir', /* 파일 경로 */
									file_size='$file_size[$i]', /* 파일 크기 */
									file_type='$file_type[$i]' /* 파일 타입 */
									where file_wcode='$kind_code'
									and file_wseq='$w_seq'
									and file_sequence='$i'";
					mysql_query($file_sql, $connect);
				}
				else
				{
					$file_sql="insert into $board_file_db set
									file_no='',
									file_wcode='$kind_code', /* 게시판 코드 */
									file_wseq='$w_seq', /* 게시물 번호 */
									file_sequence='$i', /* 파일 순서 */
									file_regname='$file_name[$i]', /* 파일명(시간_파일명) */
									file_orgname='$file_name2[$i]', /* 원본 파일명 */
									file_path='$ymd_dir', /* 파일 경로 */
									file_size='$file_size[$i]', /* 파일 크기 */
									file_type='$file_type[$i]', /* 파일 타입 */
									file_down='0' /* 다운로드 수 */";
					mysql_query($file_sql, $connect);
				}
			} //end if($_FILES["upfile"]["name"][$i])
		} //end for($i=0; $i<$num_file; $i++)
	} //end if($_FILES["upfile"])

	echo("
		<script language='javascript'>
			location.href='list.php?$href';
		</script>
			");

} //end if($mode=="edit")


if($mode=="reply")
{
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

	$ip=getenv("REMOTE_ADDR");

	//부모글의 w_group, w_top, w_step값 구하기
	$sql="select w_part, w_group, w_top, w_step
							from $board_db
							where w_seq='$w_seq'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	//답변글에 입력할 w_top, w_step값 지정
	$top2=$row[w_top]+1;
	$step2=$row[w_step]+1;
	$part=$row[w_part];

	//같은 그룹의 글중에서 w_top값이 부모글의 w_top값보다 큰값은 모두 +1 해주기
	$up_sql="update $board_db set w_top=w_top+1
							where w_group='$row[w_group]' and w_top>'$row[w_top]'";
	mysql_query($up_sql);

	//답변글 입력해주기
	$ins_sql="insert into $board_db set
							w_seq='',
							w_part='$part',
							w_id='$_SESSION[ok_id]',
							w_name='$name',
							w_passwd='$passwd',
							w_email='$email',
							w_title='$title',
							w_content='$w_content',
							w_date=now(),
							w_ip='$ip',
							w_read=0,
							w_group='$row[w_group]',
							w_top='$top2',
							w_step='$step2',
							w_tagyn='$tagyn',
							w_lockyn='$lockyn',
							w_memberyn='$memberyn'";
	mysql_query($ins_sql);
	$w_seq=mysql_insert_id();

	if($_FILES["upfile"])
	{
		$num_file=count($_FILES["upfile"]);
		//$num_file=count($_FILES["upfile"]["name"]);

		for($i=0; $i<$num_file; $i++)
		{
			if($_FILES["upfile"]["name"][$i])
			{
				$file_name[$i]=$_FILES["upfile"]["name"][$i];
				$nowtime=time().$i;

				$file_ext=get_ext($file_name[$i]);
				$file_name[$i]=$nowtime."_".$i.$file_ext[1];
				//$file_name[$i]=$nowtime."_".$file_name[$i];
				$to_name=$board_upload_new_dir."/".$file_name[$i];
				$from_name=$_FILES["upfile"]["tmp_name"][$i];
				$file_size[$i]=$_FILES["upfile"]["size"][$i];
				$file_type[$i]=$_FILES["upfile"]["type"][$i];

				if(move_uploaded_file($from_name, $to_name))
				{
					$file_name2[$i]=$_FILES["upfile"]["name"][$i];
				}

				$file_ext=get_ext($file_name[$i]);
				if($file_ext[1]==".jpg" && $file_ext[1]==".gif" && $file_ext[1]==".bmp" && $file_ext[1]==".png" && $file_ext[1]==".jpeg") $img_resize_check="y";

				if($file_name[$i] && $i==0 && $img_resize_check=="y")
				{
					$smallimg_size=img_resize($board_upload_new_dir."/".$file_name[$i], $config_img_width, $config_img_height);
					$smallimg_width=intval($smallimg_size[0]);
					$smallimg_height=intval($smallimg_size[1]);

					$obj = new thumbImage;
					$obj->real_path = $board_upload_new_dir; //저장된 이미지가 있는곳.
					$obj->target_path = $board_upload_new_dir; //썸네일 이미지가 저장될 곳.
					$obj->add_name = "small_"; //없어도 됨. 기본값 thumb
					$obj->image_quality = 75; //없어도 됨. 기본값 75 (75%가 가장 압축대 화질이 괜찮아서)
					#imageResize(파일명, 변환될 확장자, 가로사이즈, 세로사이즈)
					$obj->imageResize($file_name[$i], 'jpg', $smallimg_width, $smallimg_height);
				}

				$file_sql="insert into $board_file_db set
								file_no='',
								file_wcode='$kind_code', /* 게시판 코드 */
								file_wseq='$w_seq', /* 게시물 번호 */
								file_sequence='$i', /* 파일 순서 */
								file_regname='$file_name[$i]', /* 파일명(시간_파일명) */
								file_orgname='$file_name2[$i]', /* 원본 파일명 */
								file_path='$ymd_dir', /* 파일 경로 */
								file_size='$file_size[$i]', /* 파일 크기 */
								file_type='$file_type[$i]', /* 파일 타입 */
								file_down='0' /* 다운로드 수 */";
				mysql_query($file_sql, $connect);
			}
		} //end for($i=0; $i<$num_file; $i++)
	} //end if($_FILES["upfile"])

	echo("
		<script language='javascript'>
			location.href='list.php?$href';
		</script>
			");

} //end if($mode=="reply")

?>