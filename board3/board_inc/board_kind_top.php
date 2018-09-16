<?php

$board_db="board_".$kind_code;

$tmp_sql="select * from $board_kind_db
							where kind_code='$kind_code'";
$tmp_result=mysql_query($tmp_sql, $connect);
$tmp_row=mysql_fetch_array($tmp_result);

$board_name=$tmp_row[kind_name];
$board_title_img1=$tmp_row[kind_img1];
$board_title_img2=$tmp_row[kind_img2];

$board_upload_dir=$_SERVER["DOCUMENT_ROOT"].$tmp_row[kind_updir];
$board_upload_path=$tmp_row[kind_updir];

?>