<?php

namespace app\admin\controller;
use app\admin\model\CountsModel;
use think\Db;
use com\IpLocation;
use QL\QueryList;
 //采集器
class Coll extends Base{


    public function index(){
       die;
        $html=file_get_contents("http://news.qq.com/");
        $ql = QueryList::html($html)->rules([
                'href'=>['.con .Q-tpWrap .pic','href'],
                'photo'=>['.con .Q-tpWrap .picto','src'],
                'title'=>['.con .Q-tpWrap .text em a','text'],
            ])->encoding('UTF-8','GB2312')->query();
        $data = $ql->getData();
        $dataArr = $data->all();
        foreach ($dataArr as $k => $v) {
            if(!array_key_exists('photo',$dataArr[$k])){
                unset($dataArr[$k]);
            }   
        }
        foreach ($dataArr as $k => $v) {
            $cent_html = file_get_contents($v['href']);
            $sqls = QueryList::html($cent_html)->rules(['cent'=>['#Cnt-Main-Article-QQ','html']])->encoding('UTF-8','GB2312')->query()->getData(function($a){
                return $a['cent'];
        })->all();
            if($sqls){
                $dataArr[$k]['content'] = $sqls[0];
            }
            $dataArr[$k]['create_time'] = time();
            $s = Db::name('news')->where('title',$v['title'])->find();
            if($s){
                unset($dataArr[$k]);
            }
            unset($dataArr[$k]['href']);
        }
        foreach ($dataArr as $k => $v) {
            Db::name('news')->insert($v);  
        }
    }


    public function indexs(){
        $html=file_get_contents("http://news.qq.com/");
        $ql = QueryList::html($html)->rules([
                'href'=>['.con .Q-tpWrap .pic','href'],
                'photo'=>['.con .Q-tpWrap .picto','src'],
                'title'=>['.con .Q-tpWrap .text em a','text'],
            ])->encoding('UTF-8','GB2312')->query();
        $data = $ql->getData();
        $dataArr = $data->all();
        foreach ($dataArr as $k => $v) {
            $cent_html = file_get_contents($v['href']);
            $sqls = QueryList::html($cent_html)->rules(['cent'=>['#Cnt-Main-Article-QQ','html']])->encoding('UTF-8','GB2312')->query()->getData(function($a){
                return $a['cent'];
        })->all();
            $dataArr[$k]['content'] = $sqls[0];
            $dataArr[$k]['add_time'] = time();
            $s = Db::name('news')->where('title',$v['title'])->find();
            if($s){
                unset($dataArr[$k]);
            }
        }

        $sta = Db::name('news')->insertAll($dataArr);
        if($sta){
            p('添加成功');
        }else{
            p('添加失败');
        }
    }

    public function indexsss(){
        $html=file_get_contents("http://news.qq.com/");
        $ql = QueryList::html($html)->rules([
                'href'=>['.con .Q-tpWrap .pic','href'],
                'img'=>['.con .Q-tpWrap .picto','src'],
                'title'=>['.con .Q-tpWrap .text em a','text'],
            ])->encoding('UTF-8','GB2312')->query();
        $data = $ql->getData();
        $dataArr = $data->all();
        // foreach ($dataArr as $k => $v) {
        //     $cent_html = file_get_contents($v['href']);
        // }
        $cent_html = file_get_contents("http://new.qq.com/omn/20180319/20180319A0UUYI.html");
        $sqls = QueryList::html($cent_html)->rules(['cent'=>['.content','html']])->encoding('UTF-8','GB2312')->query()->getData(function($a){
                return $a['cent'];
        })->all();
        p($sqls);
    }
 
}