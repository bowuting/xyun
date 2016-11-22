<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{


    //初始化
    public function _initialize(){

        //当前时间+123+dhsajdh+

        if(trim(I('param.robot'))=="888"){
            //验证API成功
            $this->app="app";
        }

    }


}
