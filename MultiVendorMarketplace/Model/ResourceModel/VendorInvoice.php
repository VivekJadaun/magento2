<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

class VendorInvoice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init(\Vinsol\MultiVendorMarketplace\Model\VendorInvoice::VENDOR_INVOICE_TABLE, 'id');
    }
}