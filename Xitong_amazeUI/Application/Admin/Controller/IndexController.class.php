<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}
		redirect(U('BackGround/index'), 0, "redirect to BackGround");
	}

}
