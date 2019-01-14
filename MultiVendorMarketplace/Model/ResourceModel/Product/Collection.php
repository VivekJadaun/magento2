<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Product;

class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Collection
{
  const USER_ID = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;
  protected function _initSelect()
  {
    parent::_initSelect();
    $this->addAttributeToSelect('*');
    $this->addAttributeToFilter(self::USER_ID, ['neq' => 'NULL']);
    return $this;
  }
}