<?php
namespace Vinsol\MultiVendorMarketplace\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class CommissionAmount extends \Magento\Ui\Component\Listing\Columns\Column
{
  protected $user;
  public function __construct(
    \Magento\User\Model\UserFactory $userFactory,
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    array $components = [],
    array $data = []
  ) {
    $this->user = $userFactory->create();
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource(array $dataSource)
  {
    // if (isset($dataSource['data']['items'])) {
    //   foreach ($dataSource['data']['items'] as & $item) {
    //     if (isset($item['user_id'])) {
    //       $userId = $item['user_id'];
    //       $this->user->load($userId);
    //       if ($this->user->getId()) {
    //         $item['user_id'] = $this->user->getUsername();
    //       }
          
    //     }
    //   }
    // }

    // var_dump($dataSource['data']['items']);
    return $dataSource;
  }
}