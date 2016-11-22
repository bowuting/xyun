<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends CommonController{
    //初始化
    // public function _initialize(){
    //
    //     //当前时间+123+dhsajdh+
    //
    //     // if(trim(I('param.robot'))==robot()){
    //         //验证API成功
    //         // $this->app="app";
    //     // }
    //
    // }

    public function index(){
        $Goods = D(Goods);
        $list = $Goods->getAllGoods();
        $this->assign('list',$list);
        $this->display();
    }


    public function createGoods(){

        if(I('post.')){

            $GoodsModel=D('Goods');

            if (!$GoodsModel->create($_POST,1)){
                $this->error($GoodsModel->getError());
            }else{
                echo "string";
                $result=$GoodsModel->add();
                if($result>0){

                    $this->success("新增成功");
                    exit;
                }else{

                    $this->error("新增失败");
                    exit;
                }
            }

        }

        $GoodsCat = D('GoodsCat');
        $list = $GoodsCat -> getInfiniteGoodsCat();
        $this -> assign('list',$list);

        $this->display();
    }

    public function updateGoods(){

      if(I('post.')){
        // dump(I('post.'));
        // exit;
          $GoodsModel=D('Goods');

          if (!$GoodsModel->create($_POST,2)){
              $this->error($GoodsModel->getError());
          }else{

              $result=$GoodsModel->save();
              if($result>0){

                  $this->success("更新成功");
                  exit;
              }else{

                  $this->error("更新失败");
                  exit;
              }
          }

      }

      $GoodsCat = D('GoodsCat');
      $list = $GoodsCat -> getInfiniteGoodsCat();
      $this -> assign('list',$list);
      dump($list);

      $Goods = D('Goods');
      $id = I('get.id');
      $goodsOne = $Goods->getOneGoods($id);
      $this->assign('goodsOne',$goodsOne);
      dump($goodsOne);

      $this->display();
    }





}

 ?>
