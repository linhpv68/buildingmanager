<?php
/**
 * cms-nckh - UserManagementInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api;


use CustomModule\BuildingManager\Api\Data\UserInterface;
use Magento\Framework\Exception\LocalizedException;

interface UserManagementInterface {


    /**
     * login a customer by username and password
     *
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws LocalizedException
     */
    public function login($email, $password);


    /**
     * @param string $token
     * @param string $password
     * @param string $new_password
     * @return mixed
     */
    public function changePassword($token, $password, $new_password);
}