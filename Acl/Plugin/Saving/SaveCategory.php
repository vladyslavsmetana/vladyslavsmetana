<?php
namespace Smetana\Acl\Plugin\Saving;

use \Smetana\Acl\Plugin\Saving\Base;

/**
 * Overwriting save data according to user permissions
 */
class SaveCategory extends Base
{      
    /**
     * Changing save data
     *
     * @param \Magento\Catalog\Model\Category $category
     * 
     * @return null
     */
    public function beforeSave(\Magento\Catalog\Model\Category $category)
    {      
        if (!$this->isAllowed('Magento_Catalog::category_design')) {        
            $this->saveDesign(
                $category, 
                [
                    'custom_use_parent_settings', 
                    'custom_apply_to_products', 
                    'custom_design', 
                    'page_layout', 
                    'custom_layout_update', 
                    'custom_design_from', 
                    'custom_design_to',
                ]
            );
        }        
    }            
}
