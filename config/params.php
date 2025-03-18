<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'services.map4d.key' => '',
    'siteName' => 'Quản lý nông hộ',
    'logoUrl' => '/images/{folder}/logo.png',
    'loginPage' => [
        'logoUrl' => '/images/{folder}/logo.png',
        'backgroundUrl' => '/images/{folder}/background.jpg'
    ],
    'copyright' => 'HCMGIS',
    'userModuleSidebar' => [
        [
            'name' => 'Quản trị hệ thống',
            'items' => [
                [
                    'name' => 'Quản lý người dùng',
                    'icon' => 'fa-users',
                    'url' => '/user/auth-user'
                ],
                [
                    'name' => 'Quản lý nhóm quyền',
                    'icon' => 'fa-th-list',
                    'url' => '/user/auth-group'
                ],
                [
                    'name' => 'Quản lý quyền truy cập',
                    'icon' => 'fa-th-list',
                    'url' => '/user/auth-role'
                ],
                [
                    'name' => 'Quản lý hoạt động',
                    'icon' => 'fa-th-list',
                    'url' => '/user/auth-action'
                ],
            ],
        ]

    ],
    'bsVersion' => '5',
    'bsDependencyEnabled' => false,
];
