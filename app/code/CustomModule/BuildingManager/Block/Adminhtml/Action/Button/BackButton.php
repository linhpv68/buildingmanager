<?php
/**
 * cms-nckh - BackButton.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Block\Adminhtml\Action\Button;

use Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        // TODO: Implement getButtonData() method.
        return [
            'label' => __('Trở Lại'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }

}
