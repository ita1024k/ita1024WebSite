<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'language' => 'zh_cn',
	'name'=>'中国互联网技术联盟',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
                'rights' => array(
        //            'install' => true,
                    'flashSuccessKey'=>'success',
                    'flashErrorKey'=>'error',
                ),
		'article',
		'ticketType',
		'event',
		'information',
		'signForm',
		'user',
		'advertise'
	),

	// application components
	'components'=>array(
                'user'=>array(
                    // enable cookie-based authentication
                    'allowAutoLogin'=>true,
                    'class' => 'RWebUser',
                ),
		'authManager' => array(
				'class' => 'RDbAuthManager',
				'connectionID' => 'db',
				'defaultRoles' => array('authenticated')
		
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		'db'=>array(
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'enableProfiling'=>true,
            'enableParamLogging'=>true,
			'connectionString' => 'mysql:host=localhost;dbname=activity',
			'username' => 'root',
			'password' => 'd2e2cba700',
		),
		'urlManager'=>array(
			'urlFormat'=>'path', 
			'showScriptName'=>false,
			'urlSuffix'=>'.html',//搭车加上.html后缀
			'rules'=>array(
				'sites'=>'site/index',
			),
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		 /* 'log'=>array(
			 'class'=>'CLogRouter',
			 'routes'=>array(
				 array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('*'),
                    'rFilters'=>array('site/captcha','salereport/SnippetStatusAnalyze'),
                    'getFilters'=>array('for'=>'export'),
                    'levels'=>'error,warning',
                ),
			 ),
		 ), */
	),
	'controllerMap' => array(
            'ueditor' => array(
                'class' => 'ext.ueditor.UeditorController',
                'savePath' => 'uploads/',
                'allowFiles' => array(
                    'image' => array(".gif", ".png", ".jpg", ".jpeg", ".bmp"),
                    'file' => array(".rar", ".doc", ".docx", ".zip", ".pdf", ".txt", ".swf", ".wmv"),
                ),
            ),
        ),
    // application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);