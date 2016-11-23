<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    // 首页
    public function index(){
        $this->display();
    }

    public function gallery(){

      // 得到所有get传值
      $cid = I('get.cid');
      $keyword = I('get.keyword');
      $color = I('get.color');
      $price = I('get.price');
      $price_2 = I('get.price_2');
      $time = I('get.time');

      $GoodsCatModel = D('GoodsCat');
      $result = $GoodsCatModel->getInfiniteGoodsCat();  //得到无限极分类
      $this->assign('list',$result);
        $GoodsModel = D(Goods);

      if ($cid == ""){
          $cid = $GoodsCatModel->getLastChildId($GoodsCatModel->getChildID('0'));  //如果没有cid则说明是取所有的  则得到所有的二级分类
      } else {
          if ($GoodsCatModel->isHaveChild($cid)) {              //如果有cid  则看该cid有没有子类  如果有子类  则得到其所有子类（也就是二级分类）
              $cid = $GoodsCatModel->getChildID($cid);
          }
      }

      $goodsList = $GoodsModel->getGoods('',$cid,$keyword,$color,$price,$price_2,$time);
      $this->assign('goodsList',$goodsList);

      $this->display();

        exit;








        // if (empty(I('get.'))) {
            // $goodsList = $GoodsModel->getGoods(null,null,null,$color);
        // } else {

            if (I('get.cid') === '0') {
              echo "string";
              $cid = $GoodsCatModel->getLastChildId($cid);
              // $goodsList = $GoodsModel->getAllGoods();
            }
            dump($cid);
            // exit;
            // echo $color;
            $goodsList = $GoodsModel->getGoods(null,$cid,$keyword,$color,$price,$price_2,$time);
            // dump($goodsList);
        // }
        // if (empty(I('get.'))) {
        //   $goodsList = $GoodsModel->getAllGoods();
        // }
        $this->assign('goodsList',$goodsList);
        $this->display();
    }

    public function goods(){
        $id = I('get.goods_id');
        $GoodsModel = D(Goods);
        $result = $GoodsModel->getOneGoods($id);
        $this->assign('goodsInfo',$result);
        // dump($result);
        $this->display();
    }
    public function addshopcart(){

        $goodsid = trim(I('param.goodsid'));
        $num = trim(I('param.num'));
        $isgoods = trim(I('param.isgoods'));  //商品是否存在
        $uid = session('uid');
        // $cart_info = $m->where('mycart_goods_id='.$id)->find();
        // dump($cart_info);
        // exit;
        $ShopcartModel = D('Shopcart');
        $res = $ShopcartModel->isInShopcart($uid,$goodsid);

            //
        if ($res === 1) { //如果已经在数据库 则更新
          if ($isgoods) {
            $r = $ShopcartModel->updateShopcart($uid,$goodsid,$num,$isgoods);
          } else {
            $r = $ShopcartModel->updateShopcart($uid,$goodsid,$num,null);
          }

        } else { //如果没有在数据库 则添加
          $r = $ShopcartModel->createShopcart($uid,$goodsid,$num);
        }

        if ($r >0 ) {
          echo "1";
        } else {
          echo '0;';
        }

    }

    public function shopcart(){
      // echo __URL__;
      if (empty(session('uid'))) {
        $this->error('您还没有登录，正在在为您跳转至登录页面！',__APP__.'/Login/Index/signin');
      }
        $ShopcartModel = D('Shopcart');
        $uid = session('uid');
        $res = $ShopcartModel->getShopcart($uid);
        // dump($res);
        $this->assign('list',$res);
        $this->display();
      }


      //订单显示页面 通过uid、gid得到订单各个信息 展示到页面
      public function order(){

        $gids = I('post.check');                         //得到一个商品id的数组
        $uid = session('uid');

        $shopcartModel = D('Shopcart');                  //得到连表查询之后的 商品信息和购物车信息
        $shopcartRes = $shopcartModel->getShopcartFromUidAndGid($uid,$gids);
        $this->assign('res',$shopcartRes);

        for ($i=0; $i < sizeof($shopcartRes); $i++) {    //将购物车的物品个数信息和商品信息  得到  总价格
          $allPrice +=  $shopcartRes[$i]['mycart_quantity'] * $shopcartRes[$i]['goods_price'];
        }
        $this->assign('allPrice',$allPrice);

        $gidsStr = implode('..',$gids);                  // 将gids（数组）转为以 .. 分割开来的字符串
        $this->assign('gidsStr',$gidsStr);

        $addrDB =  M('addr');                             //根据uid查的此人的收货地址信息
        $con['addr_uid'] = $uid;
        $addrs = $addrDB->where($con)->select();
        $this->assign('addrs',$addrs);

        $this->display();
      }


      //订单处理
      public function orderProcess()
      {
            $uid = session('uid');

            if(empty($uid)){
              $this->error('您还没有登录',__APP__.'/Login/Index/signin');
            } else {
                /*
                这是接收到的post数据
                'addr_name' => string ' 丁博武 ' (length=11)
                'addr_phone' => string ' 18883284586' (length=12)
                'addr_content' => string ' 陕西省西安市灞桥区国际港务区' (length=43)
                'gidsStr' => string '8' (length=1)
                'allPrice' => string '488800' (length=6)
                */

              $gidsStr = I('post.gidsStr');
              $gidsArr = explode('..',$gidsStr);   //拆分字符串  成  数组形式   goods id  数组形式

              // 订单总表
              $orderModel = D('Order');
              $orderModel->startTrans();   //开启事务
              if (!$orderModel->create($_POST,1)) {
                  $this->error($orderModel->getError());
              } else {
                  $orderid = $orderModel->add();
                  if (!($orderid > 0)) {
                    $orderModel->rollback();
                    $this->error('请稍后再试！');
                  }
              }

            //  订单子表
            $shopcart = D('Shopcart');
            $res = $shopcart->getShopcartFromUidAndGid($uid,$gidsArr); // 连表查询得到购物车信息和商品信息
            foreach ($res as $k => $v) {
                $data['orderdetail_orderid'] = $orderid;
                $data['orderdetail_goodsid'] = $v['goods_id'];
                $data['orderdetail_goodsname'] = $v['goods_name'];
                $data['orderdetail_goodsprice'] = $v['goods_price'];
                $data['orderdetail_quantity'] = $v['mycart_quantity'];
                $data['orderdetail_goodsdesc'] = $v['goods_desc'];
                $order_detail = M('order_detail');
                $r2 = $order_detail->add($data);
                if (!($r2 > 0)) {
                  $orderModel->rollback();
                }
            }

            //  从购物车删除
            $r3 = $shopcart->deleteShopcart($uid,$gidsArr);


            if ($r3 > 0  AND $orderid > 0) {
              $orderModel->commit();
              $this->success('订单提交成功 正在跳转支付界面','pay',2);
            } else {
              $orderModel->rollback();
              $this->success('订单提交失败 请稍后尝试');
            }
        }
      }

      public function pay(){
        echo "<h2>支付页面</h2>";
      }

      public function test(){
        dump($_SESSION);
        dump(json_decode(session('str'),true));
      }


}
