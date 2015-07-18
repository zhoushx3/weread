<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index() {
		redirect(U('Books/allBooks'), 0, "redirect to comments");
		// redirect(U('Comments/comments'), 0, "redirect to comments");

	}

}
