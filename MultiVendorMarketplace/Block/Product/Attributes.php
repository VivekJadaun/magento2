<?php
namespace Vinsol\MultiVendorMarketplace\Block\Product;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Attributes extends \Magento\Catalog\Block\Product\View\Attributes
{
  protected $vendorCollectionFactory;
  function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\Registry $registry,
    PriceCurrencyInterface $priceCurrency,
    \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory,
    array $data = []
  )
  {
    $this->vendorCollectionFactory = $vendorCollectionFactory;
    parent::__construct($context, $registry, $priceCurrency, $data);
  }

  public function getVendorCollection()
  {
    return $this->vendorCollectionFactory->create();
  }
}