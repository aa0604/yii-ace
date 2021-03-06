# 安装
```
composer require xing/yii-ace
```

配置
-------------------

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'modules' => [
        'admin' => [
            'class' => 'xing\ace\Module',
            
            // Make use of that kind of user
            'user' => 'admin',
            
            // Do not verify permissions
            'verifyAuthority' => false,
            ...
        ]
        ...
    ],
    ...
    'components' => [
        // Front desk user
        'user' => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        
        // Background user
        'admin' => [
            'class' => '\yii\web\User',
            'identityClass' => 'xing\ace\models\Admin',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/default/login'],
            'idParam' => '_adminId',
            'identityCookie' => ['name' => '_admin','httpOnly' => true],
        ],
        
        // This step is not necessary, but you use it outside the module. The controller, view in the module must be added!
        'i18n' => [
            'translations' => [
                'admin' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath'       => '@xing/ace/messages'
                ],
            ],
        ],
                
    ]
];
```

There are also some param configuration, not mandatory, with default values

```php
// Need to configure params.php
return [
    // Background prefix, used to import data, the prefix of the permission name; currently there is no good solution, all use this configuration item
    'admin_rule_prefix' => 'admin', 
    
     // Login navigation menu cache time
    'cacheTime'         => 86400,    
    
    // Universal status                       
    'status'            => ['停用', '启用'],
    
    // Show other information
    'project_open_other' => false,
               
    'projectName'       => '后台管理系统',              
    'projectTitle'      => '后台管理系统',
    'companyName'       => 'xxx 版本所有',  
];
```

About the configuration of permissions
------------------------------------------
```php
return [
    'components' => [
        'modules' => [
            'admin' => [
                'class' => 'xing\ace\Module',
                
                // Make use of that kind of user
                'user' => 'admin'
                ...
            ]
            ...
        ],
        // authority management
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
        ],
        ...
    ],
]
```

## 打开命令行执行下面的命令导入数据
```
php yii migrate --migrationPath=@xing/yii-ace/migrations
```

> 默认用户名: admin 
密码: chenxing
```
// Login address
http://localhost/path/to?index.php?r=admin/default/login
```
