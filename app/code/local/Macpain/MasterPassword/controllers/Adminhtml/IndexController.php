<?php

class Macpain_MasterPassword_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Path to master password helper
	 * @var constance
	 */
	const MASTER_PASSWORD_HELPER = 'macpain_masterpassword/password';
	
	/**
	 * Path to master password
	 * @var constance
	 */
	const MASTER_PASSWORD 		 = 'masterpassword/options/password';
	
	/**
	 * Path to master password salt string
	 * @var constance
	 */
	const SALT			  		 = 'masterpassword/options/salt';
	
	/**
	 * loginPost Action
	 */
	public function indexAction()
	{
		$session		 		= $this->_getSession();
		$master_password 		= Mage::getStoreConfig(self::MASTER_PASSWORD);
		$salt			 		= Mage::getStoreConfig(self::SALT);
		$master_password_helper = Mage::helper(self::MASTER_PASSWORD_HELPER);
		
		if (!$this->getRequest()->getParam('customer_email')) {
			$session->addError('No customer email address!');
			$this->_redirect('adminhtml/customer');
			return;
		}
		
		if ($master_password == '') {
			$session->addError('Enter master password in admin section!');
			$this->_redirect('adminhtml/customer');
			return;
		}
		
		if ($salt == '') {
			$session->addError('Enter salt string in admin section!');
			$this->_redirect('adminhtml/customer');
			return;
		}
		
		$this->_redirectUrl(
			Mage::getUrl(
				'masterpassword/index/loginfromadminpost',
				array(
					'customer_email' => $this->getRequest()->getParam('customer_email'),
					'password'		 => base64_encode(
						$master_password_helper->encryptPasword($master_password)
					)
				)
			)
		);
	}
	
	/**
	 * Retrieve adminhtml session model object
	 *
	 * @return Mage_Adminhtml_Model_Session
	 */
	protected function _getSession()
	{
		return Mage::getSingleton('adminhtml/session');
	}
}