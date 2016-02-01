<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_stdapp_domain_model_customersubtype'] = array(
	'ctrl' => $TCA['tx_stdapp_domain_model_customersubtype']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, subtype, url, data, resource_type, customer',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, subtype, url, data, resource_type,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_stdapp_domain_model_customersubtype',
				'foreign_table_where' => 'AND tx_stdapp_domain_model_customersubtype.pid=###CURRENT_PID### AND tx_stdapp_domain_model_customersubtype.sys_language_uid IN (-1,0)',
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
		'subtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype.subtype',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('default', 0),
					array('User', 1),
					array('URL', 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'url' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'data' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype.data',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'resource_type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype.resource_type',
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
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype.customer',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_stdapp_domain_model_customer',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

?>
