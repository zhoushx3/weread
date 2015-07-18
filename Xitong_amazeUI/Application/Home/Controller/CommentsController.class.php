<?php
namespace Home\Controller;
use Think\Controller;
class CommentsController extends Controller {
	
	public function index() {
		redirect(U('Comments/comments'), 0, "redirect to comments");
	}

	public function myAllNotes() {
		redirect(U('Notes/myAllNotes'), 0, 'redirect to myAllNotes');
	}

	public function allNotes()  {
		redirect(U('Notes/allNotes'), 0, 'redirect to allNotes');
	}

	public function allBooks()  {
		redirect(U('Books/allBooks'), 0, 'redirect to all Books');
	}
	

	public function gotoNotes() {
		redirect(U('Notes/index'), 0, "go to notes");
	}

	public function comments($bookId = -1) {
		if ($bookId !=  -1) {
			$_SESSION['bookid'] = $bookId;
		}
		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				$_SESSION['bookid'] = 1;
				$bookId = 1;
		}
		$username_session = getUsername();
		$book = M('books');
		$bookInfo = $book->find($bookId);
		$comments = M('comments');
		$comments_match_bookid_sql = "bookid = '$bookId'";
		$commentsList = $comments->where("$comments_match_bookid_sql")->order('create_time desc')->select();
		$commentsCount = count($commentsList);
		$bookzan = M('bookzan');
		$bookzan_count_where_sql = "bookid = '$bookId'";
		$bookzanCount = $bookzan->where("$bookzan_count_where_sql")->count();
		$bookzan_user_where_sql = "username = '$username_session'";
		$userBookzanCount = $bookzan->where("$bookzan_user_where_sql")->count();

		if (noLogin()) {
			$username_session = "未登录";
			$userDianzan = 0;
		}
		if ($bookInfo) {
			$this->assign('bookInfo', $bookInfo);
			$this->assign('username', $username_session);
			$this->assign("commentsList", $commentsList);
			$this->assign('commentsCount', $commentsCount);
			$this->assign('bookzanCount', $bookzanCount);
			$this->assign('userDianzan', $userBookzanCount);
		}	else {
			redirect(U('Comments/comments'), 3, "there isn't this book!");
		}
		// php 判断是否为 ajax 请求  http://www.cnblogs.com/sosoft/
		if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
			$this->ajaxReturn($commentsList);
		}else{ 
	    // 正常请求的处理方式 
			$this.layout(true);
			$this->display(singleComments);
		};
	}

	public function addComment() {
		if (noLogin()) {
			redirect(U('User/login', array('error' => 2)), 0, "go to login");
		}
		$comment = D('comments');
		if ($comment->create()) {
			$result = $comment->add();
			if ($result) {
				redirect(U('comments'), 0, "success");
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($comment->getError());
		}
	}

	public function zan($id) {
		// ajax return the count of zan and whether the user has zan
		$bookId = $id;
		$username_session = getUsername();
		$bookzan = M('bookzan');
		$bookzan_count_where_sql = "bookid = '$bookId'";
		$bookzan_user_where_sql = "username = '$username_session'";
		$zan['bookzanCount'] = $bookzan->where("$bookzan_count_where_sql")->count();
		$zan['userBookzanCount'] = $bookzan->where("$bookzan_user_where_sql")->count();
		$this->ajaxReturn($zan);
	}

	public function dianzan($dian = 0, $bookid=1) {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 1)), 0, "go to login");
		}
		// bookid != 1 表示是从所有图书页面传过来的
		if ($bookid == 1)
			$bookid = getBookid();
		if ($dian == 1) {
			// dianle
			$zan = M('bookzan');
			$username = getUsername();
			$del_zan_sql = "bookid = '$bookid' and username = '$username'";
			$zan->where("$del_zan_sql")->delete();
		}	else {
				$zan = D('bookzan');
				$bookzan = getBookzan();
				$zan -> create($bookzan, 3);
				$zan -> add();
		}
		redirect(U('Comments/comments'), 0, "dianzan success!");
	}

	public function logout($error = 0) {
		redirect(U("User/logout", array('error' => $error)), 0, "log out");
	}

	public function goNote() {
		redirect(U("Notes/index"), 0, "go notes");
	}

}

