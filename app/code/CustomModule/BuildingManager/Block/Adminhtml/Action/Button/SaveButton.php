<?php
/**
 * cms-nckh - SaveButton.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Block\Adminhtml\Action\Button;




use Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{

    public function getButtonData()
    {
        // TODO: Implement getButtonData() method.
        return [
            'label' => __('Lưu'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'create']],
                'form-role' => 'create',
            ],
            'sort_order' => 90,
        ];
    }

}