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

      public function order(){
        dump(I('post.'));
        exit;
        $gid = I('post.ch');
        $uid = session('uid');
        $shopcart = D('Shopcart');
        $res = $shopcart->getShopcartUidAndGid($uid,$gid);
        // dump($res);
        // dump($uid);
        // dump($gid);
        $this->assign('res',$res);

        $addr =  M('addr');
        $con['addr_uid'] = $uid;
        $addrs = $addr->where($con)->select();
        $this->assign('addrs',$addrs);

        $str=implode('..',$gid);
        $this->assign('str',$str);

        // echo sizeof($res);
        for ($i=0; $i < sizeof($res); $i++) {
          $price +=  $res[$i]['mycart_quantity'] * $res[$i]['goods_price'];
          // echo $res[$i]['mycart_quantity'];
          // echo $res[$i]['goods_price'];
          // echo $price;
        }
        // dump($price);

        $this->assign('price',$price);

        $this->display();
        // dump(I('post.'));

      }

      public function orderProcess()
      {
        $uid = session('uid');
        if(!empty($uid)){

          // dump(I('post.'));
          // exit;

          // 订单总表
          $order = D('Order');
          $order->startTrans();
          if (!$order->create($_POST,1)) {
              $this->error($order->getError());
          } else {
              $orderid = $order->add();
              // if ($orderid > 0) {
              //   echo "nice";
              //     //$this->success('提交成功','pay');
              // } else {
              //   echo "no";
              //     // $this->error('新增失败');
              // }
          }
          //
          // exit;

        $gidstr = I('post.gidstr');
        //
        //
        // $addr_id = I('post.addr_id');      // 收获地址id
        //             //用户id
        // $array=explode(separator,$string);
        $gidsArr = explode('..',$gidstr);   //goods id  数组形式
        // dump($uid);
        // dump($gidsArr);
        $shopcart = D('Shopcart');
        $res = $shopcart->getShopcartUidAndGid($uid,$gidsArr);
        dump($res);
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
            $order_detail->rollback();
          }
        }


        $r3 = $shopcart->deleteShopcart($uid,$gidsArr);
        if ($r3 > 0  AND $orderid > 0) {
          $order->commit();
          echo "删除成功";
        } else {
          $order->rollback();
          echo "失败";
        }

        // exit;
        // dump($addr_id);
        exit;


          // exit;


      } else {
        $this->error('您还没有登录','http://localhost/xyun/my_shop/index.php/Login/Index/signin');
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
