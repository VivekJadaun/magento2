<?php
namespace Vinsol\MultiVendorMarketplace\Ui\DataProvider\Commission;

/**
 * 
 */
class ReportDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        
    }
}