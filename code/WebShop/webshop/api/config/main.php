<?php
$api = dirname(dirname(__FILE__));
$frontend = dirname($api);
Yii::setPathOfAlias('api', $api);
Yii::setPathOfAlias('frontend', $frontend);
return array(
		'basePath' => $frontend,
        'name' => '测试网站',
		'controllerPath' => $api.'/controllers',
        'language'=>'zh_cn',
		'defaultController'=>'shop',
		'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=mshop',
				'emulatePrepare'   => true,
				'username'          => 'postfix',
				'password'          => 'postfix',
				'charset'           => 'utf8',
			),
		),
		'import' => array(
				'frontend.models.*',
				'frontend.common.classes.*',
				'frontend.common.service.*',
                'frontend.common.config.*',
                'frontend.components.*',
                'frontend.formModels.*',
				'api.class.*',
		),
    'params'=>require(dirname(__FILE__).'/params.php'),
		
);