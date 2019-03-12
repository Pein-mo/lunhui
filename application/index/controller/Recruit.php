<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//网站首页
class Recruit extends Base{

    public function index(){
    	$data = Db::name('recruit')->where('status','1')->order('id desc')->select();
		$this->assign('data',$data);
		$this->assign('menu','recruit');
        return $this->fetch();
    }
}
