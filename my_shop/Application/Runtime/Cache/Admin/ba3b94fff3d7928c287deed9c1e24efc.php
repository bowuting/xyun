<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>添加商品</title>
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
        <form action="/xyun/my_shop/index.php/Admin/Goods/updateGoods" method="post" enctype="multipart/form-data">
          <input type="heddin" name="id" value="<?php echo ($goodsOne["goods_id"]); ?>">
        <table class="table table-bordered">
            <tr>
                <td>
                    所属分类
                </td>
                <td>
                    <select name="cid" data-default="<?php echo ($goodsOne["goods_cid"]); ?>">
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["goodscat_id"]); ?>"  >
                                <?php if($vo["lev"] == 1): ?>|--<?php echo ($vo["goodscat_name"]); ?>
                                    <?php elseif($vo["lev"] == 2): ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp; |--<?php echo ($vo["goodscat_name"]); endif; ?>
                            </option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    商品名字
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo ($goodsOne["goods_name"]); ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    商品价格
                </td>
                <td>
                    <input type="text" name="price" value="<?php echo ($goodsOne['goods_price'] / 100); ?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    商品图片
                </td>
                <td>
                  原来的图片
                  <img width="100px" height="100px" src="<?php echo ($goodsOne["goods_pic"]); ?>" alt="" />
                    <input type="file" name="pic"/>
                </td>
            </tr>

            <tr>
                <td>
                    商品描述
                </td>
                <td>
                  <textarea id="desc" name="desc" rows="20">
                      <p><?php echo ($goodsOne["goods_desc"]); ?></p>
                  </textarea>
                    <!-- <script id="container" name="desc" type="text/plain" style="width:100%;height:350px" ></script> -->
              </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit"/>
                </td>
            </tr>
        </table>
    </form>


    </body>
    
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>

<!-- layer js -->
<script src="//cdn.bootcss.com/layer/2.4/layer.js"></script>

<!-- wangEditor js -->
<script src="//cdnsh.bowuting.com/cdn/wangEditor/dist/js/wangEditor.min.js"></script>


    <!-- <script type="text/javascript" src="/xyun/my_shop/Public/wangEditor/dist/js/wangEditor.min.js"></script> -->
    <script type="text/javascript">
        var editor = new wangEditor('desc');
        editor.create();

        $("select").each(function(index, element) {
            // console.log($(this).attr('default'));
            // console.log("option[value='"+$(this).attr('default')+"']");
            $(element).find("option[value='"+$(this).attr('data-default')+"']").attr('selected','selected');
        });

    </script>
</script>
</html>