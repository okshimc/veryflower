<?php include("top_board.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<script src="board.js" language="javascript"></script>
<!--board_form start-->
<form name="board_form" method="post" action="" enctype="multipart/form-data" onSubmit="return reply_chk();">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="w_seq" value="<?=$w_seq?>">
<input type="hidden" name="kind_code" value="<?=$kind_code?>">
<input type="hidden" name="search_part" value="<?=$search_part?>">
<input type="hidden" name="search_name" value="<?=$search_name?>">
<input type="hidden" name="mode" value="<?=$mode?>">
  <tr>
	<td>
    <div class="tableEditLayout">
    <table summary="분류, 이름, 비밀번호, 이메일, 제목, 공개여부, 첨부파일, 스팸방지가 있습니다.">
    <caption>게시판 작성</caption>
    <colgroup>
    <col width="12%" />
    <col />
    </colgroup>
    <tbody>

		<tr>
		  <th scope="row">이 름</th>
		  <td><input name="name" type="text" class="form_box1" value="<?=$row[w_name]?>" size="30"></td>
		</tr>
		<?php if(!$_SESSION[ok_id]){?>
		<tr>
		  <th scope="row">비밀번호</th>
		  <td><input name="passwd" type="password" class="form_box1" value="" size="30"></td>
		</tr>
		<?php }?>
		<tr>
		  <th scope="row">이메일</th>
		  <td><input name="email" type="text" class="form_box1" size="50" value="<?=$row[w_email]?>"></td>
		</tr>
		<tr>
		  <th scope="row">제 목</th>
		  <td><input name="title" type="text" class="form_box1" size="60" value="<?=htmlspecialchars($row[w_title])?>"></td>
		</tr>
		<!--
		<?//=$notag_check_start?>
		<tr height="30" bgcolor="#ffffff"> 
		  <td bgcolor="F4FAFE">
		  <img src="img/bullet2_1_company.gif" width="3" height="3" hspace="3" align="absmiddle">
		  <span style="color: #666666">작성방법</span></td>
		  <td>
		  <input name="tagyn" type="radio" value="n" class="i">
		  Text 입력
		  <input name="tagyn" type="radio" value="y" class="i">
		  Html 사용</td>
		</tr>
		<?//=$tagyn_check_js?>
		<?//=$notag_check_end?>
		-->
		<?=$nolock_check_start?>
		<tr>
		  <th scope="row">공개여부</th>
		  <td>
		  <input type="checkbox" name="lockyn" value="y" class="i">
		  비공개로 합니다.
		  </td>
		</tr>
		<?=$nolock_check_end?>
		<tr>
		  <th scope="row">내용</th>
		  <td>
	  <textarea name="w_content" id="w_content" style="width:610px; height:300px;border:1px solid #eeeeee;"></textarea>

<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<script type="text/javascript">
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "w_content",
	sSkinURI: "/smarteditor2/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});

function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
	oEditors.getById["w_content"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["w_content"].getIR();
	alert(sHTML);
}
	
function submitContents(elClickedObj) {
	oEditors.getById["w_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	
	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

function setDefaultFont() {
	var sDefaultFont = '궁서';
	var nFontSize = 24;
	oEditors.getById["w_content"].setDefaultFont(sDefaultFont, nFontSize);
}
</script>

		  </td>
		</tr>
		<?=$noappend_check_start?>
		<tr>
		  <th scope="row">첨부파일</th>
		  <td>
		  <input name="upfile[]" type="file" size="46" class="form_box1">
		  <input type="checkbox" name="delno[]" value="<?=$file_delno_0?>" style="border:0px;">삭제
		  <?=$file_viewimg_0?>
		  </td>
		</tr>
		<?=$noappend_check_end?>

		<tr>
		  <th scope="row">보안문자</th>
		  <td>
<img id="zsfImg" src="zmSpamFree.php?zsfimg" alt="여기를 클릭해 주세요." title="SpamFree.kr" style="border: none; cursor: pointer" onclick="this.src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime()" />
<a href="javascript:;"><img src="img/other_img.jpg" alt="다른그림보기" style="border:0px;" align="absmiddle" onclick="document.getElementById('zsfImg').src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime();" /></a>
<br />
<input type="text" name="zsfCode" id="zsfCode" size="20" class="form_box1" />
스팸방지를 위해 보안문자를 입력해주세요.
		  </td>
		</tr>

	</table></td>
  </tr>
  <tr>
	<td>
    <div class="btn_board_a">
       <!-- <input type="image" src="img/btn_check.gif" style="border:0px;">-->
        <a href="javascript:reply_chk();" class="btn_board">확인</a>
        <a href="list.php?kind_code=<?=$kind_code?>" class="btn_board">목록</a>
   </div>
   </td>
  </tr>
</form>
<!--board_form end-->
</table>

<?php include("foot_board.php");?>
