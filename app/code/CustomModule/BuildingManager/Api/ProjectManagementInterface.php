<?php
/**
 * cms-nckh - ProjectManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 13/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;


use CustomModule\BuildingManager\Api\Data\UserInterface;
use Magento\Framework\Exception\LocalizedException;

interface ProjectManagementInterface{

    /**
     * @return mixed
     */
    public function view();

    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id);
}