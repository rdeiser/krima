<?php

require_once("../grima-lib.php");

class AdminResetPassword extends GrimaTask {

	function do_task() {
		$user = GrimaUser::GetCurrentUser();
		if ($user['isAdmin']) {
			$username = $this['username'];
			$password = $this['password'];
			$institution = $this['institution'] or $user['institution'];
			GrimaUser::ResetPassword($username, $institution, $password);
			$this->addMessage('success',"Password for $username @ $institution successfully changed.");
		} else {
			throw new Exception("User {$user['username']} (you) is not admin.");
		}
	}
}

AdminResetPassword::RunIt();
