<?php

class Macpain_MasterPassword_Block_Form_Login extends Mage_Core_Block_Template {

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

}