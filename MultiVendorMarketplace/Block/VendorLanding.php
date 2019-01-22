<?php
namespace Vinsol\MultiVendorMarketplace\Block;

class VendorLanding extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::vendor.phtml';
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