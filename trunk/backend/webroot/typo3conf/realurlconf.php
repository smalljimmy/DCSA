<?php 
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
	'init' => array(
		'enableCHashCache' => '1',
		'appendMissingSlash' => 'ifNotFile,redirect',
		'adminJumpToBackend' => '1',
		'enableUrlDecodeCache' => '1',
		'enableUrlEncodeCache' => '1',
		'emptyUrlReturnValue' => '/',
		'respectSimulateStaticURLs' => '1',
		'disableErrorLog' => '1',
	),
	'pagePath' => array(
		'type' => 'user',
		'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
		'spaceCharacter' => '-',
		'segTitleFieldList' => 'tx_realurl_pathsegment,title',
		'languageGetVar' => 'L',
		'rootpage_id' => '11',
//		'excludePageIds' => '6,30,31,59,32,41,33,34,35',
	),
	'fixedPostVars' => array(
		'api' => array (
			array(
				'GETvar' => 'tx_stdapp_api[identifier]',
			),
			array(
				'GETvar' => 'tx_stdapp_api[type]',
			),
			array(
				'GETvar' => 'L',
				'valueMap' => array(
					'de' => '0',
					'it' => '2',
					'fr' => '1',
					'en' => '4',
				),
				'optional' => TRUE,
			),
			array(
				 'GETvar' => 'tx_stdapp_api[uid]',
				 'optional' => TRUE,
			),
		),
		'15' => 'api',
		'16' => 'api',
		'14' => array(
			array(
				'GETvar' => 'tx_stdapp_api[identifier]',
			),
			array(
				'GETvar' => 'tx_stdapp_api[token]',
				'optional' => TRUE,
			),
		),
		'19'  => array(
			array(
				'GETvar' => 'tx_stdapp_api[identifier]',
			),
			array(
				'GETvar' => 'tx_stdapp_api[token]',
			),
			array(
				'GETvar' => 'tx_stdapp_api[language]',
				'optional' => TRUE,
			),
		),
	)
);
?>
