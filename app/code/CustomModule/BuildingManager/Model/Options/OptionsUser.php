<?php
/**
 * cms-nckh - OptionsUser.php
 *
 * Initial version by: linhphung
 * Initial version create on : 25/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\Options;


use Magento\Framework\Option\ArrayInterface;

class OptionsUser implements ArrayInterface
{
    protected $_modelFactory;

    public function __construct(
        \CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory $modelFactory
    )
    {
        $this->_modelFactory = $modelFactory;
    }

    public function toOptionArray()
    {
        $collection =  $this->_modelFactory->create();
        $models = $collection->getData();
        $options = [];
        $options[] = [
            'label' => ' ',
            'value' => ''
        ];
        foreach ($models as $model){
            $options[] = [
                'label' => $model['fullname'],
                'value' => $model['id']
            ];
        }
        return $options;
    }

}