<?php
namespace GK\Stdapp\Domain\Repository;

/***************************************************************
 * $Id: MessageRepository.php 221 2014-03-25 09:14:58Z till $
 * -------------------------------------------------------------
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
class MessageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Find all messages for Google sitemap
	 *
	 * @param integer $type
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
	 * @return array Matched messages
	 */
	public function findByType($type,\GK\Stdapp\Domain\Model\Customer $customer=NULL) {
		$query = $this->createQuery();
		$constraints = array();

		$constraints[] = $query->equals('type', $type);
		if ($customer !== NULL) {
			$constraints[] = $query->equals('customer', $customer);
		}

		$query->matching($query->logicalAnd($constraints));
		return $query->execute();				
	}

        /**
         * Find all messages for type/customer
         *
	 * @param string $identifier
         * @param integer $type
	 * @param integer $uid
         * @return array Matched resources
         */
        public function findForApi($identifier, $type, $uid) {
		$now = time();
                $query = $this->createQuery();
                $constraints1 = array();
		$constraints2 = array();

                $constraints1[] = $constraints2[] = $query->equals('type', $type);
		$constraints1[] = $constraints2[] = $query->equals('disabled', 0);

		$constraints1[] = $constraints2[] = $query->lessThanOrEqual('start', $now);
		$ors = array();
		$ors[] = $query->equals('end', 0);
		$ors[] = $query->greaterThan('end', $now);
		$constraints1[] = $constraints2[] = $query->logicalOr($ors);

                $constraints1[] = $query->equals('customer.identifier', $identifier);
                $constraints2[] = $query->equals('broadcast.identifier', $identifier);

		if ($uid > 0) 
			$constraints1[] = $constraints2[] = $query->equals('uid', $uid);

                $query->matching($query->logicalAnd($constraints1));
		$res1 = $query->execute()->toArray();

		$query->matching($query->logicalAnd($constraints2));
		$res2 = $query->execute()->toArray();

		return array_merge($res1, $res2);
        }

        /**
         * Count all messages for type/customer
         *
	 * @param string $identifier
         * @param integer $type
         * @return integer number of matched messages
         */
        public function countForApi($identifier, $type) {
		$now = time();
                $query = $this->createQuery();
                $constraints1 = array();
		$constraints2 = array();

                $constraints1[] = $constraints2[] = $query->equals('type', $type);
		$constraints1[] = $constraints2[] = $query->equals('disabled', 0);

		$constraints1[] = $constraints2[] = $query->lessThanOrEqual('start', $now);
		$ors = array();
		$ors[] = $query->equals('end', 0);
		$ors[] = $query->greaterThan('end', $now);
		$constraints1[] = $constraints2[] = $query->logicalOr($ors);

                $constraints1[] = $query->equals('customer.identifier', $identifier);
                $constraints2[] = $query->equals('broadcast.identifier', $identifier);

		if ($uid > 0) 
			$constraints1[] = $constraints2[] = $query->equals('uid', $uid);

                $query->matching($query->logicalAnd($constraints1));
                $res1 = $query->execute()->count();

		$query->matching($query->logicalAnd($constraints2));
		$res2 = $query->execute()->count();

		return $res1 + $res2;
        }

        /**
         * Count all new messages
         *
	 * @param \GK\Stdapp\Domain\Model\Customer $customer
         * @param integer $type
	 * @param integer $last
         * @return integer number of matched messages
         */
        public function countNewer($customer, $type, $last) {
                $query = $this->createQuery();
                $constraints1 = array();

                $constraints1[] = $constraints2[] = $query->equals('type', $type);
		$constraints1[] = $constraints2[] = $query->equals('disabled', 0);

                $constraints1[] = $query->equals('customer', $customer);
		$constraints2[] = $query->contains('broadcast', $customer);

                $constraints1[] = $constraints2[] = $query->greaterThan('start', $last);

                $query->matching($query->logicalAnd($constraints1));
                $res1 = $query->execute()->count();

		$query->matching($query->logicalAnd($constraints2));
		$res2 = $query->execute()->count();

		return $res1 + $res2;
        }
}
?>
