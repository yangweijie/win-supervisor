<?php

namespace app\user\common\event;

use app\admin\model\Menu;
use app\admin\model\Module;
use app\user\model\Role;
use app\user\model\User;

class UserRegister
{
	/**
	 * 根据模块创建角色
	 * 根据用户手机号创建帐号
	 */
	public function handle($userinfo = [])
	{
		//检测参数是否存在
		if (!isset($userinfo['module'])) {
			return false;
		}
		if (!isset($userinfo['mobile'])) {
			return false;
		}
		//判断模块是否存在
		$modules =	Module::getModule();

		if (!in_array($userinfo['module'], array_keys($modules))) {
			return false;
		}

		//判断角色是否存在(每个模块创建的用户默认只分配该模块的角色)

		$Menu =	Menu::where(['module' => $userinfo['module'], 'pid' => 0, 'status' => 1])->field('id,title')->find();
		$role =	Role::where(['pid' => 0, 'name' => $Menu['title']])->find();
		if (!$role) {
			//创建角色
			$data['pid'] = 0;
			$data['name'] = $Menu['title'];
			$data['description'] = $Menu['title'] . '默认角色';
			$data['default_module'] = 1;
			$data['access'] = '0'; //是否能登录后台，默认都不可以登录
			$data['sort'] = 100;
			if (isset($userinfo['menu_auth'])) {
				$data['menu_auth'] = is_array($userinfo['menu_auth']) ? json_encode([$Menu['id']]) : $userinfo['menu_auth'];
			} else {
				$data['menu_auth'] = json_encode([$Menu['id']]);
			}

			$role = Role::create($data);
			if (!$role) {
				return false;
			}
		}
		$user =	User::where(['mobile' => $userinfo['mobile']])->withoutField('password,last_login_time,last_login_ip')->find();
		if (!$user) {
			//创建用户并关联角色
			$user['mobile'] = $userinfo['mobile'];
			$user['nickname'] = $userinfo['mobile'];
			$user['username'] = md5($userinfo['mobile']);
			$user['password'] = md5(md5($userinfo['mobile']));
			$user['role'] = $role->id;
			$user['status'] = 1;
			$user =	User::create($user);
			//完成注册
		}
		return $user->toArray();
	}
}
