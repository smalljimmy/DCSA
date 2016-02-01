<?php
namespace GK\Stdapp\Controller;

/***************************************************************
 * $Id: MessageAbstractController.php 18 2013-09-15 13:48:55Z till $
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
class MessageAbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * messageRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\MessageRepository
	 * @inject
	 */
	protected $messageRepository;

	/**
	 * portalUserRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\PortalUserRepository
	 * @inject
	 */
	protected $portalUserRepository;

        /**
         * customerRepository
         *
         * @var \GK\Stdapp\Domain\Repository\CustomerRepository
         * @inject
         */
        protected $customerRepository;

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
	 * type
	 *
	 * @var integer
	 */
	protected $type;

	/**
	 *
	 * @param integer $type
	 * @return void
	 */
	protected function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->portalUser = $this->getPortalUser();

		if (isset($this->arguments['message'])) {
			$this->arguments['message']
				->getPropertyMappingConfiguration()
				->forProperty('start')
				->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');
		}

		if (isset($this->arguments['message'])) {
                        $this->arguments['message']
                                ->getPropertyMappingConfiguration()
                                ->forProperty('end')
                                ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');
                }

	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$messages = $this->messageRepository->findByType($this->type, $this->portalUser->getCustomer()->_loadRealInstance());
		$this->view->assign('messages', $messages);
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $editMessage
	 * @return void
	 */
	public function editAction(\GK\Stdapp\Domain\Model\Message $editMessage = NULL) {
                $messages = $this->messageRepository->findByType($this->type, $this->portalUser->getCustomer()->_loadRealInstance());
                $this->view->assign('messages', $messages);
		$this->view->assign('editMessage', $editMessage);
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $message
	 * @return void
	 */
	public function updateAction(\GK\Stdapp\Domain\Model\Message $message) {
		if ($message->getUid() > 0) {
			$this->messageRepository->update($message);
			$this->flashMessageContainer->add('Your Message was updated.');
		}
		else {
			$customer = $this->portalUser->getCustomer()->_loadRealInstance();
			$customer->addMessage($message);
			$this->customerRepository->update($customer);
			$this->flashMessageContainer->add('Your Message was added.');
		}

		$this->redirect('edit');
	}

        /**
         * action delete
         *
         * @param \GK\Stdapp\Domain\Model\Message $message
         * @return void
         */
        public function deleteAction(\GK\Stdapp\Domain\Model\Message $message) {
                $customer = $this->portalUser->getCustomer()->_loadRealInstance();
                $customer->removeMessage($message);
                $this->customerRepository->update($customer);

                $this->flashMessageContainer->add('Your Message was deleted.');
                $this->redirect('edit');
        }

}
?>
