<?php
/**
 * cms-nckh - UserSearchResultsInterface.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Api\Data;



interface UserSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get customers list.
     *
     * @return \CustomModule\BuildingManager\Api\Data\UserInterface[]
     */
    public function getItems();

    /**
     * Set customers list.
     *
     * @param \CustomModule\BuildingManager\Api\Data\UserInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}