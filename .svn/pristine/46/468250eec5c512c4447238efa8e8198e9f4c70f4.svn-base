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
class ResourceController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * resourceRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\ResourceRepository
	 * @inject
	 */
	protected $resourceRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$resources = $this->resourceRepository->findAll();
		$this->view->assign('resources', $resources);
	}

	/**
	 * action show
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function showAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->view->assign('resource', $resource);
	}

	/**
	 * action new
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $newResource
	 * @dontvalidate $newResource
	 * @return void
	 */
	public function newAction(\GK\Stdapp\Domain\Model\Resource $newResource = NULL) {
		if ($newResource == NULL) { // workaround for fluid bug ##5636
			$newResource = t3lib_div::makeInstance('');
		}
		$this->view->assign('newResource', $newResource);
	}

	/**
	 * action create
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $newResource
	 * @return void
	 */
	public function createAction(\GK\Stdapp\Domain\Model\Resource $newResource) {
		$this->resourceRepository->add($newResource);
		$this->flashMessageContainer->add('Your new Resource was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function editAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->view->assign('resource', $resource);
	}

	/**
	 * action update
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function updateAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->resourceRepository->update($resource);
		$this->flashMessageContainer->add('Your Resource was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \GK\Stdapp\Domain\Model\Resource $resource
	 * @return void
	 */
	public function deleteAction(\GK\Stdapp\Domain\Model\Resource $resource) {
		$this->resourceRepository->remove($resource);
		$this->flashMessageContainer->add('Your Resource was removed.');
		$this->redirect('list');
	}

}
?>