<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\cache\driver\Redis;
//网站首页
class Index extends Base{

    public function index(){
        
    	$customer = Db::name('customer')->where('is_on','1')->select();
		$img = Db::name('index_img')->where('is_on','1')->select();
		$news = Db::name('news')->where('status','1')->order('id desc')->limit(2)->select();
		$cust_img = Db::name('cust_img')->where('is_on','1')->order('id desc')->select();
		$solu_cate = Db::name('solutions_cate')->where('is_on','1')->order('id desc')->select();
		$this->assign('a',$solu_cate);
		$this->assign('solu_cate ',$solu_cate);
		$this->assign('cust_img',$cust_img);
		$this->assign('news',$news);
		$this->assign('img',$img);
		$this->assign('customer',$customer);
		$this->assign('menu','index');
        return $this->fetch();
    }

    public function indexs(){
        p(1);die;
    	$dir = ROOT_PATH . 'public' . DS . 'uploads/images';
    	$data = read_all_dir($dir);
    	$arr =[];
    	foreach ($data['dir'] as $k => $v) {
    		 foreach ($v['file'] as $key => $value) {
    		 	$arr[] = $value;
    		 }
    	}

    	$img_arr = [];
    	$imgs = Db::name('product')->select();
    	foreach ($imgs as $k => $v) {
    		$img_arr[] = substr(strchr($v['img'], "\\"), 1);
    	}
    	$arrs=[];
    	foreach ($arr as $k => $v) {
    		$arrs[] = substr(strrchr($v, "/"), 1);
    	}
    	foreach ($arrs as $k => $v) {
    		if(in_array($v,$img_arr)){
    			p(unlink($arr[$k]));
    		}
    	}
    }

    public function index1(){
        $redis = new Redis();
        $arr = array('name'=>'张三','age'=>20);
        // $arr = serialize($arr);
        // $redis->set('mo',$arr);
        $a = $redis->get('mo');
        $a = unserialize($a);
        p($a);
  
    }
}
