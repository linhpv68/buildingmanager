<?php
/**
 * cms-nckh - DeviceManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;


interface FavoriteManagementInterface {

    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param string $token
     * @param string $idProject
     * @return mixed
     */
    public function add($token, $idProject);

    /**
     * @param string $token
     * @return mixed
     */
    public function getByUser($token);
}