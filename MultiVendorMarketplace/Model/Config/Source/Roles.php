<?php

namespace Vinsol\MultiVendorMarketplace\Model\Config\Source;

/**
 * 
 */
class Roles implements \Magento\Framework\Option\ArrayInterface
{
  protected $role;
  public function __construct(
    \Magento\Authorization\Model\RoleFactory $roleFactory
  )
  {
    $this->role = $roleFactory->create();
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
        $role = __($value->getData('role_name'));
        $option = [ 
          'value' => $id,
          'label' => $role
        ];
        $array[] = $option;
      }
    }
    return $array;
  }
}