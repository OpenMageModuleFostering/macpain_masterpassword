<?php

class Macpain_MasterPassword_Model_Adminhtml_Observer
{
	/**
	 * Path to master password enabled option
	 * @var constance
	 */
	const ENABLED = 'masterpassword/options/enabled';

	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function onBlockHtmlBefore(Varien_Event_Observer $observer)
	{
		if (Mage::getStoreConfig(self::ENABLED)) {
			
			$block = $observer->getBlock();
			if (!isset($block)) return;
			
			switch ($block->getType()) {
				
				case 'adminhtml/customer_grid':
					/* @var $block Mage_Adminhtml_Block_Customer_Grid */
					$block->addColumn('masterpassword',
						array(
							'header'    =>  Mage::helper('customer')->__('Master Password'),
							'width'     => '120',
							'type'      => 'action',
							'getter'    => 'getEmail',
							'actions'   => array(
								array(
									'caption'   => Mage::helper('customer')->__('Login to customers account'),
									'url'       => array('base' => 'masterpassword/adminhtml_index/index'),
									'field'     => 'customer_email',
									'target'	=> '_blank',
									'title'		=> Mage::helper('customer')->__('Login to customers account')
								)
							),
							'filter'    => false,
							'sortable'  => false,
							'index'     => 'stores',
							'is_system' => true,
						)
					);
					break;
				
				case 'adminhtml/customer_edit':
					/* @var $_customer Mage_Customer_Model_Customer */
					$_customer = Mage::getModel('customer/customer')->load($block->getCustomerId());
					/* @var $block Mage_Adminhtml_Block_Customer_Edit */
					$block->addButton('masterpassword', array(
		                'label' => Mage::helper('customer')->__('Login to customers account'),
						'target' => '_blank',
		                'onclick' => 'window.open(\'' . Mage::helper("adminhtml")->getUrl('masterpassword/adminhtml_index/index', array('customer_email' => $_customer->getEmail())) .'\', \'_blank\')',
		                'class' => 'add',
		            ), 7);
		            break;
			}
		}
	}

}