<?php
/**
 * cms-nckh - Json.php
 *
 * Initial version by: linhphung
 * Initial version create on : 08/09/2019
 *
 */

namespace CustomModule\BuildingManager\Webapi\Rest\Response\Renderer;
use Magento\Framework\Webapi\Rest\Response\Renderer\Json;

class CustomJson extends Json
{
    public function render($data)
    {
        if (isset($data[0]) && isset($data[1])){
            $arr = array(
                'success'=>$data[0],
                'data'=>$data[1]
            );
            return json_encode($arr);
        }else{
            return $this->encoder->encode($data);
        }

    }
}