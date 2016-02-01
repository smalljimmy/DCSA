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
class CustomerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * customerRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository;

	/**
	 * portalUserRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\PortalUserRepository
	 * @inject
	 */
	protected $portalUserRepository;

	/**
	 * resourceRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\ResourceRepository
	 * @inject
	 */
	protected $resourceRepository;

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
		$customers = $this->customerRepository->findAll();
		$this->view->assign('customers', $customers);
	}

	/**
	 * action show
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function showAction(\GK\Stdapp\Domain\Model\Customer $customer) {
		$this->view->assign('customer', $customer);
	}

	/**
	 * action new
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $newCustomer
	 * @dontvalidate $newCustomer
	 * @return void
	 */
	public function newAction(\GK\Stdapp\Domain\Model\Customer $newCustomer = NULL) {
		$this->view->assign('newCustomer', $newCustomer);
	}

	/**
	 * action create
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $newCustomer
	 * @return void
	 */
	public function createAction(\GK\Stdapp\Domain\Model\Customer $newCustomer) {
		$this->customerRepository->add($newCustomer);
		$this->flashMessageContainer->add('Your new Customer was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function editAction(\GK\Stdapp\Domain\Model\Customer $customer = NULL) {
		if ($customer == NULL)
			$customer = $this->portalUser->getCustomer()->_loadRealInstance();
		$this->view->assign('customer', $customer);
		$this->view->assign('feuser', $this->portalUser);
		$this->view->assign('submitMsg', $this->resourceRepository->findByType(10, $customer)->getFirst());
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function updateAction(\GK\Stdapp\Domain\Model\Customer $customer) {
		$this->customerRepository->update($customer);
		$this->flashMessageContainer->add('Your Customer was updated.');
		$this->redirect('edit', NULL, NULL, array('customer' => $customer));
	}

	/**
	 * action delete
	 *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return void
	 */
	public function deleteAction(\GK\Stdapp\Domain\Model\Customer $customer) {
		$this->customerRepository->remove($customer);
		$this->flashMessageContainer->add('Your Customer was removed.');
		$this->redirect('list');
	}

	/**
	 * action updateSubmitMsg
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function updateSubmitMsgAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->resourceRepository->update($resource);
		$this->flashMessageContainer->add('Your Resource was updated.');
		$this->redirect('edit');
	}
}
?>
