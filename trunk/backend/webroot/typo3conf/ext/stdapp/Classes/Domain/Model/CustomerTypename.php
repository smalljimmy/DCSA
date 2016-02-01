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
class CustomerTypename extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;

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
	 * sysLanguageUid
	 *
	 * @var \GK\Stdapp\Domain\Model\Language
	 */
	protected $sysLanguageUid;

	/**
	 * l10nParent
	 *
	 * @var \GK\Stdapp\Domain\Model\CustomerTypename
	 */
	protected $l10nParent;

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
	 * @return \GK\Stdapp\Domain\Model\CustomerTypename $sysLanguageUid
	 */
	public function getL10nParent() {
		return $this->l10nParent;
	}

	/**
	 * Sets the l10nParent
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerTypename $l10nParent
	 * @return void
	 */
	public function setL10nParent(\GK\Stdapp\Domain\Model\CustomerTypename $l10nParent) {
		$this->l10nParent = $l10nParent;
	}


}
?>
