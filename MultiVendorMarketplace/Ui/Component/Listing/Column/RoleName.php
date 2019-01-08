<?php
namespace Vinsol\MultiVendorMarketplace\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class RoleName extends \Magento\Ui\Component\Listing\Columns\Column
{
  protected $role;
  protected $vendor;
  // protected $object;
  // protected $messageManager;

  public function __construct(
    \Magento\Framework\Message\Manager $messageManager,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\Authorization\Model\RoleFactory $roleFactory,
    // \Magento\Framework\Model\AbstractModel $object,
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    array $components = [],
    array $data = []
  ) {
    $this->vendor = $vendorFactory->create();
    $this->role = $roleFactory->create();
    $this->messageManager = $messageManager;
    // $this->object = $object;
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource(array $dataSource)
  {
    $dataSource['data']['items'] = $this->vendor->getCollection()->load()->getData();

    if (isset($dataSource['data']['items'])) {
      foreach ($dataSource['data']['items'] as & $item) {
        if(isset($item['parent_id']) && $item['parent_id'] > 0) {
          $parentId = $item['parent_id'];
          $roleName = $item['role_name'];
          if ($parentId > 0) {
            do {
              // $role = $this->role->getResource()->load($this->object, $parentId);
              $role = $this->role->load($parentId);
              if ($role->getId()) {
                $roleName = $roleName . ' > ' . $role->getRoleName();
                if ($role->getData('parent_id') > 0) {
                  $parentId = $role->getData('parent_id');
                } else {
                  $parentId = false;
                }
              }
            } while ($parentId != false && $parentId > 0);
          } 
          $item['role_name'] = $roleName;
          // $this->messageManager->addSuccess($item['role_name']);
        }
      }
    }
    return $dataSource;
  }

}
