<?php
namespace Home\Model;
use Think\Model;
class commentsModel extends Model {
	
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
		array('comment', 'require', 'comment必须！'),
	);

	protected $_auto    =   array(
        array('create_time','time',1,'function'),
        array('bookid', 'getBookid', 3, 'callback'),
        array('username', 'getUsername', 3, 'callback')
        );
    // 定义自动完成

 }
