<?php

namespace GK\Stdapp\Tests;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \GK\Stdapp\Domain\Model\Customer.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage StdAPP
 *
 * @author Till Wimmer <t.wimmer@bitone.ch>
 */
class CustomerTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \GK\Stdapp\Domain\Model\Customer
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \GK\Stdapp\Domain\Model\Customer();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getIdentifierReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setIdentifierForStringSetsIdentifier() { 
		$this->fixture->setIdentifier('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getIdentifier()
		);
	}
	
	/**
	 * @test
	 */
	public function getCompanyNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCompanyNameForStringSetsCompanyName() { 
		$this->fixture->setCompanyName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCompanyName()
		);
	}
	
	/**
	 * @test
	 */
	public function getContactEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setContactEmailForStringSetsContactEmail() { 
		$this->fixture->setContactEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getContactEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getEnquiryEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setEnquiryEmailForStringSetsEnquiryEmail() { 
		$this->fixture->setEnquiryEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getEnquiryEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getLongitudeReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getLongitude()
		);
	}

	/**
	 * @test
	 */
	public function setLongitudeForFloatSetsLongitude() { 
		$this->fixture->setLongitude(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getLongitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getLatitudeReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getLatitude()
		);
	}

	/**
	 * @test
	 */
	public function setLatitudeForFloatSetsLatitude() { 
		$this->fixture->setLatitude(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getLatitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getTxtColorHeaderReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTxtColorHeaderForStringSetsTxtColorHeader() { 
		$this->fixture->setTxtColorHeader('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTxtColorHeader()
		);
	}
	
	/**
	 * @test
	 */
	public function getTxtTransparencyHeaderReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getTxtTransparencyHeader()
		);
	}

	/**
	 * @test
	 */
	public function setTxtTransparencyHeaderForIntegerSetsTxtTransparencyHeader() { 
		$this->fixture->setTxtTransparencyHeader(12);

		$this->assertSame(
			12,
			$this->fixture->getTxtTransparencyHeader()
		);
	}
	
	/**
	 * @test
	 */
	public function getStatusReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getStatus()
		);
	}

	/**
	 * @test
	 */
	public function setStatusForIntegerSetsStatus() { 
		$this->fixture->setStatus(12);

		$this->assertSame(
			12,
			$this->fixture->getStatus()
		);
	}
	
	/**
	 * @test
	 */
	public function getResourcesReturnsInitialValueForResource() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function setResourcesForObjectStorageContainingResourceSetsResources() { 
		$resource = new \GK\Stdapp\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResources = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResources->attach($resource);
		$this->fixture->setResources($objectStorageHoldingExactlyOneResources);

		$this->assertSame(
			$objectStorageHoldingExactlyOneResources,
			$this->fixture->getResources()
		);
	}
	
	/**
	 * @test
	 */
	public function addResourceToObjectStorageHoldingResources() {
		$resource = new \GK\Stdapp\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResource = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResource->attach($resource);
		$this->fixture->addResource($resource);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneResource,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function removeResourceFromObjectStorageHoldingResources() {
		$resource = new \GK\Stdapp\Domain\Model\Resource();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($resource);
		$localObjectStorage->detach($resource);
		$this->fixture->addResource($resource);
		$this->fixture->removeResource($resource);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getResources()
		);
	}
	
	/**
	 * @test
	 */
	public function getMessagesReturnsInitialValueForMessage() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getMessages()
		);
	}

	/**
	 * @test
	 */
	public function setMessagesForObjectStorageContainingMessageSetsMessages() { 
		$message = new \GK\Stdapp\Domain\Model\Message();
		$objectStorageHoldingExactlyOneMessages = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneMessages->attach($message);
		$this->fixture->setMessages($objectStorageHoldingExactlyOneMessages);

		$this->assertSame(
			$objectStorageHoldingExactlyOneMessages,
			$this->fixture->getMessages()
		);
	}
	
	/**
	 * @test
	 */
	public function addMessageToObjectStorageHoldingMessages() {
		$message = new \GK\Stdapp\Domain\Model\Message();
		$objectStorageHoldingExactlyOneMessage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneMessage->attach($message);
		$this->fixture->addMessage($message);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneMessage,
			$this->fixture->getMessages()
		);
	}

	/**
	 * @test
	 */
	public function removeMessageFromObjectStorageHoldingMessages() {
		$message = new \GK\Stdapp\Domain\Model\Message();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($message);
		$localObjectStorage->detach($message);
		$this->fixture->addMessage($message);
		$this->fixture->removeMessage($message);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getMessages()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubtypesReturnsInitialValueForCustomerSubtype() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getSubtypes()
		);
	}

	/**
	 * @test
	 */
	public function setSubtypesForObjectStorageContainingCustomerSubtypeSetsSubtypes() { 
		$subtype = new \GK\Stdapp\Domain\Model\CustomerSubtype();
		$objectStorageHoldingExactlyOneSubtypes = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneSubtypes->attach($subtype);
		$this->fixture->setSubtypes($objectStorageHoldingExactlyOneSubtypes);

		$this->assertSame(
			$objectStorageHoldingExactlyOneSubtypes,
			$this->fixture->getSubtypes()
		);
	}
	
	/**
	 * @test
	 */
	public function addSubtypeToObjectStorageHoldingSubtypes() {
		$subtype = new \GK\Stdapp\Domain\Model\CustomerSubtype();
		$objectStorageHoldingExactlyOneSubtype = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneSubtype->attach($subtype);
		$this->fixture->addSubtype($subtype);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneSubtype,
			$this->fixture->getSubtypes()
		);
	}

	/**
	 * @test
	 */
	public function removeSubtypeFromObjectStorageHoldingSubtypes() {
		$subtype = new \GK\Stdapp\Domain\Model\CustomerSubtype();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($subtype);
		$localObjectStorage->detach($subtype);
		$this->fixture->addSubtype($subtype);
		$this->fixture->removeSubtype($subtype);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getSubtypes()
		);
	}
	
	/**
	 * @test
	 */
	public function getLanguagesReturnsInitialValueForLanguage() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLanguages()
		);
	}

	/**
	 * @test
	 */
	public function setLanguagesForObjectStorageContainingLanguageSetsLanguages() { 
		$language = new \GK\Stdapp\Domain\Model\Language();
		$objectStorageHoldingExactlyOneLanguages = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneLanguages->attach($language);
		$this->fixture->setLanguages($objectStorageHoldingExactlyOneLanguages);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLanguages,
			$this->fixture->getLanguages()
		);
	}
	
	/**
	 * @test
	 */
	public function addLanguageToObjectStorageHoldingLanguages() {
		$language = new \GK\Stdapp\Domain\Model\Language();
		$objectStorageHoldingExactlyOneLanguage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneLanguage->attach($language);
		$this->fixture->addLanguage($language);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLanguage,
			$this->fixture->getLanguages()
		);
	}

	/**
	 * @test
	 */
	public function removeLanguageFromObjectStorageHoldingLanguages() {
		$language = new \GK\Stdapp\Domain\Model\Language();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($language);
		$localObjectStorage->detach($language);
		$this->fixture->addLanguage($language);
		$this->fixture->removeLanguage($language);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLanguages()
		);
	}
	
	/**
	 * @test
	 */
	public function getDefaultLanguageReturnsInitialValueForLanguage() { }

	/**
	 * @test
	 */
	public function setDefaultLanguageForLanguageSetsDefaultLanguage() { }
	
}
?>