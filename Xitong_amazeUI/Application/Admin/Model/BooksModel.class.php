<?php
namespace Admin\Model;
use Think\Model;
class notesModel extends Model {
	

    // 定义自动验证
    public $_validate = array(
		array('bookname', 'require', 'bookname必须！'),
		array('press', 'require', 'press必须！'),
		array('ISBN', 'require', 'ISBN必须！'),
		array('author', 'require', 'author必须！'),
		array('summary', 'require', 'summary必须！'),
	);

	protected $_auto    =   array(
        array('create_time','time',1,'function'),
        );
    // 定义自动完成

 }
