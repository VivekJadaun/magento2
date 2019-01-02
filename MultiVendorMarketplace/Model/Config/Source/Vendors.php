<?php

namespace Vinsol\MultiVendorMarketplace\Model\Config\Source;

/**
 * 
 */
class Vendors implements \Magento\Framework\Option\ArrayInterface
{
  protected $vendor;
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\Vendor $vendor
  )
  {
    $this->vendor = $vendor;
    // parent::__construct();
  }

  public function toOptionArray()
  {
    $array = [
      ['value' => '0', 'label' => __('Select Vendor')]
    ];

    $collection = $this->vendor->getCollection();

    if ($collection->count()) {
      foreach ($collection as $key => $value) {
        $id = $value->getData('entity_id');
        $vendor = $value->getData('display_name');
        $pair = [ 
          'value' => $id,
          'label' => $vendor
        ];
        $array[] = $pair;
      }
    }
    return $array;
  }
}