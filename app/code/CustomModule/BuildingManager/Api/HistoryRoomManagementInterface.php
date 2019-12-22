<?php
/**
 * cms-nckh - HistoryRoomManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 15/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;

use CustomModule\BuildingManager\Api\Data\HistoryRoomInterface;

interface HistoryRoomManagementInterface
{


    /**
     * @param string $roomId
     * @param string $dateCreate
     * @param string $token
     * @param string $content
     * @return mixed
     */
    public function saveData($roomId, $dateCreate, $token, $content);

    /**
     * @param string $roomId
     * @return mixed
     */
    public function getByRoomId($roomId);

}