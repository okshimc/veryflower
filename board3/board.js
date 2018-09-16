// JavaScript Document
<!--

function zoom_open(img)
{
	window.open("zoom.php?img="+img,"zoom","resizable=no,scrollbars=yes,status=yes,width=420,height=400");
}

function list_part_search()
{
	document.board_list_form.submit();
}

function part_search()
{
	document.board_form.submit();
}

function list_search_chk() //게시물 검색하기전 검색어 입력 체크
{
	document.board_list_form.action="list.php";
	document.board_list_form.submit();
}

function search_chk() //게시물 검색하기전 검색어 입력 체크
{
	document.board_form.action="list.php";
	document.board_form.submit();
}

function pw_chk()
{
	if(document.pw_form.passwd.value.length==0)
	{
		alert("비밀번호를 입력하세요.");
		document.pw_form.passwd.focus();
		return;
	}
	document.pw_form.submit();
}

function board_ent()
{
	if(event.keyCode==13)
	{
		board_chk();
	}
}

function write_chk()
{
	if(document.board_form.part && document.board_form.part.value=="")
	{
		alert("분류를 선택하세요.");
		document.board_form.part.focus();
		return;
	}
	if(document.board_form.name.value=="") 
	{
		alert("이름을 입력하세요.");
		document.board_form.name.focus();
		return;
	}
	if(document.board_form.title.value=="") 
	{
		alert("제목을 입력하세요.");
		document.board_form.title.focus();
		return;
	}
	oEditors.getById["w_content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
	if(document.getElementById("w_content").value=="") 
	{
		alert("내용을 입력하세요.");
		return;
	}
	if(document.board_form.passwd && document.board_form.passwd.value=="") 
	{
		alert("비밀번호를 입력하세요.");
		document.board_form.passwd.focus();
		return;
	}

	if(document.board_form.zsfCode && document.board_form.zsfCode.value=="")
	{
		alert("스팸방지코드를 입력해 주세요.\r\n(스팸광고 방지를 위함)");
		document.board_form.zsfCode.focus();
		return;
	}

	if(!confirm("작성하신 글을 저장하시겠습니까?")) return;
	document.board_form.action="save.php";
	document.board_form.submit();
}

function edit_chk()
{
	if(document.board_form.part && document.board_form.part.value=="")
	{
		alert("분류를 선택하세요.");
		document.board_form.part.focus();
		return;
	}
	if(document.board_form.name.value=="") 
	{
		alert("이름을 입력하세요.");
		document.board_form.name.focus();
		return;
	}
	if(document.board_form.title.value=="") 
	{
		alert("제목을 입력하세요.");
		document.board_form.title.focus();
		return;
	}
	oEditors.getById["w_content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
	if(document.getElementById("w_content").value=="") 
	{
		alert("내용을 입력하세요.");
		return;
	}
	if(document.board_form.passwd && document.board_form.passwd.value=="") 
	{
		alert("비밀번호를 입력하세요.");
		document.board_form.passwd.focus();
		return;
	}

	if(document.board_form.zsfCode && document.board_form.zsfCode.value=="")
	{
		alert("스팸방지코드를 입력해 주세요.\r\n(스팸광고 방지를 위함)");
		document.board_form.zsfCode.focus();
		return;
	}

	if(!confirm('수정하시겠습니까?')) return;
	document.board_form.action="save.php";
	document.board_form.submit();
}

function reply_chk()
{
	if(document.board_form.name.value=="") 
	{
		alert("이름을 입력하세요.");
		document.board_form.name.focus();
		return;
	}
	if(document.board_form.title.value=="") 
	{
		alert("제목을 입력하세요.");
		document.board_form.title.focus();
		return;
	}
	oEditors.getById["w_content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
	if(document.getElementById("w_content").value=="") 
	{
		alert("내용을 입력하세요.");
		return;
	}
	if(document.board_form.passwd && document.board_form.passwd.value=="") 
	{
		alert("비밀번호를 입력하세요.");
		document.board_form.passwd.focus();
		return;
	}

	if(document.board_form.zsfCode && document.board_form.zsfCode.value=="")
	{
		alert("스팸방지코드를 입력해 주세요.\r\n(스팸광고 방지를 위함)");
		document.board_form.zsfCode.focus();
		return;
	}

	if(!confirm('답변을 저장하시겠습니까?')) return;
	document.board_form.action="save.php";
	document.board_form.submit();
}

function view_chk(type)
{
	if(type=="edit")
	{
		document.board_form.mode.value="edit";
		document.board_form.action="edit.php";
		document.board_form.submit();
	}
	if(type=="reply")
	{
		document.board_form.mode.value="reply";
		document.board_form.action="reply.php";
		document.board_form.submit();
	}
	if(type=="del")
	{
		document.board_form.mode.value="del";
		document.board_form.action="passwd.php";
		document.board_form.submit();
	}
	if(type=="direct_del")
	{
		if(!confirm("삭제 하시겠습니까?")) return;
		document.board_form.mode.value="del";
		document.board_form.action="save.php";
		document.board_form.submit();
	}
	if(type=="list")
	{
		document.board_form.action="list.php";
		document.board_form.submit();
	}
}

function req_check()
{
	if(document.req_form.req_cate && document.req_form.req_cate[0].selected==true)
	{
		alert("질문유형을 선택하세요!");
		document.req_form.req_cate.focus();
		return;
	}
	if(document.req_form.req_name && document.req_form.req_name.value=="")
	{
		alert("이름을 입력하세요!");
		document.req_form.req_name.focus();
		return;
	}
	if(document.req_form.req_office && document.req_form.req_office.value=="")
	{
		alert("회사명을 입력하세요!");
		document.req_form.req_office.focus();
		return;
	}
	if(document.req_form.req_phone1 && document.req_form.req_phone1.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone1.focus();
		return;
	}
	if(document.req_form.req_phone2 && document.req_form.req_phone2.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone2.focus();
		return;
	}
	if(document.req_form.req_phone3 && document.req_form.req_phone3.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone3.focus();
		return;
	}
	if(document.req_form.req_email && document.req_form.req_email.value=="")
	{
		alert("이메일을 입력하세요!");
		document.req_form.req_email.focus();
		return;
	}
	if(document.req_form.req_title && document.req_form.req_title.value=="")
	{
		alert("제목을 입력하세요!");
		document.req_form.req_title.focus();
		return;
	}
	if(document.req_form.req_content && document.req_form.req_content.value=="")
	{
		alert("내용을 입력하세요!");
		document.req_form.req_content.focus();
		return;
	}

	if(!confirm("신청하시겠습니까?")) return;
	document.req_form.submit();
}

function req_check2()
{
	if(document.req_form.req_name && document.req_form.req_name.value=="")
	{
		alert("이름을 입력하세요!");
		document.req_form.req_name.focus();
		return;
	}
	if(document.req_form.req_phone1 && document.req_form.req_phone1.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone1.focus();
		return;
	}
	if(document.req_form.req_phone2 && document.req_form.req_phone2.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone2.focus();
		return;
	}
	if(document.req_form.req_phone3 && document.req_form.req_phone3.value=="")
	{
		alert("전화번호를 입력하세요!");
		document.req_form.req_phone3.focus();
		return;
	}
	if(document.req_form.req_email && document.req_form.req_email.value=="")
	{
		alert("이메일을 입력하세요!");
		document.req_form.req_email.focus();
		return;
	}
	if(document.req_form.req_spare1 && document.req_form.req_spare1.value=="")
	{
		alert("품목을 입력하세요!");
		document.req_form.req_spare1.focus();
		return;
	}
	if(document.req_form.req_spare2 && document.req_form.req_spare2.value=="")
	{
		alert("구입예상금액을 입력하세요!");
		document.req_form.req_spare2.focus();
		return;
	}
	/*
	if(document.req_form.req_content && document.req_form.req_content.value=="")
	{
		alert("기타사항을 입력하세요!");
		document.req_form.req_content.focus();
		return;
	}
	*/

	if(!confirm("신청하시겠습니까?")) return;
	document.req_form.submit();
}

function post_open(post_type) //우편번호 검색 새창 열기
{
 window.open("post_check.php?post_type="+post_type,"post_chk",
				"width=466,height=400,status=yes,scrollbars=yes");
}

//-->