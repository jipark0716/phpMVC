var apiScheme = "cdkn://link";

(function ($, window) {

	$('.cc-btn-go-top').bind('click', function (e) {
		e.preventDefault();
		$('html,body').stop().animate({'scrollTop' : 0}, 300);

	});


	/*
	var deliveryActiveClass='cc-btn-delivery-active';
	$('.cc-btn-delivery').bind('click', function () {
		var _self=$(this);
		if(_self.hasClass(deliveryActiveClass)){
			_self.removeClass(deliveryActiveClass);
		}else{
			_self.addClass(deliveryActiveClass);
		}
	});

	var filterChecker=$('.cc-btn-filter'),
		filterActiveClass='cc-btn-filter-active';

	filterChecker.bind('click', function () {
		var _self=$(this);
		if(_self.hasClass(filterActiveClass)){
			_self.removeClass(filterActiveClass);
		}else{
			_self.addClass(filterActiveClass);
		}
	});
	*/

	//nav메뉴 포커스
	$('.cc-navigation-holder').scrollLeft($('.cc-home-navigation-link-active').offset().left);

	var btnCondition=$('.cc-btn-condition');
	var bgObj=$('.cc-bg');
	var bottomFilterBox=$('.cc-filter-box');
	var filterList=$('.cc-filter-list');

	btnCondition.bind('click', function () {
		bottomFilterBox.css('bottom', 0);
		bgObj.fadeIn();
	});

	filterList.bind('click', function () {
		filterList.removeClass('cc-filter-list-active');
		$(this).addClass('cc-filter-list-active');

		var filterText=$(this).text().trim();
		// console.info(filterText);

		btnCondition.text(filterText);
		bottomFilterBox.css('bottom', '-100%');
		bgObj.fadeOut();
	});

	/*
	var filterBoxList=$('.cc-filter-box-list');
	var filterBoxActiveClass='cc-filter-box-active';
	var filterBoxReset=$('.js-filter-reset');

	filterBoxList.bind('click', function () {
		var _self=$(this);
		if(_self.hasClass(filterBoxActiveClass)){
			_self.removeClass(filterBoxActiveClass);
		}else{
			_self.addClass(filterBoxActiveClass);
		}
	});

	filterBoxReset.bind('click', function () {
		filterBoxList.removeClass(filterBoxActiveClass);
	});
	*/



	var orderBtn=$('.js-order-btn');
	var orderBtnActiveClass='cc-order-active';

	orderBtn.bind('click', function () {
		var _self=$(this);
		orderBtn.removeClass(orderBtnActiveClass);
		if(!_self.hasClass(orderBtnActiveClass)){
			_self.addClass(orderBtnActiveClass);
		}
	});

	/*
	var likeChecker2=$('.cc-item-like'),
		likeActiveClass2='cc-item-like-active';

	likeChecker2.bind('click', function () {
		var _self=$(this);
		if(_self.hasClass(likeActiveClass2)){
			_self.removeClass(likeActiveClass2);
		}else{
			_self.addClass(likeActiveClass2);
		}
	});
	*/
	/*
	var starChecker=$('.cc-fave-checker'),
		starActiveClass='cc-fave-active';

	starChecker.bind('click', function () {
		var _self=$(this);
		if(_self.hasClass(starActiveClass)){
			_self.removeClass(starActiveClass)
		}else{
			_self.addClass(starActiveClass)
		}
	});
	*/



	/*
	var naviHolder=$('.cc-navigation-holder');
	var naviBody=$('.cc-home-navigation-body1');
	var naviList=$('.cc-home-navigation-list');
	var totalListWidth=0;
	var naviListActiveIndex=0;

	function adjustNaviWidth(cb){
		naviList.each(function (i, el) {
			var tmp_width=($(el).outerWidth());
			//console.info(tmp_width);

			totalListWidth+=Math.ceil(($(el).outerWidth()));
			//console.info(i);
		});

		// console.info('check list width');
		// console.info('ff;'+totalListWidth);

		naviBody.css('width', totalListWidth + 'px');
		cb();
	}

	function setScrollPos(posLeft){
		naviHolder.animate({'scrollLeft' : posLeft}, 300);
	}

	function getWindowWidth(){
		return parseInt($(window).width());
	}

	function calcNaviPosition(){
		var activeOffsetLeft=0;
		var isStop=false;

		naviList.each(function (i, el) {
			if($(el).find('a').hasClass('cc-home-navigation-link-active')){
				isStop=true;
				naviListActiveIndex=i;
			}

			if(isStop===false){
				activeOffsetLeft+=Math.ceil(($(el).outerWidth()));
				// console.info(i);
			}

		});

		return parseInt(activeOffsetLeft);
	}

	adjustNaviWidth(function (){
		var tmp_new_pos=Math.abs(parseInt(calcNaviPosition() - getWindowWidth()));
		var activNaviWidth = parseInt(Math.ceil(naviList.eq(naviListActiveIndex).outerWidth()));

		//console.info('tmp_new_pos');
		//console.info(tmp_new_pos);
		//console.info(activNaviWidth/2);
		//console.info( tmp_new_pos + activNaviWidth/2 );
		//console.info( getWindowWidth()/2- (tmp_new_pos + (activNaviWidth/2)) );

		if(calcNaviPosition()+naviList.eq(naviListActiveIndex).outerWidth()/2 <= totalListWidth/2){
			//console.info('A');
			naviHolder.animate({'scrollLeft' : 0 }, 300);
		} else if(calcNaviPosition()+naviList.eq(naviListActiveIndex).outerWidth()/2 > totalListWidth/2){
			//console.info('B');
			naviHolder.animate({'scrollLeft' : totalListWidth-getWindowWidth() }, 300);
		}else{
			//console.info('C');
			naviHolder.animate({'scrollLeft' : Math.abs(getWindowWidth()/2- (tmp_new_pos + (activNaviWidth/2))) }, 300);
		}
	});
	*/


	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function getScrollTop(){
		return parseInt($(document).scrollTop());
	}


	$('.cc-item-link').bind('click', function (e){
		//e.preventDefault();
	});
	$('.cc-btn-back').bind('click', function (e){
		history.back();
	});

	window.numberWithCommas=numberWithCommas;
	window.getScrollTop=getScrollTop;


}(jQuery, window));

