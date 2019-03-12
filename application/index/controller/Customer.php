<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//客户案例
class Customer extends Base{

    public function index(){
    	$data = Db::name('customer')->where('is_on','1')->select();
		$cust_img = Db::name('cust_img')->where('is_on','1')->order('id desc')->select();
		
		$this->assign('cust_img',$cust_img);
		$this->assign('data',$data);
    	$this->assign('menu','customer');
        return $this->fetch();
    }
	
	public function info(){
		$id = input('param.id');
		$data = Db::name('customer')->where('is_on','1')->where('id',$id)->find();
//		p($data);
		$this->assign('data',$data);
		$this->assign('menu','customer');
		return $this->fetch();
	}
}
