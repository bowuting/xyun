<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="cn">

    <meta charset="UTF-8">


<link href="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">
<!-- <link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet"> -->


<link rel="stylesheet"	href="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.css">

    <title>订单结算页</title>
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
        <div class="sixteen wide column">


          <h2>订单结算页</h2>

          <form class="" action="/xyun/my_shop/index.php/Home/Index/orderProcess" method="post">


            <?php if(is_array($addrs)): $i = 0; $__LIST__ = $addrs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$addrone): $mod = ($i % 2 );++$i;?><div>
                <span data-addr-id="<?php echo ($addrone["addr_id"]); ?>" data-click="0" class="ppp" style="border:1px solid;width:200px"><?php echo ($addrone["addr_name"]); ?> <?php echo ($addrone["addr_city"]); ?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span> <?php echo ($addrone["addr_phone"]); ?>&nbsp;&nbsp; <?php echo ($addrone["addr_content"]); ?></span>
              </div>
              <br><?php endforeach; endif; else: echo "" ;endif; ?>
            <input id="addrinput" type="hidden" name="addr_id" value="">
            <table class="ui celled table">
              <thead>
                <tr>
                  <th>名称</th>
                  <th>图片</th>
                  <th>单价</th>
                  <th>数量</th>
                </tr>
              </thead>

              <?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="gidstr" value="<?php echo ($str); ?>">
              </tr>
                <tr>
                  <td><?php echo ($vo["goods_name"]); ?></td>
                  <td><img width="50px" height="50px"src="<?php echo ($vo["goods_pic"]); ?>" alt="" /></td>
                    <td><?php echo ($vo[goods_price]/100); ?></td>
                  <td><?php echo ($vo["mycart_quantity"]); ?></td>

                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </table>
              <input type="hidden" name="price" value="<?php echo ($price); ?>">
              <span>总价：<?php echo ($price/100); ?></span>
              <input type="submit" name="" value="结算" id="submit" >

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

function contains(a, obj) {
        for (var i = 0; i < a.length; i++) {
            if (a[i] === obj) {
                return true;
            }
        }
        return false;
    }


  $(document).ready(function(){
    $('.ppp').click(function() {
      // console.log('dadd');
        $('.ppp').css('background-color','white');
        $('.ppp').attr('data-click','0')
      $(this).css('background-color','red');
      $(this).attr('data-click','1')
      var val = $(this).attr('data-addr-id');
      console.log(val);
      $('#addrinput').val(val);
    });

    $('#submit').click(function(){
      var arr = new Array();
      var i = 0;
        $('.ppp').each(function() {
          arr[i] = $(this).attr('data-click');
           i++;
        });
        if (contains(arr,'1')) {

        } else {


          layer.alert('您还没有选择收获地址呢');

          return false;
        }
    });

  });















</script>

</html>