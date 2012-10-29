<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'language'=>'zh_cn',
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'lovelp',
       		'ipFilters' => array('127.0.0.1','192.168.138.26','::1'),
        ),
    ),
    'name' => '测试网站',
    'import'=>array(
        'application.models.*',
   		'application.forms.*',
   		'application.common.classes.*',
   		'application.common.config.*',
   		'application.common.service.*',
   		'application.components.*',
    ),
    'defaultController'=>'shop',
    'components'=>array(
        'user'=>array(
            'allowAutoLogin' => true,
            'loginUrl' => array('login/')
        ),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=mshop',
            'emulatePrepare'   => true,
            'username'          => 'postfix',
            'password'          => 'postfix',
            'charset'           => 'utf8',
        ),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules' => array(
                'login/' => 'accounts/login',
                'register/' => 'accounts/register',
                'logout/' => 'accounts/logout',
                'registerSuccess' => 'accounts/registerSuccess',
            )
        ),
    ),
    'params'=>require(dirname(__FILE__).'/params.php'),
);