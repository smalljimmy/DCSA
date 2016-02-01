<?php
namespace GK\Stdapp\Controller;

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
class CustomerSubtypeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * customerRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\CustomerSubtypeRepository
	 * @inject
	 */
	protected $customerSubtypeRepository;

	/**
	 * portalUserRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\PortalUserRepository
	 * @inject
	 */
	protected $portalUserRepository;

	/**
	 * portalUser
	 *
	 * @var \GK\Stdapp\Domain\Model\PortalUser
	 */
	protected $portalUser;

	/**
	 *
	 * @return \GK\Stdapp\Domain\Repository\PortalUserRepository
	 */
	protected function getPortalUser() {
		return $this->portalUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
	}

	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->portalUser = $this->getPortalUser();
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$customerSubtypes = $this->customerSubtypeRepository->findAll();
		$this->view->assign('customerSubtypes', $customerSubtypes);
	}

	/**
	 * action show
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype
	 * @return void
	 */
	public function showAction(\GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype) {
		$this->view->assign('customerSubtype', $customerSubtype);
	}

	/**
	 * action new
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $newCustomerSubtype
	 * @dontvalidate $newCustomer
	 * @return void
	 */
	public function newAction(\GK\Stdapp\Domain\Model\CustomerSubtype $newCustomerSubtype = NULL) {
		$this->view->assign('newCustomerSubtype', $newCustomerSubtype);
	}

	/**
	 * action create
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $newCustomerSubtype
	 * @return void
	 */
	public function createAction(\GK\Stdapp\Domain\Model\CustomerSubtype $newCustomerSubtype) {
		$this->customerSubtypeRepository->add($newCustomerSubtype);
		$this->flashMessageContainer->add('Your new CustomerSubtype was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $editCustomerSubtype
	 * @return void
	 */
	public function editAction(\GK\Stdapp\Domain\Model\CustomerSubtype $editCustomerSubtype = NULL) {
		$customerSubtypes = $this->customerSubtypeRepository->findByCustomer($this->portalUser->getCustomer()->_loadRealInstance());
		$this->view->assign('customerSubtypes', $customerSubtypes);
		$this->view->assign('editCustomerSubtype', $editCustomerSubtype);
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype
	 * @return void
	 */
	public function updateAction(\GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype) {
		if (($url = trim($customerSubtype->getUrl())) && !preg_match('/^https?:/', $url))
			$customerSubtype->setUrl('http://'.$url);
		$this->customerSubtypeRepository->update($customerSubtype);
		$this->flashMessageContainer->add('Your CustomerSubtype was updated.');
		$this->redirect('edit');
	}

	/**
	 * action delete
	 *
	 * @param \GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype
	 * @return void
	 */
	public function deleteAction(\GK\Stdapp\Domain\Model\CustomerSubtype $customerSubtype) {
		$this->customerSubtypeRepository->remove($customerSubtype);
		$this->flashMessageContainer->add('Your CustomerSubtype was removed.');
		$this->redirect('list');
	}

}
?>
