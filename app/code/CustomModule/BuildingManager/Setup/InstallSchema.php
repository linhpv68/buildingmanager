<?php
/**
 * magento2 - InstallSchema.php
 *
 * Initial version by: linhphung
 * Initial version create on : 04/07/2019
 *
 */

namespace CustomModule\BuildingManager\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    protected $_setup;

    public function __construct(SchemaSetupInterface $setup)
    {
        $this->_setup = $setup;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;

        $installer->startSetup();

        $this->TableUser($installer);

        $this->TableModel($installer);

        $this->TableDevice($installer);

        $this->TableProject($installer);

        $this->TableRoom($installer);

        $this->TableRoomDevice($installer);

        $this->TableUserRoom($installer);

        $this->TableHistoryRoom($installer);

        $installer->endSetup();
        // TODO: Implement install() method.
    }

    /**
     * @param $installer /Magento/Framework/Setup/SchemaSetupInterface;
     */
    public function TableUser($installer)
    {

        $user = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_user'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'fullname',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true],
                'Họ tên người dùng'
            )
            ->addColumn(
                'password',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Mật khẩu'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'Email người dùng, sử dụng cho lần đăng nhập đầu tiên'
            )
            ->addColumn(
                'phonenumber',
                Table::TYPE_INTEGER,
                10,
                ['nullable' => true],
                'Số điện thoại'
            )
            ->addColumn(
                'status',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Trạng thái hoạt động
'
            )
            ->setComment('custom_module_user Table');
        $installer->getConnection()->createTable($user);

    }

    public function TableModel($installer)
    {
        $model = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_model'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true],
                'Tên mô hình'
            )
            ->addColumn(
                'source',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true],
                'Tài nguyên lưu trữ mô hình'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Mô tả'
            )
            ->addColumn(
                'datecreate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Ngày tạo'
            )
            ->setComment('custom_module_model Table');
        $installer->getConnection()->createTable($model);
    }

    public function TableDevice($installer)
    {

        $device = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_device'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Chủng loại'
            )
            ->addColumn(
                'size',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                null,
                ['nullable' => true],
                'Kích thước'
            )
            ->addColumn(
                'datecreate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Ngày sản xuất'
            )
            ->addColumn(
                'manufacturer',
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Hãng sản xuất'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Mô tả thiết bị'
            )
            ->setComment('custom_module_device Table');
        $installer->getConnection()->createTable($device);

    }

    public function TableProject($installer)
    {

        $project = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_project'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'Định danh dự án')
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'Tên dự án'
            )
            ->addColumn(
                'address',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true],
                'Địa chỉ dự án'
            )
            ->addColumn(
                'image',
                Table::TYPE_TEXT,
                500,
                ['nullable' => true],
                'Ảnh đại diện của dự án'
            )
            ->addColumn(
                'ImageList',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Danh sách ảnh mô tả của dự án'
            )
            ->addColumn(
                'Lat',
                Table::TYPE_FLOAT,
                null,
                ['nullable' => true],
                'Vĩ độ'
            )->addColumn(
                'Lng',
                Table::TYPE_FLOAT,
                null,
                ['nullable' => true],
                'Kinh độ. Nhằm lưu trữ chính xác vị trí của dự án trên bản đồ khi cần sử dụng định vị.'
            )
            ->addColumn(
                'investor',
                Table::TYPE_TEXT,
                250,
                ['nullable' => true],
                'Chủ đầu tư dự án'
            )->addColumn(
                'email',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true],
                'Email chủ dự án'
            )->addColumn(
                'phonenumber',
                Table::TYPE_TEXT,
                10,
                ['nullable' => true],
                'Số điện thoại chủ đầu tư'
            )->addColumn(
                'website',
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Website chủ đầu tư/dự án'
            )->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Mô tả dự án'
            )
            ->addColumn(
                'modelId',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true, 'unsigned' => true],
                'Mã mô hình'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'custom_module_project',
                    'modelId',
                    'custom_module_model',
                    'id'
                ),
                'modelId',
                $installer->getTable('custom_module_model'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->setComment('custom_module_project Table');

        $installer->getConnection()->createTable($project);
    }

    public function TableRoom($installer)
    {

        $room = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_room'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'Định danh căn hộ')
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'Tên căn hộ'
            )
            ->addColumn(
                'address',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true],
                'Địa chỉ căn hộ'
            )
            ->addColumn(
                'image',
                Table::TYPE_TEXT,
                500,
                ['nullable' => true],
                'Ảnh đại diện của căn hộ'
            )
            ->addColumn(
                'ImageList',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Danh sách ảnh mô tả của căn hộ'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Mô tả căn hộ'
            )->addColumn(
                'projectID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Mã định danh dự án, cho biết căn hộ thuộc dự án nào'
            )->addColumn(
                'modelID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true, 'unsigned' => true],
                'Mã mô hình'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'custom_module_room',
                    'projectID',
                    'custom_module_project',
                    'id'
                ),
                'projectID',
                $installer->getTable('custom_module_project'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )->addForeignKey(
                $installer->getFkName(
                    'custom_module_room',
                    'modelID',
                    'custom_module_model',
                    'id'
                ),
                'modelID',
                $installer->getTable('custom_module_model'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->setComment('custom_module_room Table');
        $installer->getConnection()->createTable($room);

    }

    public function TableRoomDevice($installer)
    {

        $roomDevice = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_room_device'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id'
            )
            ->addColumn(
                'deviceID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Mã thiết bị'
            )->addColumn(
                'installdate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Ngày lắp đặt'
            )->addColumn(
                'modifydate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Ngày thay thế'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'custom_module_room_device',
                    'deviceID',
                    'custom_module_device',
                    'id'

                ),
                'deviceID',
                $installer->getTable('custom_module_device'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'roomID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Mã căn hộ'
            )
            ->addForeignKey(
                $installer->getFkName(

                    'custom_module_room_device',
                    'roomID',
                    'custom_module_room',
                    'id'
                ),
                'roomID',
                $installer->getTable('custom_module_room'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Mô tả'
            )
            ->setComment('custom_module_room_device Table');
        $installer->getConnection()->createTable($roomDevice);

    }

    public function TableUserRoom($installer)
    {
        $userRoom = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_user_room'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'userID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Mã người dùng')
            ->addForeignKey(
                $installer->getFkName(

                    'custom_module_user_room',
                    'userID',
                    'custom_module_user',
                    'id'
                ),
                'userID',
                $installer->getTable('custom_module_user'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'roomID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Mã căn hộ')
            ->addForeignKey(
                $installer->getFkName(

                    'custom_module_user_room',
                    'roomID',
                    'custom_module_room',
                    'id'
                ),
                'roomID',
                $installer->getTable('custom_module_room'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Mô tả'
            )
            ->setComment('custom_module_user_room Table');
        $installer->getConnection()->createTable($userRoom);
    }

    public function TableHistoryRoom($installer)
    {
        $historyRoom = $installer->getConnection()
            ->newTable($installer->getTable('custom_module_history_room'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'primary' => true, 'identity' => true, 'unsigned' => true],
                'id')
            ->addColumn(
                'datecreate',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Ngày sửa chữa'
            )
            ->addColumn(
                'userID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,'unsigned' => true],
                'Chủ hộ'
            )
            ->addForeignKey(
                $installer->getFkName(

                    'custom_module_history_room',
                    'userID',
                    'custom_module_user',
                    'id'
                ),
                'userID',
                $installer->getTable('custom_module_user'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'roomID',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,'unsigned' => true],
                'Mã căn hộ'
            )
            ->addForeignKey(
                $installer->getFkName(

                    'custom_module_history_room',
                    'roomID',
                    'custom_module_room',
                    'id'
                ),
                'roomID',
                $installer->getTable('custom_module_room'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addColumn(
                'content',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Nội dung sửa chữa'
            )
            ->setComment('custom_module_history_room Table');
        $installer->getConnection()->createTable($historyRoom);
    }


}