<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商品展示</title>
        <meta charset="utf-8">
<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- <meta http-equiv="Access-Control-Allow-Origin" content="*"> -->
<!-- Bootstrap -->

<!-- bootstrap css -->
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- layer css -->
<link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet">

<!-- wangEditor css -->
<link rel="stylesheet" href="//cdnsh.bowuting.com/cdn/wangEditor/dist/css/wangEditor.min.css" rel="stylesheet">

    </head>
    <body>
        
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <!-- <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/github/my_shop/index.php/home/">首页</a>
        </div> -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/github/my_shop/index.php/home/">首页</a></li>
                <li><a href="/github/my_shop/index.php/Admin/">分类管理</a></li>
                <li><a href="/github/my_shop/index.php/Admin/Goods">商品管理</a></li>
                <li><a href="#">用户管理</a></li>
                <li><a href="/github/my_shop/index.php/Home/Index/gallery">画廊</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


        <div class="container">
        <button type="button" class=" btn btn-primary create_btn"><i class="glyphicon glyphicon-plus"> 新增 </i></button>

        <hr>
        <table class="table  table-bordered table-hover table-striped ">
            <tr>

                <td>商品名称</td>
                <td>商品价格</td>
                <td>创建时间</td>
                <td>图片</td>
                <td colspan="2">操作</td>
            </tr>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>

                    <td>
                        <?php echo ($vo["goods_name"]); ?>
                    </td>
                    <td>
                        <?php echo ($vo['goods_price']/100); ?>元
                    </td>
                    <td>
                        <?php echo (date("Y-m-d",$vo["goods_createtime"])); ?>
                    </td>
                    <td>
                        <img width="100px" height="100px"src="<?php echo ($vo["goods_pic"]); ?>" alt="" />

                    </td>
                    <td>
                        <button type="button" class="btn btn-primary update_btn"  data-id="<?php echo ($vo["goods_id"]); ?>" ><i class="glyphicon glyphicon-pencil"> 编辑 </i></button>
                        <!-- 因为有很多个按钮  所以   按钮选择 不能用id  要用class -->
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger delete_btn"  data-id="<?php echo ($vo["goods_id"]); ?>" ><i class="glyphicon glyphicon-remove"> 删除 </i></button>
                        <!-- <a class="btn btn-danger" href="/github/my_shop/index.php/Admin/Goods/deleteGoodsCat/id/<?php echo ($vo["goodscat_id"]); ?>"><i class="glyphicon glyphicon-remove"> 删除</i></a> -->
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
    </body>
    
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>

<!-- layer js -->
<script src="//cdn.bootcss.com/layer/2.4/layer.js"></script>

<!-- wangEditor js -->
<script src="//cdnsh.bowuting.com/cdn/wangEditor/dist/js/wangEditor.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.create_btn').click(function(){
                layer.open({                              // 添加  打开弹窗
                  type: 2,
                  skin: 'layui-layer-rim',
                  title:'新增商品',
                  area: ['800px', '600px'],
                  // shadeClose: true, //点击遮罩关闭
                  content: '/github/my_shop/index.php/Admin/Goods/createGoods',
                  closeBtn: 2,
                shift: 0,
                maxmin: true,
                moveType: 0,
                  //content: '/github/my_shop/index.php/Admin/index/createGoodsCat',
                cancel:function() {
                    location.reload();
                  }
                });
            });

            $('.update_btn').click(function(){
              var id = $(this).attr('data-id');
                layer.open({                              // 更新  打开弹窗
                  type: 2,
                  skin: 'layui-layer-rim',
                  title:'更改商品',
                  area: ['800px', '600px'],
                  // shadeClose: true, //点击遮罩关闭
                  content: '/github/my_shop/index.php/Admin/Goods/updateGoods?id=' + id,
                  closeBtn: 2,
                shift: 0,
                maxmin: true,
                moveType: 0,
                  //content: '/github/my_shop/index.php/Admin/index/createGoodsCat',
                cancel:function() {
                    location.reload();
                  }
                });
            });





        });  // ready(function(){ 结束


    </script>
</html>