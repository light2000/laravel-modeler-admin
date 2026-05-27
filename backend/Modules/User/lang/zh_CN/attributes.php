<?php

return [
    'user' => [
        'username' => '账号',
        'password' => '密码',
        'nickname' => '昵称',
        'email'=> '邮箱',
        'phone'=> '手机号',
        'avatar' => '头像',
        'status' => '状态',
        'last_login_at'=> '最后登录时间',
    ],
    'administrator' => [
        'account' => '账号',
        'password' => '密码',
        'nickname' => '昵称',
        'avatar' => '头像',
        'status' => '状态',
        'role_ids' => '角色',
    ],
    'role' => [
        'name' => '角色名称',
        'guard_name' => 'GUARD',
    ],
    'permission' => [
        'name' => '权限标识',
        'guard_name' => 'GUARD',
    ],
    'token' => [
        'tokenable_id' => '用户ID',
        'tokenable_type' => '用户类型',
        'name' => 'Token名称',
        'token' => 'Token',
        'abilities' => 'Token能力',
        'last_used_at' => '最后使用时间',
        'expires_at' => '过期时间',
    ],
];
