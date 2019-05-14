<?php
namespace Smetana\Acl\Plugin\Saving;

use \Smetana\Acl\Plugin\Saving\Base;

/**
 * Overwriting save data according to user permissions
 */
class SaveProduct extends Base
{          
    /**
     * Changing save data
     *
     * @param \Magento\Catalog\Model\Product $product
     * 
     * @return null
     */
    public function beforeSave(\Magento\Catalog\Model\Product $product)
    {
        if (!$this->isAllowed('Magento_Catalog::products_design')) {
            $this->saveDesign(
                $product, 
                [
                    'page_layout', 
                    'options_container', 
                    'custom_layout_update', 
                    'custom_layout', 
                    'custom_design', 
                    'custom_design_from', 
                    'custom_design_to',
                ]
            );
        }
    }        
} 
