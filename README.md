# 简介

这个插件是在 “[禅道开源版LDAP插件](https://github.com/TigerLau1985/ZenTao_LDAP)” 上基础进行的修正，使其可以在 禅道开源版 18.x 上正常运行

### 配置示例

|  选项   | 示例值  |
|  ----  | ----  |
| LDAP服务器  | 	ldap://192.168.32.203:389 |
| 协议版本  | 3 |
| BindDN  | cn=admin,dc=mylitboy,dc=com |
| BindDN 密码  | ou=users,dc=mylitboy,dc=com |
| Search filter  | (objectClass=person) |
| 账号字段  | 	uid |
| EMail 字段  | 	mail |
| 姓名字段  | 	cn |

> 参考 https://blog.mylitboy.com/article/operation/zentao-config-ldap.html

### 从钉钉同步信息到ldap

> 参考 https://github.com/anjia0532/virtual-ldap

### FAQ

- 
  - Q：开启这个插件后无法登录本地账户
  - A：本地账户需要加上 `$` 前缀来登录
- 
  - Q: 连接是 ok 但是同步了 0 位用户
  - A: 这种情况的话, 保存设置后再点击手动同步就可以正常同步
    <br/>注意: 所有的字段都是需要填写的