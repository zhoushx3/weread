// $.mobile.loading('show', {
// 	text: "zzzzzzzzzzzz"
// });

$(document).bind('mobileinit', function() {
	$.mobile.selectmenu.prototype.options.nativeMenu = true;
});


$(function() {
	// 点击更多按钮
	$('.morebtn').click(function() {
		$(this).next().slideToggle('fast');
		// $('#test').slideToggle('fast').focus();
	});
})


$(function() {
  // 登录
  $('#login_form').submit(function(event) {
  	reg = /^[a-zA-Z0-9_]+$/;
    if ($("#lusername").val() == '' || $("#lpassword").val() == '') {
      alert("请填写完整的表单后进行登录！");
      event.preventDefault();
    } else if (!reg.test($('#lusername').val())) {
    	alert("用户名只能包含数字、字母、下划线");
      event.preventDefault();
    }
  });
});

$(function() {
	// 注册
	$('#register_form').submit(function(event) {
		if ($('#rusername').val() == '' || $('#rpassword').val() == '' || $('#rtwicePassword').val() == '' || $('#remail').val() == '') {
			alert('请填写完整的表单后进行注册！');
			event.preventDefault();
		} else if ($('#rpassword').val().length < 6 || $('#rpassword').val().length > 15) {
    	alert("密码长度在6 - 15之间！");
      event.preventDefault();
    } else if (!($('#rtwicePassword').val() == $('#rpassword').val())) {
    	alert("两次密码输入不相同！");
    	event.preventDefault();
    } else if (!isEmail($('#remail').val())) {
    	event.preventDefault();
    	alert('邮箱格式不正确！');
    } else {
    }
	});
});

// 我的笔记
$(function() {
	$('#addNote').click(function() {
		$('#addNoteForm').toggleClass('active');
	});

	// 添加笔记提交操作验证
	$('#addNoteForm').submit(function(event) {
		if ($(this).find('textarea').val() == "") {
			alert("你还没有填写笔记内容~");
			event.preventDefault();
		}
	});
});


$(function() {
	// 点赞
	$('.heart').click(function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).next().html(parseInt($(this).next().html()-1));
		} else {
			$(this).addClass('active');
			$(this).next().html(parseInt($(this).next().html()+1));
		}
	});

	// 评论区加载更多
	$('.more').click(function() {
		var number = $('.comment').length;
		$.ajax({
			type: 'post',
			url: $(this).attr('name'),
			data: number,
			success: function(data) {
				for (var i = 0; i < data.length - 1; ++i) {
					$('.comments').append("<div class='comments'>" +
						"<p>data[i].user</p>" + 
 						"<p>data[i].comment<span>data[i].time</span></p>" +
					"</div>"
					)
				}
			},
			error: function(data) {
				alert("something wrong~");
			}
		})
	});

	// 点击我的笔记 点击所有笔记 判断是否已登录
	$('a.clickNote').click(function(event) {
		if ($('a[href="#login"]').html() == "未登录") {
			event.preventDefault();
			$('a[href="#login"]').click();
		}
	});
});