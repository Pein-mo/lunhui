<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;

class Index extends Base
{
    public function index()
    {
        
        return $this->fetch('/index');
    }


    /**
     * [indexPage 后台首页]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function indexPage()
    {
         //今日新增访问量
        $today = strtotime(date('Y-m-d 00:00:00'));//今天开始日期     
        $map['add_time'] = array('egt', $today);
        $day = Db::name('counts')->where($map)->count();
        $this->assign('day', $day);

        //这周新增访问量
        $week = strtotime('-1 monday', time());//今天开始日期     
        $map['add_time'] = array('egt', $week);
        $week = Db::name('counts')->where($map)->count();
        $this->assign('week', $week);

        //每月新增访问量
        $month = strtotime(date('Y-m', time()) . '-01 00:00:00');    
        $map['add_time'] = array('egt', $month);
        $month = Db::name('counts')->where($map)->count();
        $this->assign('month', $month);

        $info = array(
            'web_server' => $_SERVER['SERVER_SOFTWARE'],
            'onload'     => ini_get('upload_max_filesize'),
            'think_v'    => THINK_VERSION,
            'phpversion' => phpversion(),
        );

        $this->assign('info',$info);
        return $this->fetch('index');
    }


    /**
     * 清除缓存
     */
    public function clear() {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            return json(['code' => 1, 'msg' => '清除缓存成功']);
        } else {
            return json(['code' => 0, 'msg' => '清除缓存失败']);
        }
    }

}
