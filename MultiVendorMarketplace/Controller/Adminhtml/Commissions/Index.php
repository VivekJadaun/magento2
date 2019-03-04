<?php
  namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Commissions;

  class Index extends \Magento\Backend\App\Action
  {
    protected $resultPageFactory;
    protected $vendor;
    protected $commissionCollection;

    function __construct(
      \Magento\Backend\App\Action\Context $context,
      \Magento\Framework\View\Result\PageFactory $resultPageFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission\CollectionFactory $commissionCollectionFactory
    )
    {
      $this->resultPageFactory = $resultPageFactory;
      $this->vendor = $vendorFactory->create();
      $this->commissionCollection = $commissionCollectionFactory->create();
      parent::__construct($context); 
    }

    public function execute()
    {

      $from = $this->getRequest()->getParam('from');
      $to = $this->getRequest()->getParam('to');
      // $this->_setPageData();
      // return $this->resultPageFactory->create();
      if ($from && $to) {
        $this->commissionCollection->setFrom($from);
        $this->commissionCollection->setTo($to);
      }

      var_dump($this->getRequest()->getPostValue());
      var_dump($_REQUEST);
      var_dump($from, $to);
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