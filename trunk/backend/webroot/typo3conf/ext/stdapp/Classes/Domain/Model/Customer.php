<?php
namespace GK\Stdapp\Domain\Model;

/***************************************************************
 * $Id: Customer.php 218 2014-03-25 06:56:17Z till $
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
class Customer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * identifier
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $identifier;

	/**
	 * companyName
	 *
	 * @var \string
	 */
	protected $companyName;

	/**
	 * contactEmail
	 *
	 * @var \string
	 */
	protected $contactEmail;

	/**
	 * enquiryEmail
	 *
	 * @var \string
	 */
	protected $enquiryEmail;

	/**
	 * longitude
	 *
	 * @var \float
	 */
	protected $longitude;

	/**
	 * latitude
	 *
	 * @var \float
	 */
	protected $latitude;

	/**
	 * txtColorHeader
	 *
	 * @var \string
	 */
	protected $txtColorHeader;

	/**
	 * txtTransparencyHeader
	 *
	 * @var \integer
	 */
	protected $txtTransparencyHeader;

	/**
	 * status
	 *
	 * @var \integer
	 */
	protected $status;

	/**
	 * hrNumber
	 *
	 * @var \string
	 */
	protected $hrNumber;

	/**
	 * resources
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Resource>
	 * @lazy
	 */
	protected $resources;

	/**
	 * messages
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Message>
	 * @lazy
	 */
	protected $messages;

	/**
	 * subtypes
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerSubtype>
	 * @lazy
	 */
	protected $subtypes;

	/**
	 * typenames
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerTypename>
	 * @lazy
	 */
	protected $typenames;

	/**
	 * languages
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Language>
	 * @lazy
	 */
	protected $languages;

	/**
	 * defaultLanguage
	 *
	 * @var \GK\Stdapp\Domain\Model\Language
	 */
	protected $defaultLanguage;

	/**
	 * portalUser
	 *
	 * @var \GK\Stdapp\Domain\Model\PortalUser
	 */
	protected $portalUser;

	/**
	 * __construct
	 *
	 * @return Customer
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->resources = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->messages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->subtypes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->typenames = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->languages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the identifier
	 *
	 * @return \string $identifier
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * Sets the identifier
	 *
	 * @param \string $identifier
	 * @return void
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}

	/**
	 * Returns the companyName
	 *
	 * @return \string $companyName
	 */
	public function getCompanyName() {
		return $this->companyName;
	}

	/**
	 * Sets the companyName
	 *
	 * @param \string $companyName
	 * @return void
	 */
	public function setCompanyName($companyName) {
		$this->companyName = $companyName;
	}

	/**
	 * Returns the contactEmail
	 *
	 * @return \string $contactEmail
	 */
	public function getContactEmail() {
		return $this->contactEmail;
	}

	/**
	 * Sets the contactEmail
	 *
	 * @param \string $contactEmail
	 * @return void
	 */
	public function setContactEmail($contactEmail) {
		$this->contactEmail = $contactEmail;
	}

	/**
	 * Returns the enquiryEmail
	 *
	 * @return \string $enquiryEmail
	 */
	public function getEnquiryEmail() {
		return $this->enquiryEmail;
	}

	/**
	 * Sets the enquiryEmail
	 *
	 * @param \string $enquiryEmail
	 * @return void
	 */
	public function setEnquiryEmail($enquiryEmail) {
		$this->enquiryEmail = $enquiryEmail;
	}

	/**
	 * Returns the longitude
	 *
	 * @return \float $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param \float $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the latitude
	 *
	 * @return \float $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param \float $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the txtColorHeader
	 *
	 * @return \string $txtColorHeader
	 */
	public function getTxtColorHeader() {
		return $this->txtColorHeader;
	}

	/**
	 * Sets the txtColorHeader
	 *
	 * @param \string $txtColorHeader
	 * @return void
	 */
	public function setTxtColorHeader($txtColorHeader) {
		$this->txtColorHeader = $txtColorHeader;
	}

	/**
	 * Returns the hrNumber
	 *
	 * @return \string $hrNumber
	 */
	public function getHrNumber() {
		return $this->hrNumber;
	}

	/**
	 * Sets the hrNumber
	 *
	 * @param \string $hrNumber
	 * @return void
	 */
	public function setHrNumber($hrNumber) {
		$this->hrNumber = $hrNumber;
	}

	/**
	 * Returns the txtTransparencyHeader
	 *
	 * @return \integer $txtTransparencyHeader
	 */
	public function getTxtTransparencyHeader() {
		return $this->txtTransparencyHeader;
	}

	/**
	 * Sets the txtTransparencyHeader
	 *
	 * @param \integer $txtTransparencyHeader
	 * @return void
	 */
	public function setTxtTransparencyHeader($txtTransparencyHeader) {
		$this->txtTransparencyHeader = $txtTransparencyHeader;
	}

	/**
	 * Returns the status
	 *
	 * @return \integer $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param \integer $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Adds a Resource
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function addResource(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->resources->attach($resource);
	}

	/**
	 * Removes a Resource
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resourceToRemove The Resource to be removed
	 * @return void
	 */
	public function removeResource(\GK\Stdapp\Domain\Model\Resource $resourceToRemove) {
		$this->resources->detach($resourceToRemove);
	}

	/**
	 * Returns the resources
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Resource> $resources
	 */
	public function getResources() {
		return $this->resources;
	}

	/**
	 * Sets the resources
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Resource> $resources
	 * @return void
	 */
	public function setResources(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resources) {
		$this->resources = $resources;
	}

	/**
	 * Adds a Message
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $message
	 * @return void
	 */
	public function addMessage(\GK\Stdapp\Domain\Model\Message $message) {
		$this->messages->attach($message);
	}

	/**
	 * Removes a Message
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $messageToRemove The Message to be removed
	 * @return void
	 */
	public function removeMessage(\GK\Stdapp\Domain\Model\Message $messageToRemove) {
		$this->messages->detach($messageToRemove);
	}

	/**
	 * Returns the messages
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Message> $messages
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * Sets the messages
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Message> $messages
	 * @return void
	 */
	public function setMessages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $messages) {
		$this->messages = $messages;
	}

	/**
	 * Adds a CustomerSubtype
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $subtype
	 * @return void
	 */
	public function addSubtype(\GK\Stdapp\Domain\Model\CustomerSubtype $subtype) {
		$this->subtypes->attach($subtype);
	}

	/**
	 * Removes a CustomerSubtype
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $subtypeToRemove The CustomerSubtype to be removed
	 * @return void
	 */
	public function removeSubtype(\GK\Stdapp\Domain\Model\CustomerSubtype $subtypeToRemove) {
		$this->subtypes->detach($subtypeToRemove);
	}

	/**
	 * Returns the subtypes
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerSubtype> $subtypes
	 */
	public function getSubtypes() {
		return $this->subtypes;
	}

	/**
	 * Sets the subtypes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerSubtype> $subtypes
	 * @return void
	 */
	public function setSubtypes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $subtypes) {
		$this->subtypes = $subtypes;
	}

	/**
	 * Adds a CustomerTypename
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerTypename $typename
	 * @return void
	 */
	public function addTypename(\GK\Stdapp\Domain\Model\CustomerTypename $typename) {
		$this->typenames->attach($typename);
	}

	/**
	 * Removes a CustomerTypename
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerTypename $typenameToRemove The CustomerTypename to be removed
	 * @return void
	 */
	public function removeTypename(\GK\Stdapp\Domain\Model\CustomerTypename $typenameToRemove) {
		$this->typenames->detach($typenameToRemove);
	}

	/**
	 * Returns the typenames
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerTypename> $typenames
	 */
	public function getTypenames() {
		return $this->typenames;
	}

	/**
	 * Sets the typenames
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\CustomerTypename> $typenames
	 * @return void
	 */
	public function setTypenames(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $typenames) {
		$this->typenames = $typenames;
	}

	/**
	 * Adds a Language
	 *
	 * @param \GK\Stdapp\Domain\Model\Language $language
	 * @return void
	 */
	public function addLanguage(\GK\Stdapp\Domain\Model\Language $language) {
		$this->languages->attach($language);
	}

	/**
	 * Removes a Language
	 *
	 * @param \GK\Stdapp\Domain\Model\Language $languageToRemove The Language to be removed
	 * @return void
	 */
	public function removeLanguage(\GK\Stdapp\Domain\Model\Language $languageToRemove) {
		$this->languages->detach($languageToRemove);
	}

	/**
	 * Returns the languages
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Language> $languages
	 */
	public function getLanguages() {
		return $this->languages;
	}

	/**
	 * Sets the languages
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GK\Stdapp\Domain\Model\Language> $languages
	 * @return void
	 */
	public function setLanguages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $languages) {
		$this->languages = $languages;
	}

	/**
	 * Returns the defaultLanguage
	 *
	 * @return \GK\Stdapp\Domain\Model\Language $defaultLanguage
	 */
	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}

	/**
	 * Sets the defaultLanguage
	 *
	 * @param \GK\Stdapp\Domain\Model\Language $defaultLanguage
	 * @return void
	 */
	public function setDefaultLanguage(\GK\Stdapp\Domain\Model\Language $defaultLanguage) {
		$this->defaultLanguage = $defaultLanguage;
	}

	/**
	 * Returns the portalUser
	 *
	 * @return \GK\Stdapp\Domain\Model\PortalUser $portalUser
	 */
	public function getPortalUser() {
		return $this->portalUser;
	}

	/**
	 * Sets the portalUser
	 *
	 * @param \GK\Stdapp\Domain\Model\PortalUser $portalUser
	 * @return void
	 */
	public function setPortalUser(\GK\Stdapp\Domain\Model\PortalUser $portalUser) {
		$this->portalUser = $portalUser;
	}

}
?>
