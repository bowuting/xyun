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
    <a class="item" href="/xyun/my_shop/index.php/Home/Index/myorder">
        我的订单
    </a>
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

          <h2>我的订单</h2>
          <table class="ui celled table">
            <?php if(is_array($orderlist)): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
                <td>
                  下单时间：<?php echo (date("Y-m-d",$order["order_time"])); ?>
                </td>
                <td>
                  订单编号：<?php echo ($order["order_no"]); ?>
                </td>
                <td>
                      <?php if($order["order_ispay"] == 1): ?>已付款
                          <?php else: ?>

                          <button type="button" id="pay_<?php echo ($order["order_id"]); ?>"
                                  class="btn btn-primary btn-sm">立即付款</button><?php endif; ?>
                  </td>
                  <td>
                    订单总价：<?php echo ($order['order_totalprice'] / 100); ?>
                  </td>
                </tr>
                  <?php if(is_array($orderdetail)): $i = 0; $__LIST__ = $orderdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($order['order_id'] == $v['orderdetail_orderid']): ?><tr>
                              <td>
                                  <?php echo ($v["orderdetail_goodsname"]); ?>
                              </td>
                              <td>
                                  <?php echo ($v['orderdetail_goodsprice']/100); ?>
                              </td>
                              <td>
                                  x<?php echo ($v["orderdetail_quantity"]); ?>
                              </td>
                              <td>
                                  <?php echo ($v['orderdetail_goodsprice']*$v['orderdetail_quantity']/100); ?>
                              </td>
                          </tr><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
          </table>



        </div>  <!--end sixteen wide column -->

    </div>  <!--end ui grid -->

  </div> <!--end ui container -->

</body>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script src="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>


<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.js"></script>
<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/local/zh-CN.js"></script>

<script id='spay-script' src='https://jspay.beecloud.cn/1/pay/jsbutton/returnscripts?appId=dcf7509d-e33e-4629-ac84-fba86b6f6225'></script>

<script type="text/javascript">




          <?php if(is_array($orderlist)): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>var ppp = document.getElementById("pay_<?php echo ($vo["order_id"]); ?>");
          if (ppp) {
            ppp.onclick = function() {
                asyncPay_<?php echo ($vo["order_id"]); ?>();
            };
          }
            // document.getElementById("pay_<?php echo ($vo["order_id"]); ?>").

            function bcPay_<?php echo ($vo["order_id"]); ?>() {
                BC.click({
                "title": "商城订单："+"<?php echo ($vo["order_no"]); ?>",
                "amount": "<?php echo ($vo["order_totalprice"]); ?>",
                "out_trade_no": "<?php echo ($vo["order_no"]); ?>",
                "sign" : "<?php echo ($vo["sign"]); ?>",
                "return_url":"http://bowuting.cn/my_shop/index.php/Home/Index/myorder",
                "trace_id" : "<?php echo ($vo["paypeople"]); ?>",
                "debug":false,

            });
          };

            function asyncPay_<?php echo ($vo["order_id"]); ?>() {
                if (typeof BC == "undefined") {
                    if (document.addEventListener) {
                        document.addEventListener('beecloud:onready', bcPay_<?php echo ($vo["order_id"]); ?>, false);
                    } else if (document.attachEvent) {
                        document.attachEvent('beecloud:onready', bcPay_<?php echo ($vo["order_id"]); ?>);
                    }
                } else {
                    bcPay_<?php echo ($vo["order_id"]); ?>();
                }
            }<?php endforeach; endif; else: echo "" ;endif; ?>







</script>

</html>