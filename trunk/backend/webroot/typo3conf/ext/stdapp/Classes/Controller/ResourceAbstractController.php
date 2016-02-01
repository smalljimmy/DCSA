<?php
namespace GK\Stdapp\Controller;

/***************************************************************
 * $Id: ResourceAbstractController.php 200 2014-02-03 13:44:59Z till $
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
class ResourceAbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * resourceRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\ResourceRepository
	 * @inject
	 */
	protected $resourceRepository;

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
	 * filetypes
	 *
	 * @var string
	 */
	protected $filetypes;

	/**
	 *
	 * @param string $filetypes
	 * @return void
	 */
	protected function setFiletypes($filetypes) {
		$this->filetypes = $filetypes;
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
		$resources = $this->resourceRepository->findByType($this->type, $this->portalUser->getCustomer()->_loadRealInstance());
		$this->view->assign('resources', $resources);
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $editResource
	 * @return void
	 */
	public function editAction(\GK\Stdapp\Domain\Model\Resource $editResource = NULL) {
		$customer = $this->portalUser->getCustomer()->_loadRealInstance();
                $resources = $this->resourceRepository->findByType($this->type, $customer);
                $this->view->assign('resources', $resources);
		$this->view->assign('editResource', $editResource);
		$this->view->assign('userPath', $this->settings['uploadPath'].$customer->getIdentifier().'/');
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function updateAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$customer = $this->portalUser->getCustomer()->_loadRealInstance();

		$data = $_FILES['tx_'.strtolower($this->request->getControllerExtensionName()).'_' .strtolower($this->request->getPluginName())];

		if (($url = trim($resource->getUrl())) && !preg_match('/^https?:/', $url))
			$resource->setUrl('http://'.$url);

		if ($resource->getUid() > 0) {
			$this->resourceRepository->update($resource);
			$this->flashMessageContainer->add('Your Resource was updated.');
			if ($data['error']['file'] ==  UPLOAD_ERR_NO_FILE) {
				$this->redirect('edit');
			}
		}
		else {
			$customer->addResource($resource);
			$this->customerRepository->update($customer);
			$this->flashMessageContainer->add('Your Resource was added.');
		}

		if(is_array($data) && count($data)>0) {
			 //Enforce persistence
			$this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager')->persistAll();

			if(($err = $this->handleUpload("file", 
				$this->settings['uploadPath'].$customer->getIdentifier().'/', 
				$resource->getType()->getName().'_'. $resource->getUid(),
				$filepath)) == 0)
			{
				$resource->setPath($filepath);
				$this->resourceRepository->update($resource);

				$this->flashMessageContainer->add('Image saved');
			}
			else {
				$customer->removeResource($resource);
				$this->resourceRepository->remove($resource);

				if ($err == 2)
					$this->flashMessageContainer->add( 'File too big.',"",\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING);
				else
					$this->flashMessageContainer->add("ERROR(".$err.") when saving file!","",\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			}
		}

		$this->redirect('edit');
	}

        /**
         * action delete
         *
         * @param \GK\Stdapp\Domain\Model\Resource $resource
         * @return void
         */
        public function deleteAction(\GK\Stdapp\Domain\Model\Resource $resource) {
                $customer = $this->portalUser->getCustomer()->_loadRealInstance();
                $customer->removeResource($resource);
                $this->customerRepository->update($customer);

                $this->flashMessageContainer->add('Your Resource was deleted.');
                $this->redirect('edit');
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

	protected function handleUpload($property, $uploadDir, $filename, &$path, $maxSize = '2097152') {
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
		if(!\TYPO3\CMS\Core\Utility\GeneralUtility::inList($this->filetypes, strtolower($fileInfo['extension']))) {
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
