<?php

namespace app\api\controller;
use think\Controller;
use think\Db;

/**
 * swagger: 用户中心
 */
class User
{
	/**
	 * post: 登陆
	 * path: login
	 * method: login
	 * param: username - {string} 用户名
	 * param: password - {string} 密码
	 */
	public function login($username, $password) {
        
		if ($username != '' || $password != '') {
			$map['username'] = $username;
			$map['password'] = md5(md5($password) . config('auth_key'));		
			$user = Db::name('admin')->where($map)->find();
			if ($user == false)
			{	
				$data['code'] = 403;
				$data['msg'] = '账号或密码错误';
				return json($data);
			} else {
				$data['code'] = 200;
				$data['datas'] = $user;
				$data['msg'] = '登录成功';
				return json($data);
			}
		} else {
			$data['code'] = 400;
			$data['msg'] = '参数错误';
			return json($data);
		}
			
    }


	/**
	 * get: 根据token获取用户信息
	 * path: getUserInfo
	 * method: getUserInfo
	 * param: token - {string} 用户token
	 */
	public function getUserInfo($token) {
		if (strlen($token) == 32) {
			$user = Db::name('admin')->where('token', $token)->find();
			if ($user) {
				$data['code'] = 200;
				$data['datas'] = $user;
				$data['msg'] = '获取用户信息成功';
				return json($data);
			} else {
				$data['code'] = 404;
				$data['msg'] = '用户不存在';
				return json($data);
			}
			
		} else {
			$data['code'] = 400;
			$data['msg'] = '参数错误';
			return json($data);
		}
		
	}


	/**
	 * post: 修改手机号
	 * path: editphone
	 * method: editphone
	 * param: id - {int} 用户id
	 * param: phone - {string} 手机号
	 */
    public function editphone($id, $phone) {
    	if ($id != '' || $phone != '') {
			$info = Db::name('admin')->where('id',$id)->update(['phone' => $phone]);
			if($info){
				$data['code'] = 200;				
				$data['msg'] ='修改成功';
				return json($data);
			}else{
				$data['code'] = 403;
				$data['msg'] ='修改失败';
				return json($data);
			}
		} else {
			$data['code'] = 400;
			$data['msg'] = '参数错误';
			return json($data);
		}
	}


	/**
	 * post: 修改密码
	 * path: editpwd
	 * method: editpwd
	 * param: id - {int} 用户id
	 * param: oldpwd - {string} 旧密码
	 * param: oldpwd - {string} 新密码
	 */
	public function editpwd($id, $oldpwd, $newpwd){

		$oldpwd = md5(md5($oldpwd) . config('auth_key'));	
		$newpwd = md5(md5($newpwd) . config('auth_key'));	
		$user = Db::name('admin')->where('id',$id)->field('id,password')->find();
		if($user['password'] != $oldpwd){
			$data['code'] = 403;
			$data['msg'] ='原密码错误';
			return json($data);
		}else{
			$pwd['password'] = $newpwd;
			$info = Db::name('admin')->where('id',$id)->update($pwd);
			if($info){
				$data['code'] = 200;
				$data['msg'] ='修改成功';
				return json($data);
			}else{
				$data['code'] = 0;
				$data['msg'] ='修改失败';
				return json($data);
			}
			
		}
	}


}