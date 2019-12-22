<?php
/**
 * cms-nckh - DeviceManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;


interface DeviceManagementInterface {

    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param string $token
     * @param mixed $data
     * @return mixed
     */
    public function updateByAdmin($token, $data);
}