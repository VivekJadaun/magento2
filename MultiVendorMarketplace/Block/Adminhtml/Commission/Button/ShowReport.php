<?php
namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml\Commission\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ShowReport extends Generic implements ButtonProviderInterface
{

    public function getButtonData()
    {
        return [
            'label' => __('Show Report'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            // 'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'url' => '*/*/*',
            'sort_order' => 80,
        ];
    }
}