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
 * Test case for class \GK\Stdapp\Domain\Model\Resource.
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
class ResourceTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \GK\Stdapp\Domain\Model\Resource
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \GK\Stdapp\Domain\Model\Resource();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubtypeReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getSubtype()
		);
	}

	/**
	 * @test
	 */
	public function setSubtypeForIntegerSetsSubtype() { 
		$this->fixture->setSubtype(12);

		$this->assertSame(
			12,
			$this->fixture->getSubtype()
		);
	}
	
	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl() { 
		$this->fixture->setUrl('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getUrl()
		);
	}
	
	/**
	 * @test
	 */
	public function getPathReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPathForStringSetsPath() { 
		$this->fixture->setPath('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPath()
		);
	}
	
	/**
	 * @test
	 */
	public function getContentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setContentForStringSetsContent() { 
		$this->fixture->setContent('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getContent()
		);
	}
	
	/**
	 * @test
	 */
	public function getSortReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getSort()
		);
	}

	/**
	 * @test
	 */
	public function setSortForIntegerSetsSort() { 
		$this->fixture->setSort(12);

		$this->assertSame(
			12,
			$this->fixture->getSort()
		);
	}
	
	/**
	 * @test
	 */
	public function getDisabledReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setDisabledForOoleanSetsDisabled() { }
	
	/**
	 * @test
	 */
	public function getTypeReturnsInitialValueForResourceType() { }

	/**
	 * @test
	 */
	public function setTypeForResourceTypeSetsType() { }
	
}
?>