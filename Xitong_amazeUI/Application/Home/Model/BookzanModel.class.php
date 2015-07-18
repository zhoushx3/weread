<?php
namespace Home\Model;
use Think\Model;
class bookzanModel extends Model {
	
	public function getUsername() {
		$user = session('username');
		return $user;
	}

	public  function getBookid() {
		$bookid = session('bookid');
		return $bookid;
	}


	protected $_auto    =   array(
        array('bookid', 'getBookid', 3, 'callback'),
        array('username', 'getUsername', 3, 'callback'),
        array('create_time','time',3,'function')
        );

 }