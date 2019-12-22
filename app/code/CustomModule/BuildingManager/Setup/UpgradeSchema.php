<?php
/**
 * cms-nckh - UpgradeSchema.php
 *
 * Initial version by: linhphung
 * Initial version create on : 29/08/2019
 *
 */

namespace CustomModule\BuildingManager\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.9') < 0) {


            $setup->getConnection()->dropForeignKey(
                $setup->getTable('oauth_token'),
                $setup->getFkName('oauth_token', 'customer_id', 'customer_entity', 'entity_id')
            );

            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    'oauth_token',
                    'customer_id',
                    'custom_module_user',
                    'id'),
                $setup->getTable('oauth_token'),
                'customer_id',
                $setup->getTable('custom_module_user'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        }
        if (version_compare($context->getVersion(), '1.0.8') < 0) {
            $this->createTableFavorite($setup);
        }
        $setup->endSetup();
    }

    /**
     * @param $setup
     */
    private function createTableFavorite($setup){
        $favorite = $setup->getConnection()
            ->newTable($setup->getTable('custom_module_favorite'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'id_user',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true,'unsigned' => true],
                'Id User'
            )
            ->addColumn(
                'id_project',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false,'unsigned' => true],
                'Id Project'
            )
            ->addColumn(
                'datecreate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Ngày tạo'
            )
            ->addForeignKey(
                $setup->getFkName(
                    'custom_module_favorite',
                    'id_project',
                    'custom_module_project',
                    'id'
                ),
                'id_project',
                $setup->getTable('custom_module_project'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addForeignKey(
                $setup->getFkName(

                    'custom_module_favorite',
                    'id_user',
                    'custom_module_user',
                    'id'
                ),
                'id_user',
                $setup->getTable('custom_module_user'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->setComment('custom_module_favorite Table');
        $setup->getConnection()->createTable($favorite);
    }

}