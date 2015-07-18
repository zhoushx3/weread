<?php
namespace Home\Controller;
use Think\Controller;
class BackGroundController extends Controller {
	public function index() {
		redirect(U('BackGround/backInfo'), 0, "redirect to backInfo");
	}

	public function backInfo() {

		$userModel = M('users');
		$noteModel = M('notes');
		$bookModel = M('books');
		$commentModel = M('comments');

		$noteAllCount = $noteModel->count();
		$commentAllCount = $commentModel->count();
		$bookAllCount = $bookModel->count();
		$userAllCount = $userModel->count();
		


		// $note_today_sql
		$now_time = NOW_TIME;
		$Last1DayCount_sql = "create_time > ('$now_time' - 86400)";
		$Last1WeekCount_sql = "create_time > ('$now_time' -  604800)";
		$Last1MonthCount_sql = "create_time > ('$now_time' -  2592000)";

		$noteCount["day"] = $noteModel->where("$Last1DayCount_sql")->count();
		$noteCount['week'] = $noteModel->where("$Last1WeekCount_sql")->count();
		$noteCount['month'] = $noteModel->where("$Last1MonthCount_sql")->count(); 

		// $bookCount['day'] = $bookModel->where("$Last1DayCount_sql")->count();
		// $bookCount['week'] = $bookModel->where("$Last1WeekCount_sql")->count();
		// $bookCount['month'] = $bookModel->where("$Last1Monthount_sql")->count();

		$commentCount['day'] = $commentModel->where("$Last1DayCount_sql")->count();
		$commentCount['week'] = $commentModel->where("$Last1WeekCount_sql")->count();
		$commentCount['month'] = $commentModel->where("$Last1MonthCount_sql")->count();

		// $userCount['day'] = $userModel->where("$Last1DayCount_sql")->count();
		// $userCount['week'] = $userModel->where("$Last1WeekCount_sql")->count();
		// $userCount['month'] = $userModel->where("$Last1MonthCount_sql")->count();


		for ($ite = 1; $ite < 16; $ite++) {
			$everyDayCount_sql = "create_time > ('$now_time' - ('$ite' * 86400))";
			$noteEveryCount[$ite] =  $noteModel->where("$everyDayCount_sql")->count();
			$commentEveryCount[$ite] =  $noteModel->where("$everyDayCount_sql")->count();
			// $bookEveryCount[$ite] =  $bookModel->where("$everyDayCount_sql")->count();
			// $userEveryCount[$ite] =  $userModel->where("$everyDayCount_sql")->count();

		}


		$this->assign('nowTime', $now_time);

		$this->assign('userCount', $userCount);
		$this->assign('bookCount', $bookCount);
		$this->assign('noteCount', $noteCount);
		$this->assign('commentCount', $commentCount);

		$this->assign('noteCount', $noteCount);
		// $this->assign('bookCount', $bookCount);
		// $this->assign('userCount', $userCount);
		$this->assign('commentCount', $commentCount);

		$this->assign('noteEveryCount', $noteEveryCount);
		$this->assign('commentEveryCount', $commentEveryCount);
		// $this->assign('bookEveryCount', $bookEveryCount);
		// $this->assign('userEveryCount', $userEveryCount);

		$this->display();
	}

}
