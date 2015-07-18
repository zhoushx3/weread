<?php
namespace Home\Model;
use Think\Model;
class usersModel extends Model {
    // 定义自动验证
    protected $_validate = array(
		array('username', 'require', '用户名必须！'),
		array('username', '', '该用户名已经被使用', 0, 'unique'),
		array('password', 'require', '密码必须！'),
		array('repassword', 'require', '确认密码必须！'),
		array('repassword', 'password', '确认密码不正确', 0, 'confirm'),
		array('email', 'require', 'email必须！'),
		array('email', '', '该邮箱已经被使用', 0, 'unique'),
	);

	protected $_auto    =   array(
        array('create_time','time',1,'function'),
    );
    // 定义自动完成
    // 定义自动完成
 }
