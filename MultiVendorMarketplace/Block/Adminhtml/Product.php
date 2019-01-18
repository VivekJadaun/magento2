<?php
namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml;

class Product extends \Magento\Catalog\Block\Adminhtml\Product
{
    protected function _getProductCreateUrl($type)
    {
        return $this->getUrl(
            'catalog/product/new',
            ['set' => $this->_productFactory->create()->getDefaultAttributeSetId(), 'type' => $type]
        );
    }

}
