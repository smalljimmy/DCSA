<?php
namespace GK\Stdapp\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Till Wimmer <t.wimmer@bitone.ch>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package stdapp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Resource extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * subtype
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $subtype;

	/**
	 * url
	 *
	 * @var \string
	 */
	protected $url;

	/**
	 * path
	 *
	 * @var \string
	 */
	protected $path;

	/**
	 * content
	 *
	 * @var \string
	 */
	protected $content;

	/**
	 * sort
	 *
	 * @var \integer
	 */
	protected $sort;

	/**
	 * disabled
	 *
	 * @var boolean
	 */
	protected $disabled = FALSE;

	/**
	 * type
	 *
	 * @var \GK\Stdapp\Domain\Model\ResourceType
	 */
	protected $type;

	/**
	 * customer
	 *
	 * @var \GK\Stdapp\Domain\Model\Customer
	 */
	protected $customer;

	/**
	 * broadcast
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Customer>
	 * @lazy
	 */
	protected $broadcast;

	/**
	 * broadcastarr
	 *
	 * @var array
	 */
	protected $broadcastarr;

	/**
	 * sysLanguageUid
	 *
	 * @var \GK\Stdapp\Domain\Model\Language
	 */
	protected $sysLanguageUid;

	/**
	 * l10nParent
	 *
	 * @var \GK\Stdapp\Domain\Model\Resource
	 */
	protected $l10nParent;


	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the subtype
	 *
	 * @return \integer $subtype
	 */
	public function getSubtype() {
		return $this->subtype;
	}

	/**
	 * Sets the subtype
	 *
	 * @param \integer $subtype
	 * @return void
	 */
	public function setSubtype($subtype) {
		$this->subtype = $subtype;
	}

	/**
	 * Returns the url
	 *
	 * @return \string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param \string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the path
	 *
	 * @return \string $path
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Sets the path
	 *
	 * @param \string $path
	 * @return void
	 */
	public function setPath($path) {
		$this->path = $path;
	}

	/**
	 * Returns the content
	 *
	 * @return \string $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the content
	 *
	 * @param \string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Returns the sort
	 *
	 * @return \integer $sort
	 */
	public function getSort() {
		return $this->sort;
	}

	/**
	 * Sets the sort
	 *
	 * @param \integer $sort
	 * @return void
	 */
	public function setSort($sort) {
		$this->sort = $sort;
	}

	/**
	 * Returns the disabled
	 *
	 * @return boolean $disabled
	 */
	public function getDisabled() {
		return $this->disabled;
	}

	/**
	 * Sets the disabled
	 *
	 * @param boolean $disabled
	 * @return void
	 */
	public function setDisabled($disabled) {
		$this->disabled = $disabled;
	}

	/**
	 * Returns the boolean state of disabled
	 *
	 * @return boolean
	 */
	public function isDisabled() {
		return $this->getDisabled();
	}

	/**
	 * Returns the type
	 *
	 * @return \GK\Stdapp\Domain\Model\ResourceType $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param \GK\Stdapp\Domain\Model\ResourceType $type
	 * @return void
	 */
	public function setType(\GK\Stdapp\Domain\Model\ResourceType $type) {
		$this->type = $type;
	}

	/**
	 * Returns the sysLanguageUid
	 *
	 * @return \GK\Stdapp\Domain\Model\Language $sysLanguageUid
	 */
	public function getSysLanguageUid() {
		return $this->sysLanguageUid;
	}

	/**
	 * Sets the sysLanguageUid
	 *
	 * @param \GK\Stdapp\Domain\Model\Language $sysLanguageUid
	 * @return void
	 */
	public function setSysLanguageUid(\GK\Stdapp\Domain\Model\Language $sysLanguageUid) {
		$this->sysLanguageUid = $sysLanguageUid;
	}

	/**
	 * Returns the l10nParent
	 *
	 * @return \GK\Stdapp\Domain\Model\Resource $sysLanguageUid
	 */
	public function getL10nParent() {
		return $this->l10nParent;
	}

	/**
	 * Sets the l10nParent
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $l10nParent
	 * @return void
	 */
	public function setL10nParent(\GK\Stdapp\Domain\Model\Resource $l10nParent) {
		$this->l10nParent = $l10nParent;
	}

	/**
	 * Adds a Customer
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function addBroadcast(\GK\Stdapp\Domain\Model\Customer $customer) {
		$this->broadcast->attach($customer);
	}

	/**
	 * Removes a Customer
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customerToRemove The Customer to be removed
	 * @return void
	 */
	public function removeBroadcast(\GK\Stdapp\Domain\Model\Customer $customerToRemove) {
		$this->broadcast->detach($customerToRemove);
	}

	/**
	 * Returns the broadcast
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Customer> $broadcast
	 */
	public function getBroadcast() {
		return $this->broadcast;
	}

	/**
	 * Sets the broadcast
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Customer> $broadcast
	 * @return void
	 */
	public function setBroadcast(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $broadcast) {
		$this->broadcast = $broadcast;
	}

	/**
	 * Returns the broadcastarr
	 *
	 * @return array
	 */
	public function getBroadcastarr() {
		$broadcastarr = array();
		foreach ($this->broadcast as $bcast)
			$broadcastarr[] = $bcast->getUid();
		return $broadcastarr;
	}

	/**
	 * Sets the broadcastarr
	 *
	 * @param array broadcastarr
	 * @return void
	 */
	public function setBroadcastarr($broadcastarr) {
		$customerRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('GK\Stdapp\Domain\Repository\CustomerRepository');
		$newStorage =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\ObjectStorage');
		foreach($broadcastarr as $uid)
			$newStorage->attach($customerRepository->findByUid($uid));
		$this->setBroadcast($newStorage);
	}


}
?>
