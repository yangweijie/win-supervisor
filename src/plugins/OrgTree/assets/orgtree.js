
$('.form-ctrl').each(function () {
	// 调用
	$(this).orgTree({
		org_url: $(this).attr('data-url'),
		all: true,                //人物组织都开启
		area: ['620px', '542px'],  //弹窗框宽高
		search: true              //开启搜索
	});
});
