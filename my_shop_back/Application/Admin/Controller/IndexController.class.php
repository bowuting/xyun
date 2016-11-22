<?php
/**
*admin默认控制器
*
*用来显示商品列表
* @author      bowuting@qq.com
* @version     $Id$
* @since       1.0
*/


namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller {

    //展示所有商品列表
    public function showGoodsCatList(){

        $GoodsCat = D('GoodsCat');

        $list = $GoodsCat->getInfiniteGoodsCat();
        $this->assign('list',$list);

        $this->display();
    }
    public function index(){        // 默认方法  取出商品分类并显示
        self::showGoodsCatList();
    }
    public function createGoodsCat(){
        self::showGoodsCatList();
    }

    public function createGoodsCatAction(){
        //自动
        if (I('post.')) {
            $GoodsCat = D('GoodsCat');
            if (!$GoodsCat->create($_POST,1)) {
                $this->error($GoodsCat->getError());
            } else {
                $result = $GoodsCat->add();
                if ($result > 0) {
                    $this->success('新增成功');
                } else {
                    $this->error('新增失败');
                }
            }
        }
    }


    public function deleteGoodsCat($id){

        $GoodsCat = M('goods_cat');
        $res = $GoodsCat->delete($id);
        if ($res > 0) {
          $status  = 1;
          if (IS_AJAX) {
            $this->ajaxReturn($status,"json");
          } else {
            $this->success('删除成功！');
          }
        } else {
          $this->error('删除失败！');
        }
    }




    public function updateGoodsCat(){

      $id = I('get.id');

      $GoodsCat = D('GoodsCat');
      $one = $GoodsCat->find($id);  //得到某一条商品的信息
      $this->assign('one',$one);

      $isHaveChild = $GoodsCat->isHaveChild($id);  //得到是该id的类是否有子类
      $this->assign('isHaveChild',$isHaveChild);

      self::showGoodsCatList();
  }
  public function updateGoodsCatAction()
  {

      if(I('post.')){

         $GoodsCatModel=D('GoodsCat'); //打开一个自定义的模型

         //执行三大自动并放在内存里面
         if (!$GoodsCatModel->create($_POST,2)){
             $this->error($GoodsCatModel->getError());
         }else{

             $result=$GoodsCatModel->save();//自动从内存里面获取数据

             if($result===false){
                 $this->error("错误");
                 exit;
             }else if($result==0){
                 $this->success("执行成功，没有修改任何数据");
                 exit;
             }else{
                 $this->success("修改成功");
                 exit;
             }

         }
     }

  }
}
