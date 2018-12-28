<?php

namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Role;

/**
 * 
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
  
  protected function _construct()
  {
    $this->_init(
      'Vinsol\MultiVendorMarketplace\Model\Role',
      'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Role'
    );
  }
}