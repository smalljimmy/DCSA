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
class ResourceType extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

	/**
	 * name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * action
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $action;

	/**
	 * level
	 *
	 * @var integer
	 */
	protected $level;

	/**
	 * disabled
	 *
	 * @var boolean
	 */
	protected $disabled = FALSE;

	/**
	 * isMenu
	 *
	 * @var boolean
	 */
	protected $isMenu = FALSE;

	/**
	 * isFallback
	 *
	 * @var boolean
	 */
	protected $isFallback = FALSE;

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the action
	 *
	 * @return \string $action
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Sets the action
	 *
	 * @param \string $action
	 * @return void
	 */
	public function setAction($action) {
		$this->action = $action;
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
	 * Returns the level
	 *
	 * @return integer $level
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * Sets the level
	 *
	 * @param integer $level
	 * @return void
	 */
	public function setLevel($level) {
		$this->level = $level;
	}

	/**
	 * Returns the isMenu
	 *
	 * @return boolean $isMenu
	 */
	public function getIsMenu() {
		return $this->isMenu;
	}

	/**
	 * Sets the isMenu
	 *
	 * @param boolean $isMenu
	 * @return void
	 */
	public function setIsMenu($isMenu) {
		$this->isMenu = $isMenu;
	}

	/**
	 * Returns the boolean state of isMenu
	 *
	 * @return boolean
	 */
	public function isMenu() {
		return $this->getIsMenu();
	}

	/**
	 * Returns the isFallback
	 *
	 * @return boolean $isFallback
	 */
	public function getIsFallback() {
		return $this->isFallback;
	}

	/**
	 * Sets the isFallback
	 *
	 * @param boolean $isFallback
	 * @return void
	 */
	public function setIsFallback($isFallback) {
		$this->isFallback = $isFallback;
	}

	/**
	 * Returns the boolean state of isFallback
	 *
	 * @return boolean
	 */
	public function isFallback() {
		return $this->getIsFallback();
	}

}
?>
