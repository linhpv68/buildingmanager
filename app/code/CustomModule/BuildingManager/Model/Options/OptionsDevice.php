<?php
/**
 * cms-nckh - OptionsDevice.php
 *
 * Initial version by: linhphung
 * Initial version create on : 27/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\Options;


use Magento\Framework\Option\ArrayInterface;

class OptionsDevice implements ArrayInterface
{
    protected $_modelFactory;

    public function __construct(
        \CustomModule\BuildingManager\Model\ResourceModel\Device\CollectionFactory $modelFactory
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
                'label' => $model['type'],
                'value' => $model['id']
            ];
        }
        return $options;
    }

}