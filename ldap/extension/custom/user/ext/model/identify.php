<?php
public function identify($account, $password)
{
	// invalid fields
	if(!$account or !$password ) return false;
$user = false;
	$record = $this->dao->select('*')->from(TABLE_USER)
		->where('account')->eq($account)
		->andWhere('deleted')->eq(0)
		->fetch();
	// no user data, return false
	if(!$record) return false;
	// not ldap auth
	if(empty($record->ldap)){
		return parent::identify($account, $password);
	}

	$ldap = $this->loadModel('ldap');
	$dn = $ldap->getUserDn($this->config->ldap, $account);
	$pass = $ldap->identify($this->config->ldap->host, $this->config->ldap->port, $dn, $password);
	if (0 == strcmp('Success', $pass)) {
		$user = $record;
		$ip   = $this->server->remote_addr;
				$last = $this->server->request_time;
				// 禅道有多处地方需要二次验证密码, 所以需要保存密码的 MD5 在 session 中以供后续验证
				$user->password = md5($password);
				// 判断用户是否来自 ldap
				$user->fromldap = true;
				$this->dao->update(TABLE_USER)->set('visits = visits + 1')->set('ip')->eq($ip)->set('ip')->eq($ip)->set('last')->eq($last)->where('account')->eq($account)->exec();
				$user->last = date(DT_DATETIME1, $user->last);
				
				/* Create cycle todo in login. */
		$todoList = $this->dao->select('*')->from(TABLE_TODO)->where('cycle')->eq(1)->andWhere('account')->eq($user->account)->fetchAll('id');
		$this->loadModel('todo')->createByCycle($todoList);
	}
	return $user;
}