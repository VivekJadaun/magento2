<?php

namespace Vinsol\MultiVendorMarketplace\Model\Config\Source;

/**
 * 
 */
class Roles implements \Magento\Framework\Option\ArrayInterface
{
  protected $role;
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\Role $role
  )
  {
    $this->role = $role;
    // parent::__construct();
  }

  public function toOptionArray()
  {
    $array = [
      ['value' => '0', 'label' => __('Select role')]
    ];

    $collection = $this->role->getCollection();

    if ($collection->count()) {
      foreach ($collection as $key => $value) {
        $id = $value->getData('role_id');
        $role = $value->getData('role_name');
        $pair = [ 
          'value' => $id,
          'label' => $role
        ];
        $array[] = $pair;
      }
    }
    return $array;
  }
}