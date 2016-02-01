<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_stdapp_domain_model_resource'] = array(
	'ctrl' => $TCA['tx_stdapp_domain_model_resource']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtype, url, path, content, sort, disabled, type, broadcast',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtype, url, path, content, sort, disabled, type, broadcast,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_stdapp_domain_model_resource',
				'foreign_table_where' => 'AND tx_stdapp_domain_model_resource.pid=###CURRENT_PID### AND tx_stdapp_domain_model_resource.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'subtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.subtype',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'url' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'path' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.path',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'content' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.content',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'sort' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.sort',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'disabled' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.disabled',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_stdapp_domain_model_resourcetype',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		/*'customer' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),*/
		'customer' => array(
			'exclude' => 0,
			//'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_stdapp_domain_model_customer',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'broadcast' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource.broadcast',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_stdapp_domain_model_customer',
				'MM' => 'tx_stdapp_resource_customer_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'sys_language',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
	),
);

?>
