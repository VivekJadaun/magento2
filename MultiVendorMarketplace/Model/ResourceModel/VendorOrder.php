<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

class VendorOrder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init(\Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE, 'id');
    }
}