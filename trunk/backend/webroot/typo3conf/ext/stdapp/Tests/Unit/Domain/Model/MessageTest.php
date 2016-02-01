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
 * Test case for class \GK\Stdapp\Domain\Model\Message.
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
class MessageTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \GK\Stdapp\Domain\Model\Message
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \GK\Stdapp\Domain\Model\Message();
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
	public function getTypeReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForIntegerSetsType() { 
		$this->fixture->setType(12);

		$this->assertSame(
			12,
			$this->fixture->getType()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubtitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSubtitleForStringSetsSubtitle() { 
		$this->fixture->setSubtitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSubtitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTextReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTextForStringSetsText() { 
		$this->fixture->setText('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getText()
		);
	}
	
	/**
	 * @test
	 */
	public function getStartReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setStartForDateTimeSetsStart() { }
	
	/**
	 * @test
	 */
	public function getEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEndForDateTimeSetsEnd() { }
	
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
	
}
?>