<?php
namespace Smetana\Acl\Plugin;

use \Smetana\Acl\Plugin\Base;

/**
 * Overriding meta data according to user permissions
 */
class CategoryProvider extends Base
{
    /**
     * Changing provider data
     *
     * @param \Magento\Catalog\Model\Category\DataProvider $plugin_object
     * @param array $meta
     *
     * @return array $meta
     */
    public function afterGetMeta(\Magento\Catalog\Model\Category\DataProvider $plugin_object, array $meta): array
    {   
        if (!$this->isAllowed('Magento_Catalog::category_design')) {
            $meta['schedule_design_update']['children']['custom_design_from']['arguments']['data']['config']['disabled'] = true;
            $meta['schedule_design_update']['children']['custom_design_to']['arguments']['data']['config']['disabled'] = true;
            $meta['design']['arguments']['data']['config']['disabled'] = true;
            $meta['schedule_design_update']['arguments']['data']['config']['disabled'] = true;
            
            if ($this->store->getStoreId() != 0 && $this->store->getName() != 'admin') {
                $meta = $this->componentDisable(
                    $meta, 
                    [
                        'custom_use_parent_settings', 
                        'custom_apply_to_products', 
                        'custom_design', 
                        'page_layout', 
                        'custom_layout_update',
                    ], 
                    'design'
                );
                $meta = $this->componentDisable(
                    $meta, 
                    [
                        'custom_design_to', 
                        'custom_design_from',
                    ], 
                    'schedule_design_update'
                );
            }
        }
        
        return $meta;
    }    
}
