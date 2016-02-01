<?php
namespace GK\Stdapp\Controller;

/***************************************************************
 * $Id: BackendController.php 215 2014-03-21 06:20:25Z till $
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
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * resourceRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\ResourceRepository
	 * @inject
	 */
	protected $resourceRepository;

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
         * customerTypenameRepository
         *
         * @var \GK\Stdapp\Domain\Repository\CustomerTypenameRepository
         * @inject
         */
        protected $customerTypenameRepository;

        /**
         * resourceTypeRepository
         *
         * @var \GK\Stdapp\Domain\Repository\ResourceTypeRepository
         * @inject
         */
        protected $resourceTypeRepository;


	/**
	 * @return void
	 */
	public function initializeAction() {
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
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $editMessage
	 * @return void
	 */
	public function editMessageAction(\GK\Stdapp\Domain\Model\Message $editMessage = NULL) {
                $messages = $this->messageRepository->findByType(7,NULL);
                $this->view->assign('messages', $messages);
                $this->view->assign('customers', $this->customerRepository->findAll());
		$this->view->assign('editMessage', $editMessage);
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Message $message
	 * @return void
	 */
	public function updateMessageAction(\GK\Stdapp\Domain\Model\Message $message) {
		if ($message->getUid() > 0) {
			$this->messageRepository->update($message);
			$this->flashMessageContainer->add('Your Message was updated.');
		}
		else {
			$this->messageRepository->add($message);
			$this->flashMessageContainer->add('Your Message was added.');
		}

		$this->redirect('editMessage');
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listBannerAction() {
		$resources = $this->resourceRepository->findByType(12);
		$this->view->assign('banners', $resources);
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $editBanner
	 * @return void
	 */
	public function editBannerAction(\GK\Stdapp\Domain\Model\Resource $editBanner = NULL) {
                $banners = $this->resourceRepository->findByType(12);

		foreach ($banners as $banner)
			$banner->setPath(str_replace('{baseurl}', $this->settings['baseUrl'], $banner->getPath()));

                $this->view->assign('banners', $banners);
                $this->view->assign('customers', $this->customerRepository->findAll());
		$this->view->assign('editBanner', $editBanner);
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $banner
	 * @return void
	 */
	public function updateBannerAction(\GK\Stdapp\Domain\Model\Resource $banner) {

		$data = $_FILES['tx_'.strtolower($this->request->getControllerExtensionName()).'_' .strtolower($this->request->getPluginName())];

		if (($url = trim($banner->getUrl())) && !preg_match('/^https?:/', $url))
			$banner->setUrl('http://'.$url);

		if ($banner->getUid() > 0) {
			$this->resourceRepository->update($banner);
			$this->flashMessageContainer->add('Your Resource was updated.');
			if ($data['error']['file'] ==  UPLOAD_ERR_NO_FILE) {
				$this->redirect('editBanner');
			}
		}
		else {
			$this->resourceRepository->add($banner);
			$this->flashMessageContainer->add('Your Resource was added.');
		}


		if(is_array($data) && count($data)>0) {
			 //Enforce persistence
			$this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager')->persistAll();

			if(($err = $this->handleUpload("file", 
				$this->settings['uploadPath'], 
				$banner->getType()->getName().'_'. $banner->getUid(),
				$filepath)) == 0)
			{
				$banner->setPath('{baseurl}'.$this->settings['uploadPath'].$filepath);
				$this->resourceRepository->update($banner);

				$this->flashMessageContainer->add('Banner saved');
			}
			else {
				$this->resourceRepository->remove($banner);

				if ($err == 2)
					$this->flashMessageContainer->add( 'File too big.',"",\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING);
				else
					$this->flashMessageContainer->add("ERROR(".$err.") when saving file!","",\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			}
		}

		$this->redirect('editBanner');
	}

        /**
         * action delete
         *
         * @param \GK\Stdapp\Domain\Model\Resource $banner
         * @return void
         */
        public function deleteBannerAction(\GK\Stdapp\Domain\Model\Resource $banner) {
                $this->resourceRepository->remove($banner);

                $this->flashMessageContainer->add('Your Resource was deleted.');
                $this->redirect('editBanner');
        }

	/**
	 * 
	 * Move one resource down
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 */
	public function moveDownAction(\GK\Stdapp\Domain\Model\Resource $resource){
		$resources = $this->resourceRepository->findByType($this->type, $this->portalUser->getCustomer()->_loadRealInstance());
		
		foreach($resources as $res){
			if ($lastres == $resource) {
				{
					$pos = $res->getSort();
					$lastpos = $lastres->getSort();
					if ($pos == $lastpos) {
						$res->setSort($pos);
						$lastres->setSort($pos+1);
					}
					else {
						$res->setSort($lastpos);
						$lastres->setSort($pos);
					}
					$this->resourceRepository->update($res);
					$this->resourceRepository->update($lastres);
					break;
				}
				
			}
			
			$lastres = $res;
		}
		
                $this->flashMessageContainer->add('Your Resource was moved.');
                $this->redirect('edit');	
	}
	
	
	/**
	 * 
	 * Move one resource up
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 */
	public function moveUpAction(\GK\Stdapp\Domain\Model\Resource $resource){
		$resources = $this->resourceRepository->findByType($this->type, $this->portalUser->getCustomer()->_loadRealInstance());
			
		foreach($resources as $res){
			if ($res == $resource && $lastres != NULL) {
					$pos = $res->getSort();
					$lastpos = $lastres->getSort();
					if ($pos == $lastpos) {
						$res->setSort($pos);
						$lastres->setSort($pos+1);
					}
					else {
						$res->setSort($lastpos);
						$lastres->setSort($pos);
					}
					$this->resourceRepository->update($res);
					$this->resourceRepository->update($lastres);
					break;
			}
			
			$lastres = $res;
		}
		
                $this->flashMessageContainer->add('Your Resource was moved.');
                $this->redirect('edit');
	}

	/**
	 * action editMenus
	 *
	 * @return void
	 */
	public function editMenusAction() {
		$resourceTypes = $this->resourceTypeRepository->findByIsMenu(1);

		$customerTypenames = array();
		foreach ($this->customerRepository->findAll() as $customer) {
			$customerUid = $customer->getUid();
			$customerTypenames[$customerUid]['customer'] = $customer->getIdentifier();
			foreach ($resourceTypes as $type) {
				$typeUid = $type->getUid();
 				foreach($customer->getTypenames() as $typename) {
					if($typename->getType() == $type) {
						$customerTypenames[$customerUid]['names'][$typeUid] = $typename->getName();
						break;
					}
				}
				if(!isset($customerTypenames[$customerUid][$typeUid]))
					$customerTypenames[$customerUid][$typeUid] = $type->getName();
			}
		}
						

                $this->view->assign('resourceTypes', $resourceTypes);
                $this->view->assign('customerTypenames', $customerTypenames);
	}

	/**
	 * action editMenus
	 *
         * @param array $customerTypenames
         * @param array $submit
	 * @return void
	 */
	public function updateMenusAction($customerTypenames, $submit) {

		foreach($submit as $submCustomerUid => $val) {
			foreach ( $customerTypenames as $customerUid => $customerTypenames) {
				if ($submCustomerUid == $customerUid) {
					foreach ( $customerTypenames as $typeUid => $typename) {
						$customerTypename = $this->customerTypenameRepository->findOneByCustomerAndType($customerUid, $typeUid);
						if ($customerTypename != NULL) {
							$customerTypename->setName($typename);
							$this->customerTypenameRepository->update($customerTypename);
						}
						else {
							$customerTypename = new \GK\Stdapp\Domain\Model\CustomerTypename;
							$customer = $this->customerRepository->findByUid($customerUid);
							if ($customer == NULL)
								die ("Customer not found!");
							$resourceType = $this->resourceTypeRepository->findByUid($typeUid);
							if ($resourceType == NULL)
								die ("ResourceType not found!");
							$customerTypename->setName($typename);
							$customerTypename->setType($resourceType);
							$customer->addTypename($customerTypename);
							$this->customerRepository->update($customer);
						}
					}
				}
			}
		}
						
                $this->flashMessageContainer->add('Menu Names updated.');
                $this->redirect('editMenus');
	}

	protected function handleUpload($property, $uploadDir, $filename, &$path, $maxSize = '2097152', $filetypes="jpg,png") {
		$data = $_FILES['tx_' .
		strtolower($this->request->getControllerExtensionName()) . '_' .
		strtolower($this->request->getPluginName())];

		if(is_array($data) && count($data)>0) {
			$propertyPath = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('.',$property);
			$namePath = $data['name'];
			$tmpPath = $data['tmp_name'];
			$sizePath = $data['size'];
			foreach($propertyPath as $segment) {
				$namePath = $namePath[$segment];
				$tmpPath = $tmpPath[$segment];
				$sizePath = $sizePath[$segment];
			}
			if($namePath !== NULL && $namePath !== '') {
				$fileArray = array(
						'name' => $namePath,
						'tmp' => $tmpPath,
						'size' => $sizePath,
				);
			}
			else {
				return 1;
			}
		} 
		else {
			return 0;
		}

		if($fileArray['size'] > $maxSize) {
			return 2;
		}
		$fileInfo = pathinfo($fileArray['name']);
		if(!\TYPO3\CMS\Core\Utility\GeneralUtility::inList($filetypes, strtolower($fileInfo['extension']))) {
			return 3;
		}

		if(file_exists(PATH_site . $uploadDir . $filename)) {
			$filename = $filename . '-' . time() . '.' .
			$fileInfo['extension'];
		}
		if(\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($fileArray['tmp'], PATH_site . $uploadDir . $filename . '.' . $fileInfo['extension'])) {
			$path = $filename.'.'.$fileInfo['extension'];
			return 0;
		}
		else {
			\TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile($fileArray['tmp']);
			return 4;
		}
	}

}
?>
