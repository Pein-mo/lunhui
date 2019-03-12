<?php
namespace app\ceshi\controller;
use EasyWeChat\Factory;
use think\Controller;
class Index extends Controller{
	protected $app;

	public function _initialize(){
		$config = config('easy_wechat');
    	$this->app= Factory::officialAccount($config);	
	}
    public function index(){
    	
    	$this->app->server->push(function ($message) {
		    return "您好！欢迎关注我！";
		});
        $response = $this->app->server->serve();
        $response->send();
    }

    /**
     * [oauth_callback 回调方法]
     * @return [type] [description]
     */
    public function oauth_callback(){
    	$oauth = $this->app->oauth;

		// 获取 OAuth 授权结果用户信息
		$user = $oauth->user();
		session('wechat_user',$user->toArray());
		// p(session('wechat_user'));
		// p(session('target_url'));
		$targetUrl = empty(session('target_url')) ? '/' : session('target_url');

		header('location:'. $targetUrl); // 跳转到 user/profile

        
    }

    /**
     * [profile 目标方法]
     * @return [type] [description]
     */
    public function profile(){
    	$oauth = $this->app->oauth;

		// 未登录
		if (empty(session('wechat_user'))) {
		  session('target_url',url('ceshi/index/profile'));
		  return $oauth->redirect();
		  // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
		  // $oauth->redirect()->send();
		}

		// 已经登录过
		$user = session('wechat_user');
		p($user);
    }
}
