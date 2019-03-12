<?php
namespace app\index\controller\a;
use think\Controller;
use think\Db;
//解决方案
class Index extends Controller{

    public function index(){
    	p(2);
    }
	
	public function info(){
		$id = input('param.id');
		$data = Db::name('solutions')->where('is_on','1')->where('id',$id)->find();
		$this->assign('data',$data);
		$this->assign('menu','solutions');
		return $this->fetch();
	}
}
