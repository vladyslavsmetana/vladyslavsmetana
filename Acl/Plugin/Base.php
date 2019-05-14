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
     * Store Manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $store;
    
    /**
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization, 
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->authorization = $authorization;
        $this->store = $storeManager->getStore();
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
     * @param array $parameters
     * @param string $field_name
     *
     * @return array $meta
     */
    protected function componentDisable(array $meta, array $parameters, string $field_name): array
    {
        for ($i = 0; $i < count($parameters); $i++) {
            $meta[$field_name]['children'][$parameters[$i]]['arguments']['data']['config']['serviceDisabled'] = true;
        }
        
        return $meta;
    }
    
    /**
     * Disabling product components
     * 
     * @param array $meta
     * @param array $first_parameters
     * @param array $second_parameters
     * @param string $field_name
     *
     * @return array $meta
     */
    protected function productComponentDisable(
        array $meta, 
        array $first_parameters, 
        array $second_parameters, 
        string $field_name
    ): array {
        for ($i = 0; $i < count($first_parameters); $i++) {
            $meta[$field_name]['children'][$first_parameters[$i]]['children'][$second_parameters[$i]]['arguments']['data']['config']['disabled'] = true;
            if ($this->store->getStoreId() != 0 && $this->store->getName() != 'admin') {
                $meta[$field_name]['children'][$first_parameters[$i]]['children'][$second_parameters[$i]]['arguments']['data']['config']['serviceDisabled'] = true;
            }
        }
        
        return $meta;
    }
}
