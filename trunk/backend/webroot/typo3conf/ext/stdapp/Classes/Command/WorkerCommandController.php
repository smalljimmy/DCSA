<?php
namespace GK\Stdapp\Command;

/***************************************************************
 * $Id: WorkerCommandController.php 231 2014-06-19 15:10:36Z till $
 * -------------------------------------------------------------
 *  Copyright notice
 *
 *  (c) 2013 Till Wimmer <twimmer@gordiancode.com>
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
class WorkerCommandController extends  \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
	 * @inject
	 */
	protected $persistenceManager;

        /**
         * subscriberRepository
         *
         * @var \GK\Stdapp\Domain\Repository\SubscriberRepository
         * @inject
         */
        protected $subscriberRepository;

	/**
	 * messageRepository
	 *
	 * @var \GK\Stdapp\Domain\Repository\MessageRepository
	 * @inject
	 */
	protected $messageRepository;

	/**
	 * logger
	 *
	 * @var \TYPO3\CMS\Core\Log\LogManager
	 */
	protected $logger;


	public function initializeCommand() {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,'stdapp','worker');
		$this->configurationManager->setConfiguration($extbaseFrameworkConfiguration);

		$this->settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,'stdapp','worker');

		$this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
	}

	/**
	 * worker command
	 *
	 * @param string $commandIdentifier
	 * @return void
	 */
	public function workerCommand($commandIdentifier = NULL) {
		$this->initializeCommand();
		//echo 'your command is run';

		$now = time();
		$last = $now - 60 * 5;
		$expired = $now - 60*60*24*5;

		$err = 0;

		$toRemove = array();

		foreach ($this->subscriberRepository->findAll() as $subscriber) {

			if ($subscriber->getTstamp()->getTimestamp() < $expired) {
				$toRemove[] = $subscriber;
				continue;
			}

			if ($this->messageRepository->countNewer($subscriber->getCustomer(), 7, $last) > 0) {
				 $err += $this->notify($subscriber);	
			}
		}

		foreach ($toRemove as $toRmSubscriber)
			$this->subscriberRepository->remove($toRmSubscriber);

		if(count($toRemove) > 0)
			 $this->persistenceManager->persistAll();

		if($err)
			exit(1);
	}

	/**
	 * notify
	 *
	 * @param \GK\Stdapp\Domain\Model\Subscriber $subscriber
	 * @return integer
	 */
	private function notify($subscriber) {
		//need opening support for ssl(OpenSSL)  in php
		$apnsCert = $this->settings['apnPem']; //certificate used to connect to APNS. The certificate must be created according to requirement individually
		$pass = $this->settings['apnPemSecret']; //password for the certificate
		$serverUrl = $this->settings['apnUrl']; //"ssl://gateway.sandbox.push.apple.com:2195"; //push server (here is the test server)
		$deviceToken = $subscriber->getToken(); //ios device id (no space in between is allowed between). Each ios device corresponds to one id
		$message = "StdAPP Neue Nachricht!";
		$badge = ( int ) $_GET ['badge'] or $badge = 2;
		$sound = $_GET ['sound'] or $sound = "default";
		$body = array('aps' => array('alert' => $message , 'badge' => $badge , 'sound' => $sound));
		
		$streamContext = stream_context_create();
		stream_context_set_option ( $streamContext, 'ssl', 'local_cert', $apnsCert );
		stream_context_set_option ( $streamContext, 'ssl', 'passphrase', $pass );

		$apns = stream_socket_client ( $serverUrl, $error, $errorString, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $streamContext); //connect to the server
		if ($apns) {
			$this->logger->info( 'Connection OK' );
			echo "Connection OK\n";
		} else {
			$this->logger->error( "Failed to connect '$errorString'" );
			fwrite(STDERR, "Failed to connect $errorString\n");
			return 1;
		}

		$payload = json_encode ( $body );
		$msg = chr(0) . pack('n', 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack('n', strlen($payload)) . $payload;
		$result = fwrite ( $apns, $msg); //send message
		fclose ( $apns );

		if ($result)
			$this->logger->info( 'Sending message successfully: ' . $payload );
			echo "Sending message successfully: " . $payload . "\n";
		else {
			$this->logger->error( 'Message not delivered' );
			fwrite(STDERR, "Message not delivered\n");
			return 1;
		}
	}

}

?>
