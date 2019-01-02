<?php 

namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

/**
 * 
 */   
class Role extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
  
  protected function _construct()
  {
    $this->_init('authorization_role', 'role_id');
  }
}