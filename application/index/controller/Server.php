<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//网站首页
class Server extends Base{

    public function index(){
    	$data = Db::name('server')->where('is_on',1)->select();
		$this->assign('data',$data);
		$this->assign('menu','server');
        return $this->fetch();
    }
}
