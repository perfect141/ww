/**
 *  common.js
 *      作用是： 封装一些公用的方法
 *
 */
function autoWidth(){
          if ($(window).height() < $("body").height()) {
            // console.log($(window).height(),$("body").height());
            $("body").css('margin-right', 0);
        } else {
            $("body").css('margin-right', 17);
        }
  $(window).resize(function() {
        console.log(12334)
        if ($(window).height() < $("body").height()) {
            // console.log($(window).height(),$("body").height());
            $("body").css('margin-right', 0);
        } else {
            $("body").css('margin-right', 17);
        }
    })
}

function  checkLogin(deep) {
    var url = "php/login/checklogin.php";
    var loginPage = "pages/login.html";
    if(deep){
        url = "../" + url;
        loginPage = "../" + loginPage;
    }
//验证登录
    //访问服务端的一个接口，可以提供验证登录的服务
    $.post(url,function (res) {
        // console.log(res);
        //如果没有登录过，应该跳转到带登录页面
        if(res.code == 200){
            //跳转到登录也
            location.href = loginPage;
        }
    },"json");
}

/**
 * 尽可能不要在公用js里面调用方法，除非就是真的所有的页面都要执行这个逻辑
 *
 * js中的相对路径，是从引用其的页面文件开始算起的，建议大家把相对路径写准确
 *
 *
 */
// checkLogin();