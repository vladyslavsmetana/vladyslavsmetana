<?php
namespace Smetana\Acl\Plugin;

use \Smetana\Acl\Plugin\Base;

/**
 * Overriding meta data according to user permissions
 */
class PageProvider extends Base
{
    /**
     * Changing provider data
     *
     * @param \Magento\Cms\Model\Page\DataProvider $plugin_object
     * @param array $meta
     *
     * @return array $meta
     */
    public function afterPrepareMeta(\Magento\Cms\Model\Page\DataProvider $plugin_object, array $meta): array
    {        
        if ($this->isAllowed('Magento_Cms::page_design')) {
            $meta['design']['arguments']['data']['config']['disabled'] = true;
            $meta['custom_design_update']['arguments']['data']['config']['disabled'] = true;
            
            if ($this->store->getStoreId() != 0 && $this->store->getName() != 'admin') {
                $meta = $this->componentDisable(
                    $meta, 
                    [
                        'page_layout', 
                        'layout_update_xml',
                    ], 
                    'design'
                );
                $meta = $this->componentDisable(
                    $meta, 
                    [
                        'custom_theme_from', 
                        'custom_theme_to', 
                        'custom_theme', 
                        'custom_root_template',
                    ], 
                    'custom_design_update'
                );
            }
        }
        return $meta;
    }    
}
