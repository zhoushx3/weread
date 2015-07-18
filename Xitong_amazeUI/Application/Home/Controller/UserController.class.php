<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function index() {
		redirect(U('Comments/comments'), 0, "redirect to comments");
		// echo "hello world";
	}

	public function logout($error = 0) {
		session('username', null);
		session('bookid', null);
		switch ($error) {
			case '2':
				redirect(U('Notes/bookAllNotes'), 0, 'go back to bookAllNotes');
				# code...
				break;
			case '1':
				redirect(U('Comments/index'), 0, "go to comments");
			default:
				# code...
				break;
		}
		// redirect(U('Index/login'), 3, "loginout success!");
		redirect(U('User/index'), 0, "loginout success!");

	}

	public function login($error = 0) {
		$this.layout(true);
		// $this->assign('error', $error);
		// 0  --- no error
		// 1  --- dian zan
		// 2  --- add comment  
		// 3  --- my bookNotes
		// 4  --  my bookNotes
		$this->assign('gogo', $error);
		$this->display();
	}

	// public function login() 	{
	// 	$this->display();
	// }	
	public function register() {
		$this.layout(true);
		$this->display();
	}


	public function addUsers() {
		$user = D('users');
		if ($user->create()) {
			$result = $user->add();
			if ($result) {
				$this->success('注册成功', 'login');
			} else  {
				$this->error($user->getError());
			}
		} else 	{

			$this->error($user->getError());
		}
	}


	public function loginin($error = 0) {
		$username = I('post.username');
		$password = I('post.password');
		$uu = (string)$username;
		$pp = (string)$password;
		$user = M('users');
		$sql = "username = '$uu' and password = '$pp'";
		$data2 = $user->where("$sql")->find();
		if ($data2) {
			$_SESSION['username'] = $uu;
			// redirect(U('Index/index'), 0);
			// redirect(U("$error"), 0);
			switch ($error) {
				case '1':
				case '2':
					redirect(U('comments/comments'), 0, "go to comments");
					# code...
					break;
				case '3':
					redirect(U('Notes/myBookNotes'), 0, "go to myBookNotes");
					break;
				case '4':
					redirect(U('Notes/myAllNotes'), 0, "go to myAllNotes");
					break;
				default:
					redirect(U('User/index'), 0, 'go to user');
					# code...
					break;
			}
		}	else {
				// echo "login fail";
				$this->error("您的用户名和密码不匹配");
		}
	}


}

