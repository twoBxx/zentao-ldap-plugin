
### 简介

**注意: 有问题请开 issue , 请勿发送邮件要求我为你提供私人服务**

这个插件是在 “[禅道开源版LDAP插件](https://github.com/TigerLau1985/ZenTao_LDAP)” 上基础进行的修正，使其可以在 禅道开源版 12.3 上正常运行

测试的 zentao 版本 https://github.com/shynome/zentao-docker , 更新的版本可能不行, 如果有 pr 修复的话会接受的

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
  - 问：开启这个插件后无法登录本地账户
  - 答：本地账户需要加上 `$` 前缀来登录
- 
  - 问: 连接是 ok 但是同步了 0 位用户
  - 答: 这种情况的话, 保存设置后再点击手动同步就可以正常同步(<del>原来的版本就有的问题懒得改了</del>) 
    <br/>注意: 所有的字段都是需要填写的
