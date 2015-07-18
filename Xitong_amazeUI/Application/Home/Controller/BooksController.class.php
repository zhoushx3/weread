<?php
namespace Home\Controller;
use Think\Controller;
class BooksController extends Controller {
	
	public function index() {
		redirect(U('Books/allBooks'), 0, "redirect to allBooks");
	}

	public function myAllNotes() {
		redirect(U('Notes/myAllNotes'), 0, 'redirect to myAllNotes');
	}

	public function allNotes()  {
		redirect(U('Notes/allNotes'), 0, 'redirect to allNotes');
	}

	public function logout() 	{
		redirect(U('User/logout'), 0, "log out");
	}

	public function allBooks() {
		$bookModel = M('books');
		$allBooks = $bookModel->order('id')->select();
		$countBooks = count($allBooks);
		$this->assign('allBooks', $allBooks);
		$this->assign('countBooks', $countBooks);
		$this.layout(true);
		$this->display();
	}

	public function lookInfo() {
		$id = I('post.id');
		$book = M('books');
		$bookInfo = $book->find($id);
		$simpleBookInfo['书名'] = $bookInfo['bookname'];
		$simpleBookInfo['作者'] = $bookInfo['author'];
		$simpleBookInfo['isbn'] = $bookInfo['isbn'];
		$simpleBookInfo['出版社'] = $bookInfo['press'];
		$simpleBookInfo['内容简介'] = $bookInfo['summary'];
		$this->ajaxReturn($simpleBookInfo);
	}

	public function lookComments() {
		$id = I('post.id');
		// echo $id;
		redirect(U("Comments/comments/bookId/$id"), 0, 'go to look Notes');
	}

	public function lookNotes() {
		// $id = I('post.id');
		// $_SESSION['bookid'] = $id;
		$id = I('post.id');
		// echo $id;
		redirect(U("Notes/bookAllNotes/id/$id"), 0, 'go to look Notes');
	}

	public function addNoteIn() {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 3)), 0, "go to login");
		}
		// first identify login or not

		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     31457289999999 ;// 设置附件上传大小
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/NotePhotoes/'; // 设置附件上传根目录
    	$upload->savePath  =     ''; // 设置附件上传（子）目录
    	$upload->callback  = 	  true;
    	$upload->autoSub 	 = 	false;
    // 上传文件 
    	$info   =   $upload->upload();
    	if(!$info) {// 上传错误提示错误信息
        	// $this->error($upload->getError());
        	$error = $upload->getError();
        	if ($error == "没有文件被上传！") {
        		$photo = NULL;
        	}	else {
        			// echo "erro1 ";
        			$this->error($upload->getError);
        	}
    	}else{// 上传成功
	        // $this->success("add photo");
	        $photo = $info['photo']['savename'];
    	}

		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				// $_SESSION['bookid'] = 1;
				// $bookId = 1;
				redirect(U('Notes/index'), 0, 'bookid miss, go back to the index');
		}
		// get bookId

		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$username = getUsername();
		$data['bookid'] = $bookId;
		$data['username'] = $username;
		$data['chapter'] = I('post.chapter');
		$data['page'] = I('post.page');
		$data['note'] = I('post.note');
		$data['photo'] = $photo;
		$data['public'] = I('post.public');
		$data['create_time'] = NOW_TIME;
		// var_dump($data);
		$noteModel = M('notes');
		$noteModel->add($data);
		redirect(U('Books/index'), 0, "add success, go to see my all notes");
	}

	public function addComment() {
		if (noLogin()) {
			redirect(U('User/login', array('error' => 2)), 0, "go to login");
		}
		$comment = D('comments');
		if ($comment->create()) {
			$result = $comment->add();
			if ($result) {
				redirect(U('Books/index'), 0, "success");
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($comment->getError());
		}
	}

	public function zan() {
		$id = I('post.id');
		redirect(U('Comments/zan/id/$id'));
	} 
	public function dianzan($dian=0,$bookid=1) {
		redirect(U('Comments/dianzan/dian/$dian/bookid/$bookid'), 0);
	}
}
 
