<?php

namespace app\admin\controller;
use think\Controller;
use think\File;
use think\Request;

use OSS\Core\OssException;
use OSS\OssClient;
use think\Controller;
use think\facade\Config;
use think\Image;
class Upload extends Base
{
	//图片上传
    public function upload(){
       $file = request()->file('file');
       $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/images');
       if($info){
            echo $info->getSaveName();
        }else{
            echo $file->getError();
        }
    }

    //会员头像上传
    public function uploadface(){
       $file = request()->file('file');
       $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/face');
       if($info){
            echo $info->getSaveName();
        }else{
            echo $file->getError();
        }
    }

     public function uploadFile()
    {
        $file = request()->file('file');  //获取到上传的文件
        $resResult = Image::open($file);
        // 尝试执行
        try {
            $config = Config::pull('aliyun_oss'); //获取Oss的配置
            //实例化对象 将配置传入
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
            //这里是有sha1加密 生成文件名 之后连接上后缀
            $fileName = sha1(date('YmdHis', time()) . uniqid()) . '.' . $resResult->type();
            //执行阿里云上传
            $result = $ossClient->uploadFile($config['Bucket'], $fileName, $file->getInfo()['tmp_name']);
            /**
             * 这个只是为了展示
             * 可以删除或者保留下做后面的操作
             */
            $arr = [
                '图片地址:' => $result['info']['url'],
                '数据库保存名称' => $fileName
            ];

            echo $result['info']['url'];
        } catch (OssException $e) {
            return $e->getMessage();
        }
        //将结果输出
        dump($arr);
    }

}