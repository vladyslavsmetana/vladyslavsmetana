<?php
namespace Smetana\Acl\Plugin;

/**
 * General-purpose functionality
 */
class Base
{
    /**
     * Authorization interface
     *
     * @var \Magento\Framework\AuthorizationInterface
     */
    private $authorization;
    
    /**
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
    }	
        
    /**
     * Permissions check
     *
     * @param string $acl_id
     *
     * @return boolean
     */
    protected function isAllowed(string $acl_id): bool
    {
        return $this->authorization->isAllowed($acl_id);  
    }
        
    /**
     * Disabling meta components
     * 
     * @param array $meta
     * @param array $fields
     * @param string $tabName
     *
     * @return array $meta
     */
    protected function componentDisable(array $meta, array $fields, string $tabName): array
    {
        foreach ($fields as $field) {
            $meta[$tabName]['children'][$field]['arguments']['data']['config']['serviceDisabled'] = true;
        }

        return $meta;
    }
    
    /**
     * Disabling product components
     * 
     * @param array $meta
     * @param array $subFields
     * @param array $fields
     * @param string $attributeName
     *
     * @return array $meta
     */
    protected function productComponentDisable(
        array $meta, 
        array $subFields,
        array $fields,
        string $attributeName
    ): array {
        for ($i = 0; $i < count($subFields); $i++) {
            $meta[$attributeName]['children'][$subFields[$i]]['children'][$fields[$i]]['arguments']['data']['config']['disabled'] = true;
            $meta[$attributeName]['children'][$subFields[$i]]['children'][$fields[$i]]['arguments']['data']['config']['serviceDisabled'] = true;
        }
        
        return $meta;
    }

    /**
     * Disabling design tabs
     *
     * @param array $meta
     * @param array $fields
     *
     * @return array $meta
     */
    protected function tabsDisable(array $meta, array $fields): array
    {
        foreach ($fields as $field) {
            $meta[$field]['arguments']['data']['config']['disabled'] = true;
        }

        return $meta;
    }
}
