<?php
namespace Smetana\Acl\Plugin;

use \Smetana\Acl\Plugin\Base;

/**
 * Overriding meta data according to user permissions
 */
class ProductProvider extends Base
{
    /**
     * Changing provider data
     *
     * @param \Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider $plugin_object
     * @param array $meta
     *
     * @return array $meta
     */
    public function afterGetMeta(\Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider $plugin_object, array $meta): array
    {   
        if (!$this->isAllowed('Magento_Catalog::products_design')) {
            $meta = $this->tabsDisable($meta, ['design', 'schedule-design-update']);
            
            $meta = $this->productComponentDisable(
                $meta,
                [
                    'page_layout', 
                    'options_container', 
                    'custom_layout_update',
                ], 
                'design'
            );
            
            $meta = $this->productComponentDisable(
                $meta,
                [
                    'custom_design_from', 
                    'custom_design_to', 
                    'custom_design', 
                    'custom_layout',
                ], 
                'schedule-design-update'
            );
        }

        return $meta;
    }    
}
