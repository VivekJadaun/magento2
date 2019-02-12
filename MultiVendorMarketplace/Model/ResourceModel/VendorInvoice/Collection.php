<?php 
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorInvoice;

/**
 * 
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init(
            '\Vinsol\MultiVendorMarketplace\Model\VendorInvoice',
            '\Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorInvoice'
        );
    }
}