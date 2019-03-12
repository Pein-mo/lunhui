<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//产品展示
class Product extends Base{

    public function index(){
    	
		$data = Db::name('product')->join('think_product_cate', 'think_product.cate_id = think_product_cate.id')->where('think_product.is_on','1')->select();
		$this->assign('data',$data);
    	$this->assign('menu','product');
        return $this->fetch();
    }
	
	public function info(){
		
		$this->assign('menu','customer');
		return $this->fetch();
	}
}
