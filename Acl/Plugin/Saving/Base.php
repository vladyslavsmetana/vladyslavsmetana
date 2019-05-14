<?php
namespace Smetana\Acl\Plugin\Saving;

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
     * Replacing attributes 
     *
     * @param object $model
     * @param array $fields
     * 
     * @return null
     */
    protected function saveDesign($model, array $fields)
    {
        foreach ($fields as $field) {
            $model->setData($field, $model->getOrigData($field));
        }
    }
}
