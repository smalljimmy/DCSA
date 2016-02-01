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
class PortalUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser {

	/**
	 * customer
	 *
	 * @var \GK\Stdapp\Domain\Model\Customer
	 * @lazy
	 */
	protected $customer;

	/**
	 * Returns the customer
	 *
	 * @return \GK\Stdapp\Domain\Model\Customer $customer
	 */
	public function getCustomer() {
		return $this->customer;
	}

	/**
	 * Sets the customer
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function setCustomer(\GK\Stdapp\Domain\Model\Customer $customer) {
		$this->customer = $customer;
	}

}
?>
