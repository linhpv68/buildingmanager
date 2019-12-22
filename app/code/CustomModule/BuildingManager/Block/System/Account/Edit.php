<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 25/08/2019
 *
 */

namespace CustomModule\BuildingManager\Block\System\Account;



class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @return void
     */


    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'Magento_Backend';
        $this->_controller = 'system_account';
        $this->buttonList->update('save', 'label', __('Lưu'));
        $this->buttonList->remove('delete');
        $this->buttonList->remove('back');
        $this->buttonList->remove('reset');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Tài khoản của bạn');
    }

}
