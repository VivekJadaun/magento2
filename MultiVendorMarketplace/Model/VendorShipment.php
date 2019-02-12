<?php
namespace Vinsol\MultiVendorMarketplace\Model;

/**
 * 
 */
class VendorShipment extends \Magento\Framework\Model\AbstractModel
{
        
    const VENDOR_SHIPMENT_TABLE = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY . '_shipment';
    
    // public function __construct(
    //  \Magento\Framework\Model\Context $context,
    //     \Magento\Framework\Registry $registry,
    //     \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
    //     \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
    //     array $data = []
    // )
    // {
    //     parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    // }

    protected function _construct()
    {
        $this->_init('Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorShipment');
    }

}