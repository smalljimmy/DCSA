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
class CustomerSubtype extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * data
	 *
	 * @var \string
	 */
	protected $data;

	/**
	 * resourceType
	 *
	 * @var \GK\Stdapp\Domain\Model\ResourceType
	 */
	protected $resourceType;

	/**
	 * customer
	 *
	 * @var \GK\Stdapp\Domain\Model\Customer
	 */
	protected $customer;

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
	 * Returns the data
	 *
	 * @return \string $data
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Sets the data
	 *
	 * @param \string $data
	 * @return void
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * Returns the resourceType
	 *
	 * @return \GK\Stdapp\Domain\Model\ResourceType $resourceType
	 */
	public function getResourceType() {
		return $this->resourceType;
	}

	/**
	 * Sets the resourceType
	 *
	 * @param \GK\Stdapp\Domain\Model\ResourceType $resourceType
	 * @return void
	 */
	public function setResourceType(\GK\Stdapp\Domain\Model\ResourceType $resourceType) {
		$this->resourceType = $resourceType;
	}

}
?>
