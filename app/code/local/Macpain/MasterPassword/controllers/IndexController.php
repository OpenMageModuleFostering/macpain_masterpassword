<?php

class Macpain_MasterPassword_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * login Action
	 */
	public function loginAction()
	{
		if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('customer/account');
            return;
        }
        
        $this->getResponse()->setHeader('Login-Required', 'true');
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
	}
	
	/**
	 * loginPost Action
	 */
	public function loginPostAction()
	{
		if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('customer/account');
            return;
        }
        
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {
        	
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
            	
                try {
                	
                	$password = base64_encode(
                		Mage::helper('macpain_masterpassword/password')->encryptPasword(
                			$login['password']
                		)
                	);
                	
                    Mage::getSingleton('macpain_masterpassword/session')->login(
                    	$login['username'],
                    	$password
                    );
                    
                    $this->_redirect('customer/account');
                    return;
                    
                } catch (Mage_Core_Exception $e) {
                	$session->addError($this->__($e->getMessage()));
                } catch (Exception $e) {
                    Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
                }
                
            } else {
                $session->addError($this->__('Login and password are required.'));
            }
        }
        
        $session->setUsername($login['username']);
		$this->_redirect('*/*/login');
	}
	
	/**
	 * loginFromAdminPost Action
	 */
	public function loginFromAdminPostAction()
	{
		if ($this->_getSession()->isLoggedIn()) {
			$this->_getSession()->logout();
			# $this->_redirect('customer/account');
			# return;
		}

		$session = $this->_getSession();
		
		if (!$this->getRequest()->getParam('customer_email') && !$this->getRequest()->getParam('password')) {
			$session->addError($this->__('No customer email address or password!'));
			$this->_redirect('*/*/login');
			return;
		}
		
		try {
		
			Mage::getSingleton('macpain_masterpassword/session')->login(
				$this->getRequest()->getParam('customer_email'),
				$this->getRequest()->getParam('password')
			);
			
			$this->_redirect('customer/account');
			
		} catch (Exception $e) {
			$session->addError($this->__($e->getMessage()));
			$this->_redirect('*/*/login');
		}
			
	}
	
	/**
     * Retrieve customer session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}
