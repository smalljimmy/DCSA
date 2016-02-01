<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Frontend',
	'StandardApp FE'
);
$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . frontend;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .frontend. '.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Api',
	'StandardApp API'
);
$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . api;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .api. '.xml');
if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'GK.' . $_EXTKEY,
		'user',	 // Make module a submodule of 'user'
		'backend',	// Submodule key
		'',						// Position
		array(
			'Customer' => 'list, show, new, create, edit, update, delete',
			'Backend' => 'editMessage, updateMessage, deleteMessage, editBanner, updateBanner, deleteBanner, editMenus, updateMenus',
			'PortalUser' => '',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_backend.xlf',
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','<INCLUDE_TYPOSCRIPT: source=FILE:EXT:stdapp/Configuration/TypoScript/setup.txt>');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'constants','<INCLUDE_TYPOSCRIPT: source=FILE:EXT:stdapp/Configuration/TypoScript/constants.txt>');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'StdAPP');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_customer', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_customer.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_customer');
$TCA['tx_stdapp_domain_model_customer'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customer',
		'label' => 'identifier',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'identifier,company_name,contact_email,enquiry_email,longitude,latitude,txt_color_header,txt_transparency_header,status,resources,messages,subtypes,typenames,languages,default_language,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Customer.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_customer.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_resource', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_resource.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_resource');
$TCA['tx_stdapp_domain_model_resource'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resource',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,subtype,url,path,content,sort,disabled,type,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Resource.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_resource.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_resourcetype', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_resourcetype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_resourcetype');
$TCA['tx_stdapp_domain_model_resourcetype'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_resourcetype',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,action,disabled,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/ResourceType.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_resourcetype.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_message', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_message.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_message');
$TCA['tx_stdapp_domain_model_message'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_message',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,type,subtitle,text,start,end,sort,disabled,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Message.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_message.gif'
	),
);

$tmp_stdapp_columns = array(

	'customer' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_portaluser.customer',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_stdapp_domain_model_customer',
			'minitems' => 0,
			'maxitems' => 1,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_stdapp_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_Stdapp_PortalUser','Tx_Stdapp_PortalUser');

$TCA['fe_users']['types']['Tx_Stdapp_PortalUser']['showitem'] = $TCA['fe_users']['types']['0']['showitem'];
$TCA['fe_users']['types']['Tx_Stdapp_PortalUser']['showitem'] .= ',--div--;LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_portaluser,';
$TCA['fe_users']['types']['Tx_Stdapp_PortalUser']['showitem'] .= 'customer';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_customersubtype', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_customersubtype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_customersubtype');
$TCA['tx_stdapp_domain_model_customersubtype'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customersubtype',
		'label' => 'resource_type',
		'label_alt'  => 'customer',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'subtype,url,data,resource_type,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/CustomerSubtype.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_customersubtype.gif'
	),
);

$tmp_stdapp_columns = array(

	'code' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_language.code',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim,required'
		),
	),
);

t3lib_extMgm::addTCAcolumns('sys_language',$tmp_stdapp_columns);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_subscriber', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_subscriber.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_subscriber');
$TCA['tx_stdapp_domain_model_subscriber'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_subscriber',
		'label' => 'token',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'token,tstamp,customer,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Subscriber.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_subscriber.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_stdapp_domain_model_customertypename', 'EXT:stdapp/Resources/Private/Language/locallang_csh_tx_stdapp_domain_model_customertypename.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_stdapp_domain_model_customertypename');
$TCA['tx_stdapp_domain_model_customertypename'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:stdapp/Resources/Private/Language/locallang_db.xlf:tx_stdapp_domain_model_customertypename',
		'label' => 'name',
		'label_alt' => 'customer',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		//'languageField' => 'sys_language_uid',
		//'transOrigPointerField' => 'l10n_parent',
		//'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,type,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/CustomerTypename.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_stdapp_domain_model_customertypename.gif'
	),
);

?>
