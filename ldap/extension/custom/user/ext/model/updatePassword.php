<?php
public function updatePassword($userID)
{
    if( $this->app->user->fromldap == true ){
        dao::$errors['originalPassword'][] = "LDAP 用户不能修改密码";
        return false;
    }
    return parent::updatePassword($userID);
}
