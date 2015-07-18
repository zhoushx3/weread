<?php
namespace Home\Model;
use Think\Model;
class notesModel extends Model {
	
	public function getUsername() {
		$user = session('username');
		return $user;
	}

	public  function getBookid() {
		$bookid = session('bookid');
		return $bookid;
	}

    // 定义自动验证
    public $_validate = array(
		array('note', 'require', 'note必须！'),
		array('chapter', 'require', 'chapter必须！'),
		array('page', 'require', 'page必须！'),
	);

	protected $_auto    =   array(
        array('create_time','time',1,'function'),
        array('bookid', 'getBookid', 3, 'callback'),
        array('username', 'getUsername', 3, 'callback')
        );
    // 定义自动完成

 }
