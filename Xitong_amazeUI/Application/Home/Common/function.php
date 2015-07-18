<?php
function getUsername() {
	$user = session('username');
	return $user;
}

function getBookid() {
	$bookid = session('bookid');
	return $bookid;
}

function getBookzan() {
     $bookzan = array(
     	'bookid ' => getBookid(),
     	'username' => getUsername() 
     	);
     return $bookzan;   
}

function noLogin() {
	$user = getUsername();
	if (isset($user)) {
		return False;
	}	else {
		return True;
	}



function logout() {
	session('username', null);
	session('bookid', null);
	return True;
}

}
?>