$(document).ready(function() {
    var a = document.body;
    var e = document.documentElement;
    $(window).unbind("scroll").scroll(function () {
        a.style.backgroundPosition = "0px " + (Math.max(e.scrollTop, a.scrollTop) / 4) + "px";
    });
});
