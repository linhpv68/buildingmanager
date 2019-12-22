<?php
/**
 * cms-nckh - UserInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api\Data;


use Magento\Customer\Api\Data\CustomerInterface;

interface UserInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const EMAIL = 'email';
    const FULLNAME = 'fullname';
    const PHONENUMBER = 'phonenumber';
    const STATUS = 'status';

    /**#@-*/

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set customer id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get email address
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email address
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName();

    /**
     * Set full name
     *
     * @param string $fullname
     * @return $this
     */
    public function setFullName($fullname);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param string $numberphone
     * @return $this
     */
    public function setPhoneNumber($numberphone);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

}