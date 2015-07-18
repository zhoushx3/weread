<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
	public function index() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('User/manageUser'), 0, "redirect to manageUser");
	}


	public function manageUser() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$userModel = M('users');
		$userAll = $userModel->order('create_time', desc)->select();
		$userCount = $userModel->count();

		$this->assign('userAll', $userAll);
		$this->assign('userCount', $userCount);
		$this.layout(true);
		$this->display();
	}

	public function deleteUser($id) {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$userModel = M('users');
		$userInfo = $userModel->find($id);
		$username = $userInfo['username'];
		$commentModel = M('comments');
		$noteModel = M('notes');
		$zanModel = M('bookzan');
		$username_sql = "username = '$username'";
		
		$commentModel->where("$username_sql")->delete();
		$zanModel->where("$username_sql")->delete();
		$noteModel->where("$username_sql")->delete();
		$userModel->delete($id);
		redirect(U('User/index'), 0, "delete success");
	}

	public function manageBook()	{
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('Books/allBooks'), 0, "go to all books");
	}


	public function background() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('BackGround/backInfo'), 0, "go to background");
	}


	public function logout() {
		session('admin', null);
		redirect(U('User/index'), 0, "loginout success!");
	}

	public function login() {
		$this.layout(true);
		$this->display();
	}

	public function register() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$this.layout(true);
		$this->display();
	}


	public function addUsers() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

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


	public function loginin() {
		$username = I('post.username');
		$password = I('post.password');

		if ($username == "admin" and $password == "weread") {
			session('admin', "weread");
			redirect(U('BackGround/backInfo'), 0, "go to background");
		}	else {
			redirect(U('User/login'), 0, "go to login");
		}
	}

}

