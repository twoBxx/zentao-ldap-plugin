<?php
class ldap extends control
{
    public $referer;

    /**
     * Construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->locate(inlink('setting'));
    }

    public function setting()
    {
        $groups = $this->dao->select('id, name, role')->from(TABLE_GROUP)->fetchAll();
        $groupList = array('' => '');
        foreach ($groups as $group) {
            $groupList[$group->id] = $group->name;
        }

        $this->view->title = $this->lang->ldap->common . $this->lang->colon . $this->lang->ldap->setting;
        $this->view->position[] = html::a(inlink('index'), $this->lang->ldap->common);
        $this->view->position[] = $this->lang->ldap->setting;

        $this->view->group = $this->config->ldap->group; // 用于显示权限分组选项，供用户自行选择
        $this->view->groupList = $groupList;

        $this->display();
    }

    public function save()
    {
        if (!empty($_POST)) {
            $this->config->ldap->turnon = $this->post->turnon;
            $this->config->ldap->host = $this->post->host;
            $this->config->ldap->port = $this->post->port;
            $this->config->ldap->ssl = $this->lang->ldap->sslList[$this->post->ssl];
            $fullHost = $this->config->ldap->ssl . $this->post->host . ':' . $this->post->port;
            $this->config->ldap->fullHost = $fullHost;
            $this->config->ldap->version = $this->post->version;
            $this->config->ldap->bindDN = $this->post->bindDN;
            $this->config->ldap->bindPWD = $this->post->bindPWD;
            $this->config->ldap->baseDN = $this->post->baseDN;
            $this->config->ldap->uid = $this->post->uid;
            $this->config->ldap->mail = $this->post->mail;
            $this->config->ldap->name = $this->post->name;
            $this->config->ldap->mobile = $this->post->mobile;
            $this->config->ldap->phone = $this->post->phone;
            $this->config->ldap->group = $this->post->group;

            // 覆盖默认配置文件
            $ldapConfig = "<?php \n"
                . "\$config->ldap = new stdclass();\n"
                . "\$config->ldap->turnon = '{$this->post->turnon}';\n"
                . "\$config->ldap->host = '{$this->post->host}';\n"
                . "\$config->ldap->port = '{$this->post->port}';\n"
                . "\$config->ldap->ssl = '{$this->post->ssl}';\n"
                . "\$config->ldap->fullHost = '{$fullHost}';\n"
                . "\$config->ldap->version = '{$this->post->version}';\n"
                . "\$config->ldap->bindDN = '{$this->post->bindDN}';\n"
                . "\$config->ldap->bindPWD = '{$this->post->bindPWD}';\n"
                . "\$config->ldap->baseDN =  '{$this->post->baseDN}';\n"
                . "\$config->ldap->uid = '{$this->post->uid}';\n"
                . "\$config->ldap->mail = '{$this->post->mail}';\n"
                . "\$config->ldap->name = '{$this->post->name}';\n"
                . "\$config->ldap->mobile = '{$this->post->mobile}';\n"
                . "\$config->ldap->phone = '{$this->post->phone}';\n"
                . "\$config->ldap->group = '{$this->post->group}';\n";

            $file = fopen("config.php", "w") or die("Unable to open config.php for write!");
            fwrite($file, $ldapConfig);
            fclose($file);

            $this->locate(inlink('setting'));
            echo "alert('done.')";
        }
    }

    public function test()
    {
        $fullHost = $this->lang->ldap->sslList[$this->post->ssl] . $this->post->host . ':' . $this->post->port;
        echo $this->ldap->identify($fullHost, $this->post->dn, $this->post->pwd);
    }

    public function sync()
    {
        $users = $this->ldap->sync2db($this->config->ldap);
        echo $users;
    }

    public function identify($user, $pwd)
    {
        $ret = false;
        $account = $this->config->ldap->uid . '=' . $user . ',' . $this->config->ldap->baseDN;
        if (0 == strcmp('Success', $this->ldap->identify($this->config->ldap->fullHost, $account, $pwd))) {
            $ret = true;
        }

        echo $ret;
    }
}
