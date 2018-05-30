<?php
$installer = $this;
$installer->startSetup();
$installer->removeAttribute('customer', 'username');
$installer->addAttribute('customer', 'username', array(
    'type'     => 'varchar',
    'backend'  => '',
    'label'    => 'User Name',
    'input'    => 'text',
    'source'   => '',
    'visible'  => true,
    'required' => true,
    'default'  => '',
    'frontend' => '',
    'unique'   => true,
    'note'     => 'Username for login',
));

$used_in_forms = array(
    'adminhtml_customer',
    'customer_account_create',
    'customer_account_edit',
);

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'username');
$attribute->setData('used_in_forms', $used_in_forms)
    ->setData('is_visible', 1)
    ->setData('is_system', 0)
    ->setData('sort_order', 100);
$attribute->save();

$this->endSetup();
