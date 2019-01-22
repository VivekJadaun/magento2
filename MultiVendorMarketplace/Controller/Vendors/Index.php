<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Vendors;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
  protected $resultPageFactory;
  public function __construct(
    Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    parent::__construct($context);
  }

  public function execute()
  {
    // $resultPage = $this->resultPageFactory->create(false, ['template' => 'Vinsol_MultiVendorMarketplace::vendor.phtml']);
    $resultPage = $this->resultPageFactory->create();
    // $resultPage->getConfig()->getTitle()->prepend(__('Vendors Landing Page'));
    return $resultPage;
    // return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
  }
}