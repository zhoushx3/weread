<?php
namespace Admin\Controller;
use Think\Controller;
class BooksController extends Controller {
	
	public function index() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('Books/allBooks'), 0, "redirect to allBooks");
	}


	public function deleteComment() {
		$commentModel = M('comments');
		$id = I('post.id');
		$commentModel->delete($id);
		// redirect(U('Books/index'), 0, 'go to books index');
	}

	public function deleteNote()  {
		$noteModel = M('notes');
		$id = I('post.id');
		$noteModel->delete($id);
		redirect(U('Books/index'), 0, 'go to books index');
	}

	public function manageUser()	{
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('User/manageUser'), 0, "go to all books");
	}

	public function manageBook()	{
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('allBooks'), 0, "go to all books");
	}

	public function background() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		redirect(U('BackGround/backInfo'));
	}

	public function addBook() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$this.layout(true);
		$this->display();
	}

	public function addBookin() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}


		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/BookPhotoes/'; // 设置附件上传根目录
    	$upload->savePath  =     ''; // 设置附件上传（子）目录
    	$upload->callback  = 	  true;
    	$upload->autoSub 	 = 	false;
    	$info   =   $upload->upload();
    	if(!$info) {// 上传错误提示错误信息
        	$error = $upload->getError();
        	if ($error == "没有文件被上传！") {
        		$photo = NULL;
        	}	else {
        			$this->error($upload->getError);
        	}
    	}else{// 上传成功
	        $photo = $info['photo']['savename'];
    	}

		$bookModel = M('books');
		$data['bookname'] = I('post.bookname');
		$data['press'] = I('post.press');
		$data['ISBN'] = I('post.ISBN');
		$data['picture'] = $photo;
		$data['author'] = I('post.author');
		$data['summary'] = I('post.summary');
		$data['create_time'] = NOW_TIME;

		$bookModel->add($data);
		// redirect(U('index'), 0, "add success, go to see my all books");
		redirect(U('Books/allBooks'), 0, 'go to all books');

	}

	public function deleteBook($id) {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$bookModel = M('books');
		$noteModel = M('notes');
		$commentModel = M('comments');
		$zanModel = M('bookzan');
		$bookid_sql = "bookid = '$id'";
		
		$bookModel->delete($id);
		$noteModel->where("$bookid_sql")->delete();
		$commentModel->where("$bookid_sql")->delete();
		$zanModel->where("$bookid_sql")->delete();
		redirect(U('Books/allBooks'), 0, 'delete success');
	}


	public function allBooks() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$bookModel = M('books');
		$allBooks = $bookModel->order('id')->select();
		$countBooks = count($allBooks);
		$this->assign('allBooks', $allBooks);
		$this->assign('countBooks', $countBooks);
		$this.layout(true);
		$this->display();
	}

	public function lookComments() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}

		$this.layout(true);

		$id = I('post.id');
		$book = M('books');
		$bookInfo = $book->find($id);

		$comments = M('comments');
		$comments_match_bookid_sql = "bookid = '$id'";
		$commentsList = $comments->where("$comments_match_bookid_sql")->order('create_time desc')->select();
		$commentsCount = count($commentsList);

		if ($bookInfo) {
			$this->assign('bookInfo', $bookInfo);
			$this->assign("commentsList", $commentsList);
			$this->assign('commentsCount', $commentsCount);
		}	else {
			redirect(U('Books/index'), 3, "go to books index");
		}
		$this->display();
}


	public function lookNotes() {
		$admin = session('admin');
		if ($admin != "weread") {
			redirect(U('User/login'), 0, "go to login");
		}
		
		$id = I('post.id');		// echo $id;

		$book = M('books');
		$bookInfo = $book->find($id);

		$bookAllNotes = M('notes');
		$book_all_users_notes_public = "bookid = '$id'";
		$allNotes = $bookAllNotes->where("$book_all_users_notes_public")->order('create_time desc')->select();
		$allNotesCount = count($allNotes);

		$this->assign('allNotes', $allNotes);
		$this->assign('bookInfo', $bookInfo);
		$this->assign('allNotesCount', $allNotesCount);

		$this.layout(true);
		$this->display();
	}

	public function logout() {
		redirect(U('User/logout'), 0, "logout");
	}
}

