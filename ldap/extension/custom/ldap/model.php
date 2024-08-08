<?php
class ldapModel extends model
{
    public function identify($host, $dn, $pwd)
    {
        $ret = '';
        $ds = ldap_connect($host);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, $this->config->ldap->version);
            ldap_bind($ds, $dn, $pwd);

            $ret = ldap_error($ds);
            ldap_unbind($ds);
            @ldap_close($ds);
        } else {
            $ret = ldap_error($ds);
        }

        return $ret;
    }

    public function getUserDn($config, $account)
    {
        $ret = null;
        $ds = ldap_connect($config->fullHost);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, empty($config->version) ? $this->config->ldap->version : $config->version);
            ldap_bind($ds, $config->bindDN, $config->bindPWD);
            $filter = "($config->uid=$account)";
            $rlt = ldap_search($ds, $config->baseDN, $filter);
            $count = ldap_count_entries($ds, $rlt);

            if ($count > 0) {
                $data = ldap_get_entries($ds, $rlt);
                $ret = $data[0]['dn'];
                $str = serialize($data);
            }

            ldap_unbind($ds);
            @ldap_close($ds);
        }
        return $ret;
    }

    public function getUsers($config, $accountOne = '')
    {
        $ds = ldap_connect($config->fullHost);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, empty($config->version) ? $this->config->ldap->version : $config->version);
            ldap_bind($ds, $config->bindDN, $config->bindPWD);
            if (empty($accountOne)) {
                $sf = "($config->uid=*)";
            } else {
                $sf = "($config->uid=$accountOne)";
            }
            $attrs = [$config->uid, $config->mail, $config->name, $config->mobile];

            $rlt = ldap_search($ds, $config->baseDN, $sf, $attrs);
            $data = ldap_get_entries($ds, $rlt);
            ldap_unbind($ds);
            @ldap_close($ds);
            return $data;
        }
        return null;
    }

    /**
     * sync2db
     * @param $config LDAP配置
     * @param $accountOne 仅同步一个指定用户
     */
    public function sync2db($config, $accountOne = '')
    {
        $ldapUsers = $this->getUsers($config, $accountOne);
        $user = new stdclass();
        // 保存同步LDAP数据设置的默认权限分组信息
        $group = new stdClass();
        // 统计同步用户数量
        $cnt = 0;
        for ($i = 0; $i < $ldapUsers['count']; $i++) {
            $user->account = $ldapUsers[$i][$config->uid][0];
            $user->email = $ldapUsers[$i][$config->mail][0];
            $user->realname = $ldapUsers[$i][$config->name][0];
            if (!empty($config->mobile) && !empty($ldapUsers[$i][$config->mobile][0])) {
                $user->mobile = $ldapUsers[$i][$config->mobile][0];
            }
            if (!empty($config->phone) && !empty($ldapUsers[$i][$config->phone][0])) {
                $user->phone = $ldapUsers[$i][$config->phone][0];
            }

            $user->ldap = $ldapUsers[$i][$config->uid][0];

            $group->account = $ldapUsers[$i][$config->uid][0];
            //由于默认权限分组标识不在LDAP内存储，所以直接从config中拿。为了兼容zentao自带定时任务所以用了三目运算符
            $group->group = (!empty($config->group) ? $config->group : $this->config->ldap->group);
            // 不是指定要同步的用户，则跳过
            if (!empty($accountOne) && $accountOne != $user->account) {
                continue;
            }

            $account = $this->dao->select('*')->from(TABLE_USER)->where('account')->eq($user->account)->fetch('account');

            if (!empty($group->group)) {
                $gtmp = $this->dao->select('*')->from(TABLE_USERGROUP)->where('account')->eq($user->account)->fetch();
                if (empty($gtmp)) {
                    $this->dao->insert(TABLE_USERGROUP)->data($group)->exec();
                }
            }
            if ($account == $user->account) {
                $this->dao->update(TABLE_USER)->data($user)->where('account')->eq($user->account)->autoCheck()->exec();
            } else {
                $this->dao->insert(TABLE_USER)->data($user)->exec();
            }
            $cnt++;

            // 指定用户同步完成后退出循环
            if (!empty($accountOne)) {
                break;
            }

            if (dao::isError()) {
                echo js::error(dao::getError());
                die(js::reload('parent'));
            }
        }

        return $cnt;
    }
}
