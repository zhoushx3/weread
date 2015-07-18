// bookId global
var id;

$(window).resize(function() {
	
	$(window).off('resize.offcanvas.amui');
	
});

$(document).ready(function() {
	$.AMUI.progress.configure({ ease: 'ease', speed: 700 , parent: '.am-accordion-content' });
	var progress = $.AMUI.progress;
	// 点击图书时显示相应的图书信息和笔记、评论
	$('.singleBook img').click(function() {
		progress.inc();
		id = $(this).attr('data-id');
		$.ajax({
			url: $('.am-accordion.am-accordion-gapped').eq(0).attr('data-url')+'/lookInfo',
			type: 'post',
			data: {'id': id},
			success: function(data) {
				// progress.set(0.7);
				var $info = $('.am-accordion-content');
				$info.find('*').remove();
				var i = 0;
				for (var key in data) {
					// put the former 4 infos in the "图书信息"
					if (i < 4)
						$info.eq(0).append('<p>'+ key + ' : ' + data[key] + '</p>');
					// put the last info in the “图书简介”
					else
						$('.am-accordion-content').eq(1).append('<p>' + data[key] + '</p>');
					++i;
				}
				progress.done(true);
			},
			error: function(data) {
				$('.am-accordion-content').append('<p style="color: red">Something wrong happend~~~</p>')
			}
		});
	});
	
	// 图书信息和图书简介处默认显示第一本书的信息
	$('.singleBook img').eq(0).click();	
});

$(document).ready(function() {
	// 为侧边栏导入笔记信息
	$('#bookNote').click(function(event) {
		$('#bookNoteContainer .am-list').find('*').remove();
		$('#bookNoteContainer .am-list').append(
		 '<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-bottom-left">'+
        '<p class="am-list-item-hd"></p>'+
        '<div class="am-u-sm-4 am-list-thumb"></div>'+
        '<div class=" am-u-sm-8 am-list-main">'+
        '  <div class="am-list-item-text"></div>'+
        '</div>'+
      '</li>');
		$.ajax({
			url: $('.am-accordion.am-accordion-gapped').eq(0).attr('data-url')+'/lookNotes',
			type: 'post',
			data: {'id': id},
			success: function(data) {
				for (var i = 1; i < data.length; ++i) {
					$('#bookNoteContainer li').eq(0).clone().insertAfter($('#bookNoteContainer li').eq(0));
				}
				for (i = 0; i < data.length; ++i) {
					$('#bookNoteContainer .am-list-item-hd').eq(i).append('<a href="#">读者: ' + data[i]['username']+ '</a>');
					$('#bookNoteContainer .am-list-item-hd').eq(i).append('<span>第' + data[i]['chapter'] + '章</span>');
					$('#bookNoteContainer .am-list-item-hd').eq(i).append('<span>第' + data[i]['page'] + '页</span>');
					$('#bookNoteContainer .am-list-item-hd').eq(i).append('<span>' +  getLocalTime(data[i]['create_time'])+ '</span>');
					$('#bookNoteContainer .am-list-item-hd').eq(i).next().append('<img src="/Xitong_amazeUI/Uploads/NotePhotoes/' + data[i]["photo"] + '" alt="笔记贴图" />');
					$('#bookNoteContainer .am-list-item-text').eq(i).append('<p>' + data[i]['note'] + '</p>');
				}
			},
			error: function(data) {
				$('#bookNoteContainer .am-list-item-hd').append('<p style="color: red">Something wrong happend~</p>')
			}
		});
	});
});


// php时间戳转为Js时间戳
function getLocalTime(nS) {     
	return new Date(parseInt(nS) * 1000).toLocaleString();      
}     