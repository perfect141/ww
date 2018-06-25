$(function () {
    //点击登录按钮进行登录
    $("#btn-login").on("click",function () {
        //收集用户的邮箱和密码，发送给后端进行登录验证
        var userData = $("#login-wrap").serialize();
        //发送到服务端 -- 真正在开发过程中，也不会用http的post请求进行登录，即使是post请求，也是明文传输
        $.post("../php/login/login.php",userData,function (res) {
            // console.log(res);
            //根据res对登录的结果进行验证
            if(res.code == 100){
                //如果登录成功，把用户id存储到cookie里面，将来获取的时候就可以通过cookie获取
                $.cookie("user_id",res.user_id);
                //如果不提示，就直接跳转
                location.href = "../index.html";
             }else{
                //提示用户，以一个隐藏的div让其显示的方式提示
                $(".alert").show();
            }
        },"json");


        /**
         *  http协议是一种明文协议
         *      在传输数据的过程中，传输的数据是没有加密的，如果有人想看，是能看到的
         *
         *
         *      所以真正的登录不应该用http协议来传输数据
         *
         *      而是会选择一种：  https
         *      但是https是一种需要花钱的协议
         *
         *
         */
    });
});
