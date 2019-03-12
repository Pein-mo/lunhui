<?php
namespace app\index\controller;

use think\Db;
//网站首页
class About extends Base{

    public function index(){
    	$data = Db::name('office')->where('status', '1')->select();
		$img =  Db::name('office')->where('status', '0')->find();
		$this->assign('img',$img);
		$this->assign('data',$data);
		$this->assign('menu','about');
        return $this->fetch();
    }
}
