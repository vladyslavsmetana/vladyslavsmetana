<?php
namespace Smetana\Acl\Plugin\Saving;

use \Smetana\Acl\Plugin\Saving\Base;

/**
 * Overwriting save data according to user permissions
 */
class SavePage extends Base
{     
    /**
     * Changing save data
     *
     * @param \Magento\Cms\Model\Page $page
     * 
     * @return null
     */
    public function beforeBeforeSave(\Magento\Cms\Model\Page $page)
    {            
        if (!$this->isAllowed('Magento_Cms::page_design')) {
            $this->saveDesign(
                $page, 
                [
                    'page_layout', 
                    'layout_update_xml', 
                    'custom_theme', 
                    'custom_root_template', 
                    'custom_theme_from', 
                    'custom_theme_to',
                ]
            );
        }        
    }
}