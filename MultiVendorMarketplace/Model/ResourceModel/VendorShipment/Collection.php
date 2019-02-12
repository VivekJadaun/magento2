<?php 
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorShipment;

/**
 * 
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init(
            '\Vinsol\MultiVendorMarketplace\Model\VendorShipment',
            '\Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorShipment'
        );
    }
}