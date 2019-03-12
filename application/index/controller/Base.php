<?php

namespace app\index\controller;
use think\Controller;
use app\admin\model\ConfigModel;
use think\Db;
class Base extends Controller{
    public function _initialize(){
		$configModel = new ConfigModel();
        $list = $configModel->getAllConfig();
        $config = [];
        foreach ($list as $k => $v) {
            $config[trim($v['name'])] = $v['value'];
        }
        $this->counts();
        $this->assign('config',$config);
    }

    /**
     * [counts 记录访问量及ip]
     * @return [type] [description]
     */
    public function counts(){
    	$arr = ['ip'=>request()->ip(),'add_time'=>time()];
    	$today = strtotime(date("Y-m-d"),time());
    	$today24 = $today + 86400;
    	$sta = Db::name('counts')->where(['ip'=>$arr['ip'],'add_time'=>['between',[$today,$today24]]])->find();
    	if(!$sta){
    		Db::name('counts')->insert($arr);
    	}

    }
}