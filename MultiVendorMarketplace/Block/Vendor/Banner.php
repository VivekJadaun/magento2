<?php
namespace Vinsol\MultiVendorMarketplace\Block\Vendor;

class Banner extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::banner.phtml';
  protected $username;
  protected $adminActionContext;
  protected $session;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Backend\App\Action\Context $adminActionContext,
    array $data = []
  )
  {
    $this->adminActionContext = $adminActionContext;
    parent::__construct($context, $data);
  }

  public function _prepareLayout()
  {
    $vendor = $this->adminActionContext->getRequest()->getParam('vendor');
    if ($vendor) {
      parent::_prepareLayout();
      // if ($this->vendor->load()) {
      // }
    }
  }
}