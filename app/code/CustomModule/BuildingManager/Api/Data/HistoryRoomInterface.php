<?php
/**
 * cms-nckh - HistoryRoomInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 20/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api\Data;


interface HistoryRoomInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const DATE_CREATE = 'date_create';
    const USER_ID = 'user_id';
    const ROOM_ID = 'room_id';
    const CONTENT = 'content';
    /**#@-*/

    /**
     * Get HistoryRoom id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set HistoryRoom id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get DateCreate
     *
     * @return string|null
     */
    public function getDateCreate();

    /**
     * Set DateCreate
     * @param string $date
     * @return $this
     */
    public function setDateCreate($date);

    /**
     * Get UserID
     *
     * @return int|null
     */
    public function getUserID();

    /**
     * Set UserID
     * @param int $id
     * @return $this
     */
    public function setUserID($id);


    /**
     * Get RoomID
     *
     * @return int|null
     */
    public function getRoomID();

    /**
     * Set RoomID
     * @param int $id
     * @return $this
     */
    public function setRoomID($id);


    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set Content
     * @param string $content
     * @return $this
     */
    public function setContent($content);

}