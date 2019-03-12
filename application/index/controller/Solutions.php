<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//解决方案
class Solutions extends Base{

    public function index(){
    	$cate = Db::name('solutions_cate')->where('is_on','1')->order('id asc')->select();
		//网上商城
		$solu1 = Db::name('solutions')->where('is_on','1')->where('cate_id','5')->order('id asc')->select();
		//微信开发
		$solu2 = Db::name('solutions')->where('is_on','1')->where('cate_id','6')->order('id asc')->select();
		//微信小程序开发
		$solu3 = Db::name('solutions')->where('is_on','1')->where('cate_id','7')->order('id asc')->select();
		//企业官网定制
		$solu4 = Db::name('solutions')->where('is_on','1')->where('cate_id','8')->order('id asc')->select();
		// p();
		$id = input('param.id');
		$this->assign('id',$id);
		$this->assign('solu1',$solu1);
		$this->assign('solu2',$solu2);
		$this->assign('solu3',$solu3);
		$this->assign('solu4',$solu4);
		$this->assign('cate',$cate);
    	$this->assign('menu','solutions');
        return $this->fetch('solutions');
    }
	
	public function info(){
		$id = input('param.id');
		$data = Db::name('solutions')->where('is_on','1')->where('id',$id)->find();
		$this->assign('data',$data);
		$this->assign('menu','solutions');
		return $this->fetch();
	}
}
