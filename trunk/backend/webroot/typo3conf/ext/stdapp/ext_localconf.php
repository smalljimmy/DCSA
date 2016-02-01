<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'GK.' . $_EXTKEY,
	'Frontend',
	array(
		'Customer' => 'list, show, new, create, edit, update, delete, updateSubmitMsg',
		'Resource' => 'list, show, new, create, edit, update, delete',
		'Message' => 'list, show, edit, update, delete',
		'News' => 'list, show, edit, update, delete',
		'Info' => 'list, show, edit, update, delete',
		'Image' => 'list, show, edit, update, delete, moveUp, moveDown',
		'Document' => 'list, show, edit, update, delete, moveUp, moveDown',
		'CustomerSubtype' => 'list, show, new, create, edit, update, delete',
		'Offer' => 'list, show, edit, update, delete, moveUp, moveDown',
	),
	// non-cacheable actions
	array(
		'Customer' => 'edit, update, delete, updateSubmitMsg',
		'Resource' => 'create, update, delete',
		'Message' => 'edit, update, delete',
		'News' => 'edit, update, delete',
		'Info' => 'edit, update, delete',
		'Image' => 'edit, update, delete, moveUp, moveDown',
		'Document' => 'edit, update, delete, moveUp, moveDown',
		'CustomerSubtype' => 'edit, update, delete',
		'Offer' => 'edit, update, delete, moveUp, moveDown',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'GK.' . $_EXTKEY,
	'Api',
	array(
		'Api' => 'config, message, resource, subscribe',
		
	),
	// non-cacheable actions
	array(
		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'GK\Stdapp\Command\WorkerCommandController';

?>
