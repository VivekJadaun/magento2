<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Vendors;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
  protected $resultPageFactory;
  protected $vendor;
  public function __construct(
    Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    // $this->vendor = $vendorFactory;
    parent::__construct($context);
  }

  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    if (!isset($id)) {
      $this->_forward('cms', 'noroute', 'index');
    } else {
      $this->vendor->load($id);
      $userId = $this->vendor->getUserId();
      if (!$this->vendor->getStatus($userId)) {
        $this->_forward('cms', 'noroute', 'index');
      }
    }

    // $resultPage = $this->resultPageFactory->create(false, ['template' => 'Vinsol_MultiVendorMarketplace::vendor.phtml']);
    $resultPage = $this->resultPageFactory->create();
    // $resultPage->getConfig()->getTitle()->prepend(__('Vendors Landing Page'));
    return $resultPage;
    // return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
  }
}