//public functions
function callApi(e)
{
	var apiUrl = apiScheme + e;
	console.log(apiUrl);
	var r = document.createElement("IFRAME");
	r.setAttribute("src", apiUrl), r.setAttribute("frameborder", "0"), r.style.width = "1px", r.style.height = "1px", document.body.appendChild(r), document.body.removeChild(r), r = null
}
function convUrl(url)
{
	if ( url.substring(0,2) != "//" && url.substring(0,1)=="/" ){
		return siteUrl + url;
	}
	return url;
}
//샵 액티비티
function goShop(shopidx, pdidx, shopurl, shopname)
{
	var url = '/shop?shopidx='+shopidx+'&pdidx='+pdidx + '&url='+encodeURIComponent(shopurl) + "&title=" + encodeURIComponent(shopname);
	callApi(url);
}
//메인 액티비티
function goHome(url)
{
	var url = '/home?url='+encodeURIComponent(convUrl(url));
	callApi(url);
}
//서브 액티비티
function goSub(url)
{
	var url = '/sub?url='+encodeURIComponent(convUrl(url));
	callApi(url);
}
//로그인
function goLogin(mem_idx)
{
	var url = '/login?mem_idx='+mem_idx;
	callApi(url);
}
//로그아웃
function goLogout()
{
	var url = '/logout';
	callApi(url);
}
//액티비티 닫기
function goClose()
{
	var url = '/close';
	callApi(url);
}
/**
* 이전 액티비티 콜백
* @func - 콜백 호출 스크립트 함수 호출명령문
* @depth - 1-opener, 0-모든 activity(self activity 는 제외)
*/
function goOpenerReload(func, depth)
{
	var url = '/openerCallback?func='+encodeURIComponent(func)+"&depth="+depth;
	callApi(url);
}

/**
* 배너 클릭
* @idx - 배너idx
* @child -
*/
function goBanner(idx,child=true){
	goSub(`/html/home_banner.php?idx=${idx}`);
	$.ajax({
		method	: 'POST',
		url		: '/AJAX/index.php',
		data	: {
			mode : 'logging',
			event: 'C',
			gubun: 'B',
			idx: idx
		},
	})
	.done(function(rtxt){
		var jarr = JSON.parse(rtxt);
	});
}

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
function isPassword(pw)
{
	var reg = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,}$/;
	return reg.test(pw);
}
