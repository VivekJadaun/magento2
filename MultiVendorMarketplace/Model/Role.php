<?php 

namespace Vinsol\MultiVendorMarketplace\Model;

/**
 * 
 */
class Role extends \Magento\Framework\Model\AbstractModel
{
  
  public function _construct()
  {
    $this-> _init('\Vinsol\MultiVendorMarketplace\Model\ResourceModel\Role');
  }
}