<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_stdapp_domain_model_customer'] = array(
	'ctrl' => $TCA['tx_stdapp_domain_model_customer']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, identifier, company_name, contact_email, enquiry_email, longitude, latitude, hr_number, txt_color_header, txt_transparency_header, status, resources, messages, subtypes, languages, default_language, portal_user',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, identifier, company_name, contact_email, enquiry_email, longitude, latitude, hr_number, txt_color_header, txt_transparency_header, status, resources, messages, subtypes, languages, default_language,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_stdapp_domain_model_customer',
				'foreign_table_where' => 'AND tx_stdapp_domain_model_customer.pid=###CURRENT_PID### AND tx_stdapp_domain_model_customer.sys_language_uid IN (-1,0)',
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
		'identifier' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.identifier',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'company_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.company_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'contact_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.contact_email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'enquiry_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.enquiry_email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double6'
			),
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double6'
			),
		),
		'hr_number' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.hr_number',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'txt_color_header' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.txt_color_header',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'txt_transparency_header' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.txt_transparency_header',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.status',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'resources' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.resources',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_stdapp_domain_model_resource',
				'foreign_field' => 'customer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'messages' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.messages',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_stdapp_domain_model_message',
				'foreign_field' => 'customer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'subtypes' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.subtypes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_stdapp_domain_model_customersubtype',
				'foreign_field' => 'customer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'typenames' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.typenames',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_stdapp_domain_model_customertypenames',
				'foreign_field' => 'customer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'languages' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.languages',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'MM' => 'tx_stdapp_customer_language_mm',
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
		'default_language' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.default_language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'portal_user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer.portal_user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_field' => 'customer',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

?>
