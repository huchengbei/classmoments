<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<title>Welcome to ClsaaMoments</title>
<link rel="icon" href="/classmoments2/Public/logo.png" type="image/png" >
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="/classmoments2/Public/modern/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="/classmoments2/Public/bootstrap/css/bootstrap2.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="/classmoments2/Public/modern/css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="/classmoments2/Public/modern/css/lines.css" rel='stylesheet' type='text/css' />
<link href="/classmoments2/Public/modern/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="/classmoments2/Public/modern/js/jquery.min.js"></script>
<script src="/classmoments2/Public/modern/js/bootstrap.min.js"></script>
<!----webfonts--->
<link href='http://fonts.useso.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->  
<!-- Nav CSS -->
<link href="/classmoments2/Public/modern/css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="/classmoments2/Public/modern/js/metisMenu.min.js"></script>
<script src="/classmoments2/Public/modern/js/custom.js"></script>
<!-- Graph JavaScript -->
<script src="/classmoments2/Public/modern/js/d3.v3.js"></script>
<script src="/classmoments2/Public/modern/js/rickshaw.js"></script>
<script type="text/javascript">
   $(function () { 

        if('<?php echo ($error); ?>'!=''){
            if('<?php echo ($op); ?>'=='login'){
                $('#loginModal').modal();
            }else if('<?php echo ($op); ?>'=='register'){
                $('#registerModal').modal();
            }
        }

        $('#toRegister').click(function(){
            $('#loginModal').modal('hide');
            $('#registerModal').modal();
        });
        $('#toLogin').click(function(){
            $('#registerModal').modal('hide');
            $('#loginModal').modal();
        });
        $('#loginButton').click(function(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            if (username == null || username == "") {
                document.getElementById("error").innerHTML = "用户名不能为空";
                return;
            }
            if (password == null || password == "") {
                document.getElementById("error").innerHTML = "密码不能为空";
                return;
            }
            document.getElementById('form').submit();
        });
        $('#registerButton').click(function(){
            var username = document.getElementById("rusername").value;
            var nikename = document.getElementById("rnikename").value;
            var password = document.getElementById("rpassword").value;
            var password2 = document.getElementById("password2").value;
            if (username == null || username == "") {
                document.getElementById("error2").innerHTML = "用户名不能为空";
                return;
            }
            //alert(1);
            if (nikename == null || nikename == "") {
                document.getElementById("error2").innerHTML = "姓名不能为空";
                return;
            }
            if (password == null || password == "") {
                document.getElementById("error2").innerHTML = "密码不能为空";
                return;
            }
            if (password2 == null || password2 == "") {
                document.getElementById("error2").innerHTML = "密码不能为空";
                return;
            }
            
            if (password!=password2){
                document.getElementById("error2").innerHTML = "两次密码不一样";
                return;
            }
            document.getElementById('form2').submit();
        });
   });
</script>

</script>
<style>
    #page-wrapper{
        margin: -30px auto;
    }
    .characters-wrap{
        position: relative;
        padding: 100px 0px;
        height: 300px;
        font-size:50px; 
        text-align: center;
    }
    .characters-wrap span{
        margin: 0 20px;
    }
    .scrollbar{
        margin: 0 auto;
        height: 500px;
        overflow-y: hidden;
    }
    .copy{
        width: 100%;
        float: bottom;
    }
    #qrcode-font{
        font-size: 10px;
        position: fixed;
        bottom: 100px;
        right: 0px;
    }
    #qrcode{
        font-size: 50px;
        position: fixed;
        bottom: 112px;
        right: 10px;
        margin: 0;
    }
    #qrcode img{
        display: none;
        margin: 0 0 10px 0;
    }
    #qrcode:hover img{
        display: block;
    }
    #qrcode:hover a{
        display: none;
    }
    #logo{
        margin-top: 30px;
        margin-left: 35%;
        width: 10%;
        height: 10%;
    }
    #login{
        margin: 20px 42.5%;
        width: 15%;
        border-radius: 50px;
    }
    .navbar .navbar-nav li a{
        color: #fff;
        line-height: 50px;
    }
    .form-signin-heading{
        text-align: center;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 0px;
        margin: 0 auto 20px;
        background-color: #fff;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
</style>

</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="/classmoments2/index.php/Home/Index/mainStudent" data-toggle="modal" data-target="#myModal"><strong>班 级 圈</strong></a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav navbar-right">
                <a href="#" style="margin-top: 10px;" class="dropdown-toggle avatar btn btn-success btn-warng1" data-toggle="modal" data-target="#registerModal"><span><strong>注册</strong></span></a>
			</ul>
            <!-- /.navbar-static-side -->
        </nav>
        <nav>
        <div id="page-wrapper">
            <img src="/classmoments2/Public/logo.png" id="logo"/>
            <div class="characters-wrap">
                <span class="fa fa-group">专注服务学生</span>
                <span class="fa fa-eye">聚焦班级活动</span>
                <span class="fa fa-edit">辅助课程学习</span>
            </div>
            <button class="btn btn-primary btn-lg" id="login" data-toggle="modal" data-target="#loginModal">
                登&nbsp;录
            </button>

		</div></nav>
</div>
<p id="qrcode-font"><strong>关注微信公众号</strong></p>
<div id="qrcode"><a class="fa fa-qrcode"></a><img src="/classmoments2/Public/QRcode.jpg"></div>
<div class="copy">
    <p> &copy;<a href="http://classmoments.xeqiao.cn/" target="_blank">班级圈</a> -版权所有   2016  萧易桥  易水龙 风萧呆</p>
</div>
        </div>
      <!-- /#page-wrapper -->
        </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog " style="width: 400px;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
            用户登录
            </h4>
         </div>
         <div class="modal-body">
            <form name="myForm" id='form' class="form-signin" action="/classmoments2/index.php/Home/User/login" method="post">
                <h2 class="form-signin-heading"><font color="gray"></font></h2>
                <input id="username" name="username" value="" type="text" class="input-block-level" placeholder="用户名...">
                <input id="password" name="password" value="" type="password" class="input-block-level" placeholder="密码..." >
                <br/>
                <font id="error" color="red"><?php echo ($error); ?></font>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" id='toRegister'>
                注册
            </button>
            <button type="button" class="btn btn-primary" id='loginButton'>
               登录
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog " style="width: 400px;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
            用户登录注 册
            </h4>
         </div>
         <div class="modal-body">
            <form name="myForm" id='form2' class="form-signin" action="/classmoments2/index.php/Home/User/register" method="post" style="margin-left: 10px">
                <input id="rusername" name="username" value="" type="text" class="input-block-level" placeholder="用户名..." style="width: 310px">
                <input id="rnikename" name="nikename" value="" type="text" class="input-block-level" placeholder="姓名..." style="width: 310px">
                <input id="rpassword" name="password" value="" type="password" class="input-block-level" placeholder="密码..." style="width: 310px" >
                <input id="password2" name="password2" value="" type="password" class="input-block-level" placeholder="再输入一次密码..." style="width: 310px" >
               
                 <label class="radio inline">
                    <input id="join" type="radio" name="type" value="join" onclick="joinform.style.display='';foundform.style.display='none';"  checked/> 加入一个班级
                </label>
                <label class="radio inline">
                    <input id="found" type="radio" name="type" value="found" onclick="foundform.style.display='';joinform.style.display='none';"} /> 创建一个班级
                </label>
                <div id='joinform'>
                    <input id="uniqueCode" name="uniqueCode" value="" type="text" class="input-block-level" placeholder="请输入班级惟一代码，可从班长处获取..." style="width: 310px">
                </div>
                <div id='foundform' style="display:none">
                    <input id="grade" name="grade" value="" type="text" class="input-block-level" placeholder="年级" style="width: 310px">
                    <input id="className" name="className" value="" type="text" class="input-block-level" placeholder="班级名称" style="width: 310px">
                </div>
                <br/>
                <font id="error2" color="red"><?php echo ($error); ?></font>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" id='toLogin'>
                返回登录
            </button>
            <button type="button" class="btn btn-primary" id='registerButton'>
               注册
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
</body>
</html>