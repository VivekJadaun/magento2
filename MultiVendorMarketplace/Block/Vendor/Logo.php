<?php
namespace Vinsol\MultiVendorMarketplace\Block\Vendor;

class Logo extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::logo.phtml';
  protected $username;
  protected $session;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    array $data = []
  )
  {
    parent::__construct($context, $data);
  }

  public function _prepareLayout()
  {
    parent::_prepareLayout();
  }
}