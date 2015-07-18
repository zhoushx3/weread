$(document).ready(function() {
	// 导入点赞的信息
	$.ajax({
		url: $('#clickZan').attr('data-url'),
		type: 'post',
		// id是相对全局的bookid
		data: {'id': id},
		success: function(data) {
			console.log(data);
			$('#clickZan').children('span').text(data['bookzanCount'] + ' 点赞 ');
			if (data['userBookzanCount'] > 0) {
				$('.heart').addClass('active');
			}
		}
	});
	// 点赞
	$('.heart').click(function(event) {
		var count = parseInt($(this).prev().text()); 
		if ($(this).hasClass('active')) {
			$.ajax({
				type: 'post',
				url: $(this).attr('data-url')+'/dian/1/bookid/'+id,
				success: function(data) {
					$(event.target).removeClass('active');
					$(event.target).prev().text(count-1 + ' 点赞 ');
				}
			});
		} else {
			$.ajax({
				type: 'post',
				url: $(this).attr('data-url')+'/bookid/'+id,
				success: function(data) {
					$(event.target).addClass('active');
					$(event.target).prev().text(count + 1 + ' 取消赞 ');
				}
			});
		}
	});
});


$(document).ready(function() {
	// 为侧边栏导入评论信息
	$('#bookReview').click(function(event) {
		$('#bookReviewContainer .am-list').find('*').remove();
		$('#bookReviewContainer .am-list').append(
			'<li class="am-g am-list-item-desced">' +
        '<a class="am-list-item-hd"></a>' +
        '<div class="am-list-item-text"></div>' +
      '</li>');
		$.ajax({
			url: $('.am-accordion.am-accordion-gapped').eq(0).attr('data-url')+'/lookComments',
			type: 'post',
			data: {'id': id},
			success: function(data) {
				for (var i = 1; i < data.length; ++i) {
					$('#bookReviewContainer li').eq(0).clone().insertAfter($('#bookReviewContainer li').eq(0));
				}
				for (i = 0; i < data.length; ++i) {
					$('#bookReviewContainer .am-list-item-hd').eq(i).append('<a href="#">读者: ' + data[i]['username']+ '</a>');
					$('#bookReviewContainer .am-list-item-hd').eq(i).append('<span>' +  getLocalTime(data[i]['create_time'])+ '</span>');
					$('#bookReviewContainer .am-list-item-text').eq(i).append('<p>' + data[i]['comment'] +'</p>');
				}
			},
			error: function(data) {
				$('#bookReviewContainer .am-list-item-hd').append('<p style="color: red">Something wrong happend~</p>')
			}
		});
	});
});