<?php
namespace GK\Stdapp\Domain\Model;

/***************************************************************
 * $Id: Message.php 215 2014-03-21 06:20:25Z till $
 * --------------------------------------------------------------
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
class Message extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * type
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * subtitle
	 *
	 * @var \string
	 */
	protected $subtitle;

	/**
	 * text
	 *
	 * @var \string
	 */
	protected $text;

	/**
	 * start
	 *
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $start;

	/**
	 * end
	 *
	 * @var \DateTime
	 */
	protected $end;

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
         * customer
         *
         * @var \GK\Stdapp\Domain\Model\Customer
	 * @lazy
         */
        protected $customer;

	/**
	 * sysLanguageUid
	 *
	 * @var \GK\Stdapp\Domain\Model\Language
	 */
	protected $sysLanguageUid;

	/**
	 * l10nParent
	 *
	 * @var \GK\Stdapp\Domain\Model\Message
	 */
	protected $l10nParent;

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
	 * Returns the type
	 *
	 * @return \integer $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param \integer $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the subtitle
	 *
	 * @return \string $subtitle
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * Sets the subtitle
	 *
	 * @param \string $subtitle
	 * @return void
	 */
	public function setSubtitle($subtitle) {
		$this->subtitle = $subtitle;
	}

	/**
	 * Returns the text
	 *
	 * @return \string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets the text
	 *
	 * @param \string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * Returns the start
	 *
	 * @return \DateTime $start
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Sets the start
	 *
	 * @param \DateTime $start
	 * @return void
	 */
	public function setStart($start) {
		$this->start = $start;
	}

	/**
	 * Returns the end
	 *
	 * @return \DateTime $end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Sets the end
	 *
	 * @param \DateTime $end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
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
	 * @return \GK\Stdapp\Domain\Model\Message $sysLanguageUid
	 */
	public function getL10nParent() {
		return $this->l10nParent;
	}

	/**
	 * Sets the l10nParent
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $l10nParent
	 * @return void
	 */
	public function setL10nParent(\GK\Stdapp\Domain\Model\Message $l10nParent) {
		$this->l10nParent = $l10nParent;
	}

	/**
	 * Returns the Customer
	 *
	 * @return \GK\Stdapp\Domain\Model\Customer $customer
	 */
	public function getCustomer() {
		return $this->customer;
	}

	/**
	 * Sets the Customer
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function setCustomer($customer) {
		$this->customer = $customer;
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
	public function setBraodcast(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $broadcast) {
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
	 * Returns true if Msg is outdated
	 *
	 * @return boolean
	 */
	public function getIsOutdated() {
		$now = new \DateTime();

		if( ($this->getEnd() != NULL) && ($this->getEnd() <= $now) )
			return true;

		return false;
	}

	/**
	 * Returns true if Msg is active
	 *
	 * @return boolean
	 */
	public function getIsActive() {
		$now = new \DateTime();

		if ( ($this->getStart() <= $now ) && (($this->getEnd() == NULL) || ( $now < $this->getEnd())) )
			return true;

		return false;
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
		$this->setBraodcast($newStorage);
	}


}
?>
