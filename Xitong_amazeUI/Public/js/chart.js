$(document).ready(function() {

// 书数目表
	var data1 = {
		labels : ["一天内","一周内","一个月内","总共"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				data : $('#bookCount').attr('data-data').split('-')
			}]
	};

	var ctx1 = $('#bookCount').get(0).getContext('2d');
	var myNewChart1 = new Chart(ctx1).Bar(data1);
// 笔记数目表
	var data2 = {
		labels : ["15", "14", "13", "12", "11", "10", "9", "8", "7", "6", "5", "4", "3", "2", "1"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : $('#noteEveryCount').attr('data-data').split('-')
				}]
	};
	var ctx2 = $('#noteEveryCount').get(0).getContext('2d');
	var myNewChart2 = new Chart(ctx2).Line(data2);

// 评论数目表
	var values3 = $('#commentCount').attr('data-data').split('-');
	var data3 = [
		{
			value: values3[0] + 1,
			color:"#F38630"
		},
		{
			value : values3[1] + 1,
			color : "#E0E4CC"
		},
		{
			value : values3[2] + 1,
			color : "#69D2E7"
		},
		{
			value : values3[3] + 1,
			color: "#aaaaaa"
		}];
	var ctx3 = $('#commentCount').get(0).getContext('2d');
	var myNewChart3 = new Chart(ctx3).Pie(data3);

// 用户信息表
	var values4 = $('#userEveryCount').attr('data-data').split('-');
	var data4 = {
		labels : ["15", "14", "13", "12", "11", "10", "9", "8", "7", "6", "5", "4", "3", "2", "1"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : $('#userEveryCount').attr('data-data').split('-')
				}]
	};
	var ctx4 = $('#userEveryCount').get(0).getContext('2d');
	var myNewChart4 = new Chart(ctx4).Line(data4);

});