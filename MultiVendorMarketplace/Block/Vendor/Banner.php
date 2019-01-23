<?php
namespace Vinsol\MultiVendorMarketplace\Block\Vendor;

class Banner extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::banner.phtml';
  public $banner = '';
  public $username;
  protected $adminActionContext;
  protected $session;
  protected $vendor;
  protected $response;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\App\ResponseInterface $response,
    \Magento\Backend\App\Action\Context $adminActionContext,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    array $data = []
  )
  {
    $this->adminActionContext = $adminActionContext;
    $this->vendor = $vendorFactory->create();
    $this->response = $response;
    parent::__construct($context, $data);
  }

  public function _prepareLayout()
  {
    parent::_prepareLayout();
    $vendorId = $this->adminActionContext->getRequest()->getParam('id');
    if ($vendorId) {
      $this->vendor->load($vendorId);
      
      if ($this->vendor->getId()) {
        $this->username = $this->vendor->getUsername();

        if ($this->vendor->getBanner()) {
          $this->banner = $this->vendor->getBanner(); 
        }

      }
      
    }

  }
}