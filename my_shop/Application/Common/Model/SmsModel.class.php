<?php
namespace Common\Model;
use Think\Model;
class SmsModel extends Model{




    //这个手机号码在数据库是否存在
    public function isSms($phonenum){


        $m=M('sms');
        $con['sms_phone']=$phonenum;
        $result=$m->where($con)->getField('sms_id');

        if($result){
            return true;
        }else{
            return false;
        }


    }

    //添加手机号码到数据库
    public function addPhone($phonenum,$code){

        $m=M('sms');
        $con['sms_phone']=$phonenum;
        $con['sms_is_black']=0;
        $con['sms_last_sendtime']=time();
        $con['sms_code']=$code;
        $con['sms_total_times']=1;
        $con['sms_today_times']=1;


       $result= $m->add($con);

        if($result>0){
            return true;
        }else{
            return false;
        }

    }


    //是否标注为黑名单
    public function isBlack($phonenum){

        $m=M('sms');
        $con['sms_phone']=$phonenum;
        $result=$m->where($con)->getField('sms_is_black	');

        if($result==1){
            //在黑名单中
            return true;
        }else{
            return false;
        }


    }

    //判断上次发送时间是今天吗
    public function isLastSendOnToday($phonenum){

        $m=M('sms');
        $con['sms_phone']=$phonenum;
        $lasttime=$m->where($con)->getField('sms_last_sendtime');

        //strtotime("字符串") to 时间戳
        //time() 获取当前时间戳
        // date("Y-m-d H:i:s",时间戳);

        if(strtotime(today)<$lasttime){
          // echo strtotime(today);
          // echo $lasttime;
            //代表上次发送发送在之前
            return 1;
        }else{
          // echo strtotime(today);
          // echo $lasttime;
            return 0;
        }

    }

    //修改手机号码与参数
    public function updatePhone($phone,$code,$todayFirst){

        $m=M('sms');
        $condition['sms_phone']=$phone;

        if($todayFirst === 1){
            $con['sms_today_times']=$todayFirst;//今天第一次发  1
        }

        $con['sms_last_sendtime']=time();
        $con['sms_code']=$code;

        return $result=$m->where($condition)->save($con);
    }



    //递增 今天发送的数量
    public function setIncTodayTimes($phone){
        $m=M('sms');
        $condition['sms_phone']=$phone;
        return  $result= $m->where($condition)->setInc('sms_today_times',1);
    }

    //递增 总数量
    public function setIncTotalTimes($phone){

        $m=M('sms');
        $condition['sms_phone']=$phone;
        return  $result= $m->where($condition)->setInc('sms_total_times',1);

    }

    //今天发送的条数是否已经超过五条
    public  function isSmsFiveTimesToday($phone){
        $m=M('sms');
        $condition['sms_phone']=$phone;
        return  $result= $m->where($condition)->getField('sms_today_times');
    }

    //检测短信验证码是否正确
    public function checkSms($phone,$num){

        $m=M('sms');
        $condition['sms_phone']=$phone;
        $condition['sms_code']=$num;
        $result=$m->where($condition)->find();

        if($result){
            return 1;
        }else{
            return 0;
        }
    }

    //检测短信验证码时间在10分钟内有效
    public function checkSms10Min($phone){

        $m=M('sms');
        $condition['sms_phone']=$phone;
        $result=$m->where($condition)->getField('sms_last_sendtime');

        if(($result+600)>time()){
            //十分钟之内
            return 1;
        }else{
            return 0;
        }

    }


}
