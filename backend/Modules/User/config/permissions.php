<?php

return [
    'key' => "user",
    'label' =>  __("user::permissions.user"),
    'children' => [
        [
            'key' => "user.user",
            'label' => __("user::permissions.user.user"),
            'actions' => [
                ['key' => 'user.user.store', 'label' => __("user::permissions.user.user.store")],
                ['key' => 'user.user.update', 'label' => __("user::permissions.user.user.update")],
                ['key' => 'user.user.index', 'label' => __("user::permissions.user.user.index")],
                ['key' => 'user.user.show', 'label' => __("user::permissions.user.user.show")],
                ['key' => 'user.user.destroy', 'label' => __("user::permissions.user.user.destroy")],
            ],
        ],
        [
            'key' => "user.administrator",
            'label' => __("user::permissions.user.administrator"),
            'actions' => [
                ['key' => 'user.administrator.store', 'label' => __("user::permissions.user.administrator.store")],
                ['key' => 'user.administrator.update', 'label' => __("user::permissions.user.administrator.update")],
                ['key' => 'user.administrator.index', 'label' => __("user::permissions.user.administrator.index")],
                ['key' => 'user.administrator.show', 'label' => __("user::permissions.user.administrator.show")],
                ['key' => 'user.administrator.destroy', 'label' => __("user::permissions.user.administrator.destroy")],
            ],
        ],
        [
            'key' => "user.role",
            'label' => __("user::permissions.user.role"),
            'actions' => [
                ['key' => 'user.role.store', 'label' => __("user::permissions.user.role.store")],
                ['key' => 'user.role.update', 'label' => __("user::permissions.user.role.update")],
                ['key' => 'user.role.index', 'label' => __("user::permissions.user.role.index")],
                ['key' => 'user.role.show', 'label' => __("user::permissions.user.role.show")],
                ['key' => 'user.role.destroy', 'label' => __("user::permissions.user.role.destroy")],
                ['key' => 'user.role.assign_permissions', 'label' => __("user::permissions.user.role.assign_permissions")],
            ],
        ],
    ],
];
