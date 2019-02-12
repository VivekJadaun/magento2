<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

class VendorShipment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init(\Vinsol\MultiVendorMarketplace\Model\VendorShipment::VENDOR_SHIPMENT_TABLE, 'id');
    }
}