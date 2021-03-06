/****************************************************************
 *																*		
 * 						      代码库							*
 *                        www.dmaku.com							*
 *       		  努力创建完善、持续更新插件以及模板			*
 * 																*
****************************************************************/
;(function (factory) {
    window.msw = typeof window.msw !== "undefined" ? window.msw : {};
    factory(window.msw, window, document);
}(function (msw, win, doc, undefined) {
    var designWidth = 640;
    var rate = 1;
    var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in win ? 'orientationchange' : 'resize';
    msw.util = typeof msw.util !== "undefined" ? msw.util : {};
    var isPC = msw.util.isPC = function () {
        //平台、设备和操作系统
        var system = {
            win: false,
            mac: false,
            xll: false
        };
        //检测平台
        var p = navigator.platform;
        system.win = p.indexOf("Win") == 0;
        system.mac = p.indexOf("Mac") == 0;
        system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
        if (system.win || system.mac || system.xll) {
            return true;
        } else {
            return false;
        }
    };
    var initRem = msw.util.initRem = function () {
        var clientWidth = docEl.clientWidth;
        if (!clientWidth) return;
        if (clientWidth > designWidth && isPC()) {
            clientWidth = designWidth;
        }
        rate = clientWidth / designWidth * 100;
        docEl.style.fontSize = rate + 'px';
    };
    var init1px = msw.util.init1px = function () {
        if (isPC()) return;
        if (win.devicePixelRatio && devicePixelRatio > 1) {
            var testEle = doc.createElement('div');
            testEle.style.border = '.5px solid transparent';
            doc.body.appendChild(testEle);
            if (testEle.offsetHeight == 1) {
                doc.querySelector('html').classList.add('hairlines');
            }
            doc.body.removeChild(testEle);
        }
    };
    var init = function () {
        if (!doc.addEventListener) return;
        doc.addEventListener('DOMContentLoaded', function () {
            initRem();
            init1px();
            win.addEventListener(resizeEvt, initRem, false);
        }, false);
        initRem();
        init1px();
    };
    init();
    msw.util.rate = rate;
    msw.util.designWidth = designWidth;
}));