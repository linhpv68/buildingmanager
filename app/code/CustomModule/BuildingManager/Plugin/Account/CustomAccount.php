<?php
/**
 * cms-nckh - CustomAccount.php
 *
 * Initial version by: linhphung
 * Initial version create on : 24/08/2019
 *
 */

namespace CustomModule\BuildingManager\Plugin\Account;


class CustomAccount
{

    public function afterHeaderBarAction(\Magento\Setup\Controller\Navigation $subject, $result){

        $a = $subject;
        $b = $result;
        return $result;
    }

}