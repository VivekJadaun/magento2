<?php 
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorOrder;

/**
 * 
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init(
            '\Vinsol\MultiVendorMarketplace\Model\VendorOrder',
            '\Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorOrder'
        );
    }
}