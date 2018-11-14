var Index = (function () {
	var Index = {};
	
	Index.showCurrentBannerTitle = function(bannerIndex){
		var titles = $("#circle_btns").find(".js-go-banner");
		titles.removeClass("cur");
		titles.eq(bannerIndex).addClass("cur");
	};
	
	Index.init = function(){
		this.initFlash();
		$("#appHeader").css('backgroundColor', '#1f2831');
		$(window).bind("scroll", function(){
			var scrollH = $(window).scrollTop();
			var ftBanner = $(".ft_banner");
			var h = ftBanner.height();
			var top = ftBanner.offset().top;
			if(scrollH > top){
				$("#appHeader").css('backgroundColor', '#1f2831');
			}else{
				$("#appHeader").css('backgroundColor', '#1f2831');
			}
			Index.initNumGrowUp();
		});
		
		$("body").delegate(".js-close-index-tip", "click", function(){
			Index.closeIndexTip();
		});
		
		Index.closeIndexTip = function(){
			var target = $("#indexTipContent");
			target.hide();
			target = null;
		};
		
		Index.autoCloseIndexTip = function(){
			setTimeout(function(){
				Index.closeIndexTip();
			}, 5 * 1000);
		};
		
		Index.initNumGrowUp();
	};
	
	var _imgFlash = function(img){
		var w = img.attr("data-width");
		img.width(w);
		img.animate({width: 14,padding: (w-14)/2}, 2200, function(){
			img.css('padding', 0);
			_imgFlash($(this));
		})
	};
		
	var _createTimer = function(tarNum, delay, callback){
		var index = 0;
		var timer = setInterval( function(){
			if(index >= tarNum){
				clearInterval(timer);
			}
			callback && callback(index);
			index ++;
		}, delay);
		return timer;
	};
	
	var _hasNumGrowUpInited = false;
	Index.initNumGrowUp = function(){
		if(_hasNumGrowUpInited === true){
			return ;
		}
		var content = $(".js-index-data");
		var scrollH = $(window).scrollTop();
		var winHeight= $(window).outerHeight();
		var contentTop = (content.offset() || {} ).top;
		if(scrollH + winHeight> contentTop){
			_hasNumGrowUpInited = true;
		}else{
			return ;
		}
		
		var allTime = 1000;
		var items = $(".js-num-grow-up");
		for(var i =0, j = items.length; i < j; i++){
			var item = $(items[i]);
			var tarNum = item.attr("data-target");
			tarNum = +tarNum || 0;
			var delay = allTime / tarNum;
			(function(item, delay){
				var timer = _createTimer(tarNum, delay, function(index){
					item.text(index);
				});
			})(item, delay);
		}
	};
	
	//初始化产品闪动
	Index.initFlash = function(){
		var shakeImgs = $(".js-flash-img");
		for(var i = 0, j = shakeImgs.length; i < j; i++){
			var img = $(shakeImgs[i]);
			var delay = img.attr("data-delay");
			delay = +delay || 0;
			(function (img) {
				setTimeout(function(){
					img.show();
					_imgFlash(img);
					img.parents(".js-point-msg").fadeIn();
				}, delay);
			})(img)
		}
	};
	
	Index.proMouseover = function() {
		$("body").on('mouseover', '.js-pro-list', function(event) {
			event.preventDefault();
			var sibTar = $(this).siblings('li');
			sibTar.each(function() {
				$(this).removeClass('active').find('.on').hide().siblings('.off').show();
			});
			$(this).addClass('active').find('.on').show().siblings('.off').hide();
		});
	}
	
	return Index;
})();

$(function(){
	Index.init();
	Index.autoCloseIndexTip();
	Index.proMouseover();
	$(".flexslider").flexslider({
		//slideshowSpeed: 3000,
		directionNav: false,
	});
	var reg = new RegExp("(^|&)code=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) {
		addcookie("inviteCode",unescape(r[2]));
	}
});
