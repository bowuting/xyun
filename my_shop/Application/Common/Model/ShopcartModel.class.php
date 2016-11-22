<?php
namespace Common\Model;
use Think\Model;
class ShopcartModel extends Model
{

    //判断某个商品是否被某个人加入购物车
    public function isInShopcart($uid, $goodsid)
    {

        $m = M('shopcart');
        $con['mycart_uid'] = $uid;
        $con['mycart_goodsid'] = $goodsid;

        $result = $m->where($con)->find();

        if ($result) {
            return 1;
        } else {
            return 0;
        }

    }


    public function createShopcart($uid, $goodsid, $num)
    {

        $m = M('shopcart');
        $con['mycart_uid'] = $uid;
        $con['mycart_goodsid'] = $goodsid;
        $con['mycart_quantity'] = $num;
        $con['mycart_createtime'] = time();

        return $result = $m->add($con);

    }


    public function updateShopcart($uid, $goodsid, $inc,$qqq)
    {

        $m = M('shopcart');
        $con['mycart_uid'] = $uid;
        $con['mycart_goodsid'] = $goodsid;
        if ($qqq == "1") {
          return $result = $m->where($con)->setInc('mycart_quantity', $inc);
        }

        return $result = $m->where($con)->setField('mycart_quantity', $inc);

    }

    public function getShopcartUidAndGid($uid,$gid){
      $m = M('shopcart');
      $con['mycart_uid'] = $uid;
      if (is_array($gid)) {
        $con['mycart_goodsid'] =  array('in',$gid);
      } else {
        $con['mycart_goodsid'] = $gid;
      }

      return $result=$m->where($con)
          ->join("LEFT JOIN x_goods ON x_goods.goods_id=x_shopcart.mycart_goodsid")
          ->select();
    }

    public function getShopcart($uid)
    {

        $m = M('shopcart');
        $con['mycart_uid'] = $uid;


        return $result=$m->where($con)
            ->join("LEFT JOIN x_goods ON x_goods.goods_id=x_shopcart.mycart_goodsid")
            ->select();

    }


}
