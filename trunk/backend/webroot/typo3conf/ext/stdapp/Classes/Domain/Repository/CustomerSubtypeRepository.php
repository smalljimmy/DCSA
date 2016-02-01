<?php
namespace GK\Stdapp\Domain\Repository;

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
class CustomerSubtypeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

        /**
         * Find all types/subtypes for customer
         *
	 * @param string $identifier
         * @return array Matched resources
         */
        public function findForApi($identifier) {
                $query = $this->createQuery();
                $constraints = array();

                #$constraints[] = $query->equals('type.uid', $type);
                $constraints[] = $query->equals('customer.identifier', $identifier);

                $query->matching($query->logicalAnd($constraints));
                return $query->execute();
        }
}
?>
