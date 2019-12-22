<?php
/**
 * cms-nckh - UpgradeData.php
 *
 * Initial version by: linhphung
 * Initial version create on : 11/09/2019
 *
 */

namespace CustomModule\BuildingManager\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.7') < 0) {
            // Get module table
            $tableName = $setup->getTable('custom_module_device');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) == true) {
            // Declare data
                $columns = [
                    'user_guide' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'User Guide',
                    ],
                    'modelID' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'comment' => 'modelID',
                    ],
                ];
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }
        $setup->endSetup();
        // TODO: Implement upgrade() method.
    }
}