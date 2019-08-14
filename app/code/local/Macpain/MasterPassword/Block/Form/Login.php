<?php

class Macpain_MasterPassword_Block_Form_Login extends Mage_Core_Block_Template
{
	/**
	 * Path to master password enabled option
	 * @var constance
	 */
	const ENABLED = 'masterpassword/options/enable_login_form';

    /**
     * Get login post url
     * 
     * @return string
     */
    public function getLoginPostUrl()
    {
    	return $this->helper('macpain_masterpassword')->getLoginPostUrl();
    }
    
    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUsername()
    {
    	return $this->_username = Mage::getSingleton('customer/session')->getUsername(true);
    }
    
    public function isFrontEndFormEnabled()
    {
    	return Mage::getStoreConfig(self::ENABLED);
    }

}