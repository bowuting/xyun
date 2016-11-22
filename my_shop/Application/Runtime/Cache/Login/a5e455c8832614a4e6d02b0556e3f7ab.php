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
    <a class="item" href="/xyun/my_shop/index.php/Home/">
        首页
    </a>
    <a class="item" href="/xyun/my_shop/index.php/admin/">
        后台
    </a>
    <a class="item" href="/xyun/my_shop/index.php/Home/Index/gallery">
        商品列表
    </a>
    <?php
 if(empty($_SESSION['uid'])){ ?>
      
        <a class="item" href="/xyun/my_shop/index.php/Login/Index/signin">
            登录
        </a>

    <?php  } else { ?>

      <a class="item" href="/xyun/my_shop/index.php/Login/Index/signout">
          登出
      </a>
      <a  class="item" href="/xyun/my_shop/index.php/Login/Index/me">
          个人中心
      </a>
    <?php  } ?>

    <a  class="item" href="/xyun/my_shop/index.php/Home/Index/shopcart">我的购物车</a>

    <!-- <form class="item" action="/xyun/my_shop/index.php/Home/Index/gallery" method="get">
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
        <div class="four wide column">
        </div>

        <div class="eight wide column">
            <div class="" style="height:140px;">

            </div>

            <form class="" action="/xyun/my_shop/index.php/Login/Index/registerSecond" method="post">
                <table class="ui table">
                    <tr>
                        <td>
                            <p class="">
                                手机号码
                            </p>
                        </td>
                        <td>
                            <div class="ui input">
                                <input type="text" name="phone" placeholder="手机号码"
                                data-ok=''
                                data-rule-phone="[/^1[3-9]\d{9}$/, '请输入正确的手机号码']"
                                data-rule="手机号码: required; phone;remote[post:/xyun/my_shop/index.php/Login/Index/ajaxIsThisPhoneRegistered/, phone];">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img id="verify" src="<?php echo U('Login/Index/verify');?>" alt="verify_code"  onclick="fleshVerify()" >
                            点击图片刷新验证码
                        </td>
                        <td>
                            <div class="ui input">
                                <input type="text" name="verify" placeholder="验证码"
                                data-ok=''
                                data-rule="验证码: required; remote[post:/xyun/my_shop/index.php/Login/Index/ajaxCheckVerify/, verify];">
                            </div>
                        </td>
                    </tr>
                </table>
            <input class="ui primary button" type="submit"  value="提交"  >
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
function fleshVerify(){
 var time = new Date().getTime();
    document.getElementById('verify').src= '<?php echo U("Login/Index/verify/' + time + '");?>';
    //其实相当于刷新页面  但是浏览器机制决定URL不一样 才会刷新
}
</script>
</html>