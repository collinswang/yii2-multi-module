//javascript

var Public = (function ($, win, JSON) {
    var _localStorage = win.localStorage;
    var Public = {};
    //每个页面中滚动时显示的导航条数据
    var _scrollNavMenuDatas = {
        "im":{
            nav_name: "即时通讯（IM）",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
        },
        "conference-call":{
            nav_name: "电话会议",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ]
        },
        "video-conference":{
            nav_name: "视频会议",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                /*{name: "合作客户", id: "customer"},*/
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ]
        },
        "callcenter":{
            nav_name: "呼叫中心",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
//				{name: "开发者资源", id: "source"},
            ]
        },
        "message":{
            nav_name: "短信",//短信验证码
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true
        },
        "message-notice":{
            nav_name: "短信通知",//短信验证码
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
            tryType: "#online"
        },
        "smart-hardware":{
            nav_name: "智能硬件",
            properties:[
                {name: "方案优势", id: "advantage"},
                {name: "应用场景", id: "scene"},
                {name: "方案架构", id: "framework"},
                {name: "合作客户", id: "customer"}
            ]
        },
        "cloud-service":{
            nav_name: "云客服",
            properties:[
                {name: "方案优势", id: "advantage"},
                {name: "应用场景", id: "scene"},
                {name: "方案架构", id: "framework"},
                /*{name: "合作客户", id: "customer"}*/
            ]
        },
        "app-service":{
            nav_name: "APP客服",
            properties:[
                {name: "方案优势", id: "advantage"},
                {name: "应用场景", id: "scene"},
                {name: "方案架构", id: "framework"},
                {name: "合作客户", id: "customer"}
            ]
        },
        "net-voice":{
            nav_name: "互联网语音通话",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
            tryType: "#app"
        },
        "net-video":{
            nav_name: "互联网视频通话",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
            tryType: "#app"
        },
        "voice-code":{
            nav_name: "语音验证码",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
            tryType: "#app"
        },
        "voice-notice":{
            nav_name: "语音通知",
            properties:[
                {name: "产品特性", id: "features"},
                {name: "应用场景", id: "scene"},
                {name: "合作客户", id: "customer"},
                {name: "产品价格", id: "price"},
                {name: "开发者资源", id: "source"},
            ],
            needTryBtn: true,
            tryType: "#app"
        },
    };


    var _scrollMenus ={
        "product" : [
            {
                name: "短信", id: "sms", subMenus: [
                {name: "短信验证", id: "", url: "/sms-code"},
                {name: "会员服务短信", id: "", url: "/sms-market"},
                /*{name: "短信通知", id: "", url: "/sms-notice"}*/
                {name: "短信通知", id: "", url: "/front/v-1.0/views/voice-notice.jsp"}
            ]
            },
            {
                name: "语音", id: "voice", subMenus: [
                {name: "语音验证", id: "", url:"/voice-code"},
//						{name: "互联网语音通话", id: "", url:"/voip"},
                {name: "互联网语音通话", id: "", url:"/front/v-1.0/views/net-voice.jsp"},
                /*{name: "语音通知", id: "", url:"/voice-notice"},*/
                {name: "语音通知", id: "", url:"/front/v-1.0/views/voice-notice.jsp"},

                {name: "呼叫中心", id: "", url: "/callcenter"},
                {name: "电话会议", id: "", url: "/conference-call"}
            ]
            },
            {
                name: "IM", id: "im", subMenus: [
                {name: "即时通讯(IM)", id: "", url: "/im"},
            ]
            },
            {
                name: "视频", id: "audio", subMenus: [
                /*{name: "互联网视频通话", id: "", url:"/p2p-video"},*/
                {name: "互联网视频通话", id: "", url:"/front/v-1.0/views/net-video.jsp"},
                {name: "视频会议", id: "", url: "/video-conference"},
            ]
            },
            {
                name: "增值服务", id: "service", subMenus: [
                {name: "流量包", id: "", url: "/traffic"},
                /*{name: "通话录音", id: "", url: "/record"},*/
            ]
            }
        ],
        "solution": [
            {name: "智能硬件", id: "smart-hadrware", url: "/smart-hardware"},
            {name: "APP客服", id: "app-service", url: "/app-service"},
            {name: "云客服", id: "cloud-service", url: "/cloud-service"},
        ]

    };

    Public.keyCodes = {
        enter: 13
    };

    Public.clearInput = function(content){
        var inputs = content.find("[name]");
        inputs.val("");
        inputs.text("");
    };


    Public.fetch = function(url, data, type, success, error, dataType, async){
        type = type || "post";
        dataType = dataType || "json";
        if(typeof(async) === "undefined"){
            async = true;
        }
        $.ajax({
            type:type,
            url: url,
            async:async,
            dataType: dataType,
            data: data,
            success: function(ret){
                success && success(ret);
            }
        });
    };
    //点击的时候显示或隐藏相应区域
    Public.showOrHiden = function(){
        $("body").delegate(".js-show-or-hiden", "click", function(){
            var sibTarget = $(this).siblings(".js-show-or-hiden");
            sibTarget.each(function(){
                var t = $(this).attr("data-target");
                var st = $("#" + t);
                st.hide();
            });
            sibTarget.removeClass("active");
            var target = $(this).attr("data-target");
            var tt = $("#" + target);
            tt.show();
            $(this).addClass("active");
        });
    };


    //点击的时候某一个区域
    Public.closeTarget = function(){
        $("body").delegate(".js-close-target", "click", function(){
            var target = $(this).attr("data-target");
            var tt = $("#" + target);
            tt.hide();
        });
    };

    Public.validateTypes =
        {
            phone1: {errorMsg: "请输入11位手机号码", type:"phone"},
            phone2: {errorMsg: "请输入11位手机号码", type:"phone"},
            phone: {errorMsg: "请输入11位手机号码", type:"phone"},
            imgCode: {errorMsg: "请填写图片验证码", type: "not null"},
            checkType: {errorMsg: "请选择验证方式"},
            msgCode: {errorMsg: "请填写验证码"},
            noticeValue: {errorMsg: "请填写通知内容"},
            userName: {errorMsg: "请填写正确的手机号码或邮箱", type: "phone or email"},
            password:{errorMsg: "请填写密码", type: "not null"},
        };
    Public.validateItem = function(content, imgValidateName){
        var item = Public.validateTypes[imgValidateName];
        var input = content.find("[name='" + imgValidateName + "']");
        var inputValue = input.val();

        var type = item.type || "not null";
        var tipText = content.find('[data-msg-tip="'+imgValidateName+'"]');
        if(type === "not null"){
            if(!Public.isValidValue(inputValue)){
                var msg = item.errorMsg;
                tipText.text(msg).show();
                return {
                    ret: false,

                };
            }else{
                content.find('[data-msg-tip="'+imgValidateName+'"]').text("").hide();
                return {
                    ret: true,
                    value: inputValue
                };
            }
        }else if(type === "phone"){
            if( !this.isValidPhone(inputValue) ){
                var msg = item.errorMsg;
                tipText.text(msg).show();
                return {
                    ret: false,

                };
            }else{
                tipText.text("").hide();
                return {
                    ret: true,
                    value: inputValue
                };
            }
        }else if(type === "email"){
            if(!this.isValidEmail(inputValue)){
                var msg = item.errorMsg;
                tipText.text(msg).show();
                return {
                    ret: false,
                };
            }else{
                tipText.text("").hide();
                return {
                    ret: true,
                    value: inputValue
                };
            }
        }else if(type === "phone or email"){
            if(!this.isValidPhone(inputValue) && !this.isValidEmail(inputValue)){
                var msg = item.errorMsg;
                tipText.text(msg).show();
                return {
                    ret: false,
                };
            }else{
                tipText.text("").hide();
                return {
                    ret: true,
                    value: inputValue
                };
            }
        }else if(type === "phone1"){
            if( !this.isValidPhone(inputValue) ){
                var msg = item.errorMsg;
                tipText.text(msg).show();
                return {
                    ret: false,

                };
            }else{
                tipText.text("").hide();
                return {
                    ret: true,
                    value: inputValue
                };
            }
        }
    };

    Public.showTip = function(msg){
        var target = $("#pub_popup_box");
        target.find(".js-pup-content").text(msg);
        var h = target.outerHeight();
        target.css({"margin-top": - h/2});
        target.show();
        setTimeout(function(){
            target.fadeIn();
        }, 2 *1000);
    };



    Public.validate = function(content, validateInfors){
        var paras = {};
        for(var i = 0, j = validateInfors.length; i < j; i++){
            var item = validateInfors[i];
            var ret = this.validateItem(content,item );
            if(ret.ret === false){
                return {
                    ret: false
                };
            }
            paras[item] = ret.value;
        }

        return {
            ret: true,
            paras: paras
        };
    };

    Public.initCheckBox = function(){
        $("body").delegate(".js-check-box", "click", function(){
            var hasSelected = $(this).hasClass("selected");
            if(hasSelected){
                $(this).removeClass("selected");
                $(this).removeAttr("data-selected");
            }else{
                $(this).addClass("selected");
                $(this).attr("data-selected", true);
            }
        });
    };


    Public.loadHeaderHtml = function(currentNav){
        var url = "/product/head.html";
//		var url = "/service/head.html";
        var data = {};
        var type = "get";
        var dataType = "html";
        this.fetch(url, data, type, function(ret){
            var appHeader = $("#appHeader1");
            appHeader.html(ret);
            $("[t_nav='" + currentNav + "']").addClass("active");


            Public.setScrollNavInitValue();
            Public.initHeaderNavMenu();
        }, function(){

        }, dataType, false);
    };

    Public.showCurrentBannerTitle = function(bannerIndex){
        var titles = $("#circle_btns").find(".js-go-banner");
        titles.removeClass("cur");
        titles.eq(bannerIndex).addClass("cur");
    };

    Public.initSwiper = function(){
        var bannerPages = $(".swiper-slide").length;//
        try {
            _mySwiper = new Swiper('.swiper-container', {
//		        pagination: '.circle_btns',
                loop: true,
                autoplay: 5000,
                nextButton: '.prev_btn',
                prevButton: '.next_btn',
                paginationClickable: true,
                onSlideChangeEnd:function(swiper){
                    var activeIndex = swiper.activeIndex;
                    if(activeIndex > bannerPages){
                        activeIndex = 1;
                    }
                    activeIndex = activeIndex - 1;
                    if(activeIndex < 0 ){
                        return ;
                    }
                    Public.showCurrentBannerTitle(activeIndex);
                },
                onSlideNextEnd: function(swiper){

                },
                onClickNext: function(index){
                    Public.showCurrentBannerTitle(index);
                },
                onClickPrev: function(index){
                    Public.showCurrentBannerTitle(index);
                },
                onTransitionStart: function(obj){
                }
            });
            $("#banner_list").show();
        } catch (e) {
            // TODO: handle exception
        }

        $(".swiper-container").hover(function(){
            $(".slide_btns").show();
        }, function(){
            $(".slide_btns").hide();
        });

        var target = $(".circle_btns ");
        var width = target.outerWidth();
        target.css({"margin-left": -width / 2});


        //切换banner
        $(".js-go-banner").bind("click", function(){
            var page = $(this).attr("data-page");
            page = +page || 0;
            _mySwiper.swipeTo(page);

            Index.showCurrentBannerTitle(page);
        });

        $("#prev_btn").bind("click", function(){
            _mySwiper.swipePrev();
        });

        $("#next_btn").bind("click", function(){
            var activeIndex = _mySwiper.activeIndex;
            _mySwiper.swipeNext();
        });

        $("body").delegate(".js-close-index-tip", "click", function(){
            Index.closeIndexTip();
        });
    };

    //验证是否为正确的手机号码
    Public.isValidPhone = function(phone){
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if(reg.test(phone)){
            return true;
        }
        return false;
    };

    //验证是否为正确的邮箱
    Public.isValidEmail = function(email){
        var reg = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]{2,30}){1,2}$/;
        if(reg.test(email)){
            return true;
        }
        return false;
    };

    Public.isValidValue = function(value){
        value = $.trim(value);
        if(value.length === 0){
            return false;
        }else{
            return true;
        }
    };
    //首页子菜单的显示
    Public.initHeaderNavMenu = function(){
        var ytx={};
        var navs = $("#appHeader").find("[t_nav]");
        var menuContent =$(".js-header-menu");
        navs.hover(function(){
            var _nav = $(this).attr('t_nav');
            var sibs = $(this).siblings("[t_nav]");
            sibs.each(function(){
                var n = $(this).attr("t_nav");
                $("#" + n).hide().stop(true,true);
            });
            $('#'+_nav).slideDown();
            menuContent.attr("data-header-menu", _nav);
        },function(){
        });

        menuContent.hover(function(){

        }, function(){
            var nav =  menuContent.attr("data-header-menu");
            $("#" + nav).stop(true,true).slideUp(200);
        });

        //悬浮固定导航
        $(".menu_fold").hover(function(){
            $(this).find("ul").show();
            var ul_h = $(this).find("ul").height();
            $(this).height(ul_h+57);
        },function(){
            $(this).find("ul").hide();
            $(this).height(57);
        });

        //悬浮二级菜单显示隐藏
        $(".menu_fold ul li").hover(function(){
            $(this).find(".fold_list").toggle();
        });


        //向下滚动时，滚动到对应模块，固定导航右侧对应的名称高亮
        //检查当前页面显示部分属于哪个菜单
        function checkPageOwerMemu(){
            var scrollH = $(window).scrollTop();
            var propertiers = $("h3[data-nav]");
            for(var i = 0, j = propertiers.length; i < j; i++){
                var pro = $(propertiers[i]);
                var off = pro.offset() || {};
                var top = off.top;
                var id = pro.attr("data-nav");
                var headerHeight = $("#scrollMenusContent").outerHeight();
                if(top - headerHeight -10< scrollH){
                    navon(id);
                }
            }
        };

        function navon(id){
            $('.menu_title>a').removeClass('active');
            $("[data-menu-id='"+id+"']").addClass("active");
        }


        $(".menu_title>a").click(function(){
            var a_index = $(this).index();
            var id = $(this).attr("data-menu-id");

            var headerHeight = $("#scrollMenusContent").outerHeight();
            var target = $("[data-nav='" + id + "']");
            var off = (target.offset() || {} );
            var top = off.top || 0;
            top = top - headerHeight;//减去滚动头部的高度，不然 会被挡住
            navon(id);
            $("html, body").animate({
                scrollTop: top
            }, {
                duration: 500,
                easing: "swing"
            });
            return false;
        });

        function showOrHiderScrollMenu(){
            var currentMenu = $("body[data-current-menu]").attr("data-current-menu");
            var datas = _scrollNavMenuDatas[currentMenu];
            if(!datas){//没有滚动菜单选项显示
                return ;
            }
            var top = $(window).scrollTop();
            if(top>700){
                $(".ft_menu_fixed").show();
            }else{
                $(".ft_menu_fixed").hide();
            }
        };

        function showOrHiderToTop(){
            var top = $(window).scrollTop();
            if(top>1500){
                $(".js-to-top").show();
            }else{
                $(".js-to-top").hide();
            }
        };

        //绑定滚动事件
        $(window).bind('scroll',function(){
            checkPageOwerMemu();
            showOrHiderScrollMenu();
            showOrHiderToTop();
        });


        $(".js-to-top").bind("click", function(){
            $(window).scrollTop( 0);
        });

    };
    //滚动页面的时候显示导航条
    Public.setScrollNavInitValue = function(){
        var currentMenu = $("body[data-current-menu]").attr("data-current-menu");
        var dataNav = $("body[data-nav]").attr("data-nav");;//当前页面所属类别
        var datas = _scrollNavMenuDatas[currentMenu];
        var scrollMenusContent = $("#scrollMenusContent");
        if(!datas){
            scrollMenusContent.hide();
            return ;
        }else{
            datas.scrollMenus = _scrollMenus[dataNav];
            var html = template("scrollMenusTempl", datas);
            scrollMenusContent.html(html);
        }
    };


    Public.initSolutionsImages = function(){
        var slides = $(".js-item-slide");
        for(var i = 0, j = slides.length; i < j; i++){
            var directionNav = true;//是否显示左右移动按钮
            var slide = $(slides[i]);
            var items = slide.find(".flexslider .slides li");
            if(items.length <= 6){//每行显示4个，若小于四个则隐藏左右移动按钮
                directionNav = false;
            }
            var itemWidth = +slide.attr("data-item-width") || 246;
            var itemMargin = +slide.attr("data-item-margin") || 54;
            //方案优势左右滚动切换
            slide.flexslider({
                animation: "slide",
                slideshow: false,
                animationLoop: false,
                itemWidth: itemWidth,
                itemMargin: itemMargin,
                minItems: 0,
                maxItems: 0,
                move:0,
                directionNav: false,
                controlNav: false,               //是否显示控制菜单
                // pausePlay: true
            });
        }

        // slides.hover(function(){
        //     $(this).find(".flex-next").css("opacity", 1);
        //     $(this).find(".flex-prev").css("opacity", 1);
        // }, function(){
        //     $(this).find(".flex-next").css("opacity", 0);
        //     $(this).find(".flex-prev").css("opacity", 0);
        // });

        //方案优势每项鼠标放上上移效果
        $(".js-item-slide ul.slides li").hover(function(){
            $(this).animate({
                top : "-=12"
            });
        },function(){
            $(this).animate({
                top : "+=12"
            });
        });

    };

    Public.focusFormRow = function(){
        $(".js-form input, .js-form textarea").bind("focus", function(){
            $(this).parents(".controls").addClass("focus");
        });
        $(".js-form input, .js-form textarea").bind("blur", function(){
            $(this).parents(".controls").removeClass("focus");
        });
    };

    //初始化 语音录音页面
    Public.initRecode = function(){
        //语音通知手风琴效果
        $(".voice_2 ul li.li5").css("width","1080px");
        $(".voice_2 ul li.li5").find(".unfold").show();
        $(".voice_2 ul li.li5").find(".fold").hide();
        $(".voice_2 ul li").each(function(){
            var fold = $(this).find(".fold");
            var unfold = $(this).find(".unfold");
            if(fold.is(":hidden")){
                $(this).width(1080);
            }else{
                $(this).width(100);
            }
        })

        $(".voice_2 ul li").click(function(){
            var li_index = $(this).index();
            $(this).animate({width:1080},200);
            $(this).find(".unfold").show();
            $(this).find(".fold").hide();
            $(this).siblings().animate({width:100},200);
            $(this).siblings().find(".unfold").hide();
            $(this).siblings().find(".fold").show();
        });
    };

    Public.init = function(){
        $("body").delegate(".js-load-code", "click", function(){
            var targetId = $(this).attr("data-target");
            var targetImg = $("#" + targetId);
            var oldSrc = targetImg.attr("src");
            var str = "noCache=" +new Date().getTime();
            if(oldSrc.indexOf("?") === -1){
                var newSrc = oldSrc + "?"+str;
            }else{
                if(oldSrc.indexOf("&") === -1){
                    var newSrc = oldSrc + "&" + str;
                }else{
                    var newSrc = oldSrc.substring(0,oldSrc.indexOf("&")) + "&" + str;
                }
            }



//			var newSrc = oldSrc.indexOf("?") === -1 ? (oldSrc + "?"+str) : (oldSrc + "&" + str);
            targetImg.attr("src", newSrc);
        });

        //点击在线体验
        $("body").delegate(".js-qq-link", "click", function(){//
            var frame = $(".js-qq-link1 iframe");
            var launchBtn = frame[0].contentDocument.getElementById("launchBtn");
            launchBtn.click();
//			var btn = $("#BizQQWPA");
//			btn.click();
        });

        //底部在线qq咨询处理
        var timer = setInterval(function(){
            var frame = $(".js-qq-link1 iframe");
            if(frame.length > 0){
                frame.css("margin-left", "-100000px").css("position", "absolute");
                clearInterval(timer);
            }

        }, 10);


        this.initCheckBox();
    };

    Public.localMsgNames ={
        userName: "userName"
    };

    Public.addMsgToLocal = function(name, value){
        if(typeof(value) === "object"){
            value = JSON.stringify(value);
        }
        if(_localStorage){
            _localStorage.setItem(name, value);
        }
    };

    Public.getMsgFromLocal = function(name){
        if(!_localStorage){
            return "";
        }else{
            return _localStorage.getItem(name);
        }
    };

    Public.removeMsgFromLocal = function(name){
        if(!_localStorage){
            return "";
        }else{
            _localStorage.removeItem(name);
        }
    };

    Public.initInputWraper = function(){
        $("body").delegate(".js-input-wraper input", "focus", function(){
            $(this).parents(".js-input-wraper").addClass("focus");
        });
        $("body").delegate(".js-input-wraper input", "blur", function(){
            $(this).parents(".js-input-wraper").removeClass("focus");
        });
    };

    Public.getUrlParas = function(name){
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null){
            return  r[2];//unescape(r[2]);
        }else{
            return null;
        }
    };
    //初始化回车事件
    Public.initEnterKeyEvent = function(){
        $("body").delegate(".js-trigger-by-enter", "keyup", function(e){
            var triggerTarget = $(this).attr("data-trigger-target");
            var keyCode = e.keyCode;
            if(keyCode === Public.keyCodes.enter){
                $(triggerTarget).click();
            }
        });
    };

    Public.isLogin = function(){
        var url = "isLogin";
        var data = {};
        $.ajax({
            type: "post",
            url: url,
            data: data,
            dataType: "json",
            success: function(data){
                if(data == '1'){
                    $(".ft_header_nologin").hide();
                    $(".ft_header_islogin").show();
                }else{
                    $(".ft_header_nologin").show();
                    $(".ft_header_islogin").hide();
                }
            }
        });
    };

    return Public;
})($, window, JSON);


$(function(){

    var currentNav = $("body").attr("data-nav");//当前页面所属导航

    var currentNav = $("body").attr("data-nav");//当前页面所属导航
    $("[t_nav='" + currentNav + "']").addClass("active");
    Public.setScrollNavInitValue();
//    Public.initHeaderNavMenu();
    //初始化解决方案图标
//    Public.initSolutionsImages();

 //   Public.initRecode();

 //   Public.showOrHiden();

 //   Public.focusFormRow();
    Public.initSwiper();

 //   Public.closeTarget();
 //   Public.initInputWraper();
 //   Public.init();
  //  Public.initEnterKeyEvent();
  //  Public.isLogin();

});
