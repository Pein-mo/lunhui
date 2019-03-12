<?php

namespace app\admin\controller;
use app\admin\model\CountsModel;
use think\Db;
use com\IpLocation;
 //访问量控制器

class Counts extends Base
{

    /**
     * [operate_log 操作日志]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function index()
    {

        $start_time = input('start_time');
        $end_time = input('end_time');
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $map = [];
        if($start_time&&$start_time!==""){
            $time = strtotime($start_time);
            $map['add_time'] = ['>',$time];
        } 
        if($end_time&&$end_time!==""){
            $time = strtotime($end_time);
            $map['add_time'] = ['<',$time];
        }
        if($end_time&&$start_time){
            $end_time = strtotime($end_time);
            $start_time = strtotime($start_time);
            $map['add_time'] = [['<',$end_time],['>',$start_time]];
            
        }    
        $arr=Db::name("admin")->column("id,username"); //获取用户列表      
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('counts')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $lists = Db::name('counts')->where($map)->page($Nowpage, $limits)->order('add_time desc')->select();   
        // p(Db::name('counts')->getlastsql());    
        $Ip = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
        foreach($lists as $k=>$v){
            $lists[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
            $lists[$k]['ipaddr'] = $Ip->getlocation($lists[$k]['ip']);
        }  
        // p($lists);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数 
        $this->assign('count', $count);
        $this->assign("search_user",$arr);
        
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
    }


    /**
     * [del_log 删除日志]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del()
    {
        $id = input('param.id');
        $log = new CountsModel();
        $flag = $log->del($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
 
}