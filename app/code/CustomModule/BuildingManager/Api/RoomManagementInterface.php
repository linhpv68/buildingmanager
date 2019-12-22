<?php
/**
 * cms-nckh - RoomManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 13/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;

interface RoomManagementInterface
{


    /**
     * @param string $projectId
     * @return mixed
     */
    public function getByProject($projectId);

    /**
     * @param string $token
     * @return mixed
     */
    public function getByUser($token);

}