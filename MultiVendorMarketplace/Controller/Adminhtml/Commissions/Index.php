<?php
  namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Commissions;

  class Index extends \Magento\Backend\App\Action
  {
    protected $resultPageFactory;
    protected $vendor;

    function __construct(
      \Magento\Backend\App\Action\Context $context,
      \Magento\Framework\View\Result\PageFactory $resultPageFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory
    )
    {
      $this->resultPageFactory = $resultPageFactory;
      $this->vendor = $vendorFactory->create();
      parent::__construct($context); 
    }

    public function execute()
    {
      // $this->_setPageData();
      // return $this->resultPageFactory->create();
      return $this->getResultPage();
    }

    protected function _isAllowed()
    {
      return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
    }

    protected function _setPageData()
    {
      $this->getResultPage()->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors_commission');
      return $this;
    }

    protected function getResultPage()
    {
      $resultPage = $this->resultPageFactory->create();
      $resultPage->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors_commission');
      $resultPage->getConfig()->getTitle()->prepend(__('Commissions'));
      return $resultPage;
    }
  }