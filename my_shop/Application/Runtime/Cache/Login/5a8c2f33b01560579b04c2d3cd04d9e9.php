<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="cn">

    <meta charset="UTF-8">


<link href="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">
<!-- <link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet"> -->


<link rel="stylesheet"	href="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.css">


</head>
<body>


<div class="ui container">

    <br>
<div class="ui menu">
    <a class="item" href="/github/my_shop/index.php/Home/">
        首页
    </a>
    <a class="item" href="/github/my_shop/index.php/admin/">
        后台
    </a>
    <a class="item" href="/github/my_shop/index.php/Home/Index/gallery">
        商品列表
    </a>
    <?php
 if(empty($_SESSION['uid'])){ ?>
        <a class="item" href="/github/my_shop/index.php/Login/Index/registerFirst">
            注册
        </a>
        <a class="item" href="/github/my_shop/index.php/Login/Index/signin">
            登录
        </a>

    <?php  } else { ?>

      <a class="item" href="/github/my_shop/index.php/Login/Index/signout">
          登出
      </a>
    <?php  } ?>

    <a  class="item" href="/github/my_shop/index.php/Login/Index/shopcart">我的购物车</a>

    <!-- <form class="item" action="/github/my_shop/index.php/Home/Index/gallery" method="get">
      <div class="ui input">
          <input id="search" type="text"  name="keyword" placeholder="Search...">
          <button id="searchbtn" type="submit" class="ui basic button">商品搜索</button>
      </div>
    </form> -->
    <div class="ui input">
      <input id="search" type="text"  name="keyword" placeholder="Search...">
      <a id="searchbtn" href="javascript:void(0)" class="ui basic button">搜索</a>
    </div>
</div>

    <div class="ui grid">
        <div class="sixteenth wide column">
            <form class="" action="/github/my_shop/index.php/Login/Index/register" method="post">
              <table class="ui table">
                <tr>
                  <td>
                      手机号码：
                  </td>
                  <td>
                    <div id="phone"  class="ui input">

                        <input type="text" name="phone"  disabled="disabled" value="<?php echo ($data["phone"]); ?>">
                        <input type="hidden" name="phone_last" value="<?php echo ($data["phone"]); ?>">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="ui input">
                      <button type="button" id="send_button">发送短信验证码</button>
                    </div>
                  </td>
                  <td>
                    <div class="ui input">
                        <input type="text" name="smscode" placeholder="验证码"
                        data-rule="验证码: required; remote[post:/github/my_shop/index.php/Login/Index/ajaxCheckSmsVerity, smscode, phone];">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    密码：
                  </td>
                  <td>
                    <div id="" class="ui input">

                        <input type="password" name="passwd"
                        data-rule="密码: required; ">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                      确认密码：
                  </td>
                  <td>
                    <div id="" class="ui input">
                        <input type="password" name="reppasswd"
                        data-rule="确认密码: required; match[passwd];">
                    </div>
                  </td>
                </tr>
              </table>

                <input class="ui primary button" type="submit"  value="提交">
            </form>
        </div>

    </div>

</div>

</body>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script src="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>


<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.js"></script>
<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/local/zh-CN.js"></script>

<script type="text/javascript">

$(document).ready(function(){
    // layer.alert('<?php echo ($_POST['phone']); ?>');


    function jump(wait){
      window.setTimeout(function(){

                if (wait == 0) {
                    // $('#send_button').css("background","orangered");
                    $('#send_button').text('发送短信验证码');
                    $('#send_button').removeAttr('disabled','disabled');
                    wait = 120;
                } else {
                    // $('#send_button').css("background","grey");
                    $('#send_button').attr('disabled','disabled');
                    $('#send_button').text('重新发送（'+wait+'）');
                    wait--;
                    jump(wait);
                }

            }, 1000);
    }

    $('#send_button').click(function(){
      var phonenum="<?php echo ($_POST['phone']); ?>";

      $.post("/github/my_shop/index.php/Login/Index/sendSms",{phonenum:phonenum},function(data,status){

      //data的返回值就是php的返回值 是开发者决定
      //status 的返回值 代表请求是否成功 success error

      console.log(data);
      console.log(status);

      if (data == 1) {
          layer.alert("发送成功,10分钟有效");
          jump(60);
      } else if (data == 2) {
          layer.alert("黑名单,请联系管理员");
      } else if (data == 3) {
          layer.alert("今天超过5次");
      } else if (data == 0) {
          layer.alert("短信发送失败");
      }

  });

    });

});







</script>

</html>