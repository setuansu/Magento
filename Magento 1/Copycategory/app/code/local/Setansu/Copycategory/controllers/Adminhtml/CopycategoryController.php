<?php
class Setansu_Copycategory_Adminhtml_CopycategoryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $postdata   = $this->getRequest()->getParams();
        $categoryId = $postdata['categoryid'];

        $sourceCategory = Mage::getModel('catalog/category')->load($categoryId);
        $categoryData   = $sourceCategory->getData();
        $parentId       = $sourceCategory->getParentId();
        $image          = $sourceCategory->getImage();

        $categoryApi = new Mage_Catalog_Model_Category_Api();
        try {
            $newCategoryId = $categoryApi->create(
                $parentId,
                array(
                    'name'                       => $categoryData['name'],
                    'is_active'                  => $categoryData['is_active'],
                    'position'                   => $categoryData['position'],
                    'available_sort_by'          => 'position',
                    'default_sort_by'            => 'position',
                    'description'                => $categoryData['description'],
                    'display_mode'               => $categoryData['display_mode'],
                    'is_anchor'                  => $categoryData['is_anchor'],
                    'landing_page'               => $categoryData['landing_page'],
                    'meta_description'           => $categoryData['meta_description'],
                    'meta_keywords'              => $categoryData['meta_keywords'],
                    'meta_title'                 => $categoryData['meta_title'],
                    'page_layout'                => 'two_columns_left',
                    'include_in_menu'            => $categoryData['include_in_menu'],
                    'image'                      => $image,
                    'custom_use_parent_settings' => $categoryData['custom_use_parent_settings'],
                    'level'                      => $categoryData['level'],
                )
            );
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('error ' . $e->getMessage());
        }
        //Assign products
        if ($newCategoryId) {
            $products = $categoryApi->assignedProducts($categoryId);
            foreach ($products as $product) {
                $categoryApi->assignProduct($newCategoryId, $product['product_id']);
            }
        }
        $this->_redirect('*/catalog_category/', array('id' => $categoryId));
    }
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/categories/copycategory');
    }
}
