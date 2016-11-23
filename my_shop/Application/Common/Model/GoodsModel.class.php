<?php


namespace Common\Model;
use Think\Model;
class GoodsModel extends Model{

    //三大自动
    //自动映射   注意:左右两边的表单和数据库字段不能一样
    protected $_map = array(
        //左边的是表单字段 =>右边是数据库字段
        'id' => 'goods_id',
        'cid' => 'goods_cid',
        'name' => 'goods_name',
        'desc' => 'goods_desc',
    );

    //自动完成
    protected $_auto = array(
        //数据库字段名称   函数名称       1 新增  2 修改 3 全部情况    如果是PHP函数=function 自定义为callback
        array('goods_createtime','time',1,'function'),
        array('goods_price','getPrice',3,'callback'),
        array('goods_pic','uploadPic',3,'callback'),
    );

    public function getPrice(){
        $price = trim(I('param.price'));
        return $price*100;
    }

    public function uploadPic(){
        if(!empty($_FILES['pic']['name'])){
            //上传到七牛

            $setting=C('UPLOAD_SITEIMG_QINIU');  //C函数 得到config文件的配置
            $Upload = new \Think\Upload($setting);
            $info = $Upload->upload($_FILES);
            dump($Upload);
            echo $info['pic']['url'];
            return $info['pic']['url'];
        }else{
            //没上传图片
            $id = trim(I('post.id'));
            //有ID就是更新
            if($id){
                $m=M('goods');
                $con['goods_id']=$id;
                $picurl=$m->where($con)->getField('goods_pic');
                return $picurl;
            }else{
                //无id就是新增的时候又没有上传图片
                return " ";
            }
        }
    }
    public function getOneGoods($id){
      $m = M('Goods');
      return $m->find($id);
    }
    public function getAllGoods(){
        $m = M('Goods');
        return $m->select();
    }

    public function getGoods($id,$cid,$keyword,$color,$price,$price_2,$time){
        $m = M('Goods');
        if($id){
            $con['goods_id'] = $id;
        }

        if ($cid) {
            if (is_array($cid)) {
                $con['goods_cid'] =  array('in',$cid);
            } else {
                $con['goods_cid'] = $cid;
            }

        }

        if($keyword){
            $con['goods_name']=array("like","%".$keyword."%");
        }
        if ($color) {
            $con['goods_color'] = $color;

        }
        if ($price) {
            if ($price == '3') {
                $con['goods_price'] = array('lt','300000');
            } elseif ($price == '1') {
                $con['goods_price'] = array('between','300100,600000');
            } else {
                $con['goods_price'] = array('gt','600000');
            }
        }
        if ($price_2 == 'hightolow') {
            $o = 'goods_price desc';
        } else {
            $o = 'goods_price asc';
        }

        // dump($order);
        // dump($con);
        $result =  $m -> where($con)
            ->order($o)
            ->join("LEFT JOIN x_goods_cat ON x_goods_cat.goodscat_id = x_goods.goods_cid")
            ->select();



        if ($time) {
                foreach ($result as $k => $v) {
                    $result[$k]['quality'] = $v['goods_createtime'] + $v['goods_qualitytime'] * 86400;

                }
                $quality = array();
                foreach ($result as $v){

                    $quality[] = $v['quality'];

                }
                if ($time == 'desc') {
                    array_multisort($quality,SORT_DESC,$result);
                } else if ($time == 'asc') {
                    array_multisort($quality,SORT_ASC,$result);
                }

            }
            // dump($quality);
            // dump($result);
                return $result;

            // dump($result);
        // exit;
    }




}








 ?>
