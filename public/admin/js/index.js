layui.config({
	base: '../../static/admin/js/'
}).use(['element', 'layer', 'navbar', 'tab'], function() {
	var element = layui.element(),
		$ = layui.jquery,
		layer = layui.layer,
		navbar = layui.navbar(),
		tab = layui.tab({
			elem: '.admin-nav-card' //设置选项卡容器
		});
	//iframe自适应
	$(window).on('resize', function() {
		var $content = $('.admin-nav-card .layui-tab-content');
		$content.height($(this).height() - 147);
		$content.find('iframe').each(function() {
			$(this).height($content.height());
		});
	}).resize();

	//设置navbar
	navbar.set({
		spreadOne: true,
        data: 'json',
		elem: '#admin-navbar-side',
		cached: false,
		url: '/svn_trans/public/admin/Index/left_menu'
	});
	//渲染navbar
	navbar.render();
	//监听点击事件
	navbar.on('click(side)', function(data) {
		tab.tabAdd(data.field);
	});

	$('.admin-side-toggle').on('click', function() {
		var sideWidth = $('#admin-side').width();
		if(sideWidth === 200) {
			$('#admin-body').animate({
				left: '0'
			}); //admin-footer
			$('#admin-footer').animate({
				left: '0'
			});
			$('#admin-side').animate({
				width: '0'
			});
		} else {
			$('#admin-body').animate({
				left: '200px'
			});
			$('#admin-footer').animate({
				left: '200px'
			});
			$('#admin-side').animate({
				width: '200px'
			});
		}
	});

	//手机设备的简单适配
	var treeMobile = $('.site-tree-mobile'),
		shadeMobile = $('.site-mobile-shade');
	treeMobile.on('click', function() {
		$('body').addClass('site-mobile');
	});
	shadeMobile.on('click', function() {
		$('body').removeClass('site-mobile');
	});
});