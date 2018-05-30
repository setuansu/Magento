<?php
class Setansu_Copycategory_Block_Adminhtml_Catalog_Category_Edit_Form extends Mage_Adminhtml_Block_Catalog_Category_Edit_Form
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $category   = $this->getCategory();
        $categoryId = (int) $category->getId();
        if ($categoryId) {
            $this->addAdditionalButton(
                'update_button',
                array(
                    'name'    => 'update_button',
                    'title'   => 'Copy Category',
                    'type'    => "button",
                    'label'   => Mage::helper('catalog')->__('Copy Category'),
                    'onclick' => "location.href = '" . $this->getUrl(
                        '*/copycategory/'
                        , array('categoryid' => $categoryId)) . "'")
            );
        }
        return parent::_prepareLayout();
    }
}
