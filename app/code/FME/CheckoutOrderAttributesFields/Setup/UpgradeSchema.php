<?php
//declare(strict_types=1);
/**
 * FME_CheckoutOrderAttributesFields extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category  FME
 * @package   FME_CheckoutOrderAttributesFields

 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)

 */

namespace FME\CheckoutOrderAttributesFields\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.Generic.CodeAnalysis.UnusedFunctionParameter)
     */

    // @codingStandardsIgnoreStart
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)

    // @codingStandardsIgnoreEnd
    {
        $installer = $setup;
        $installer->startSetup();
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('eav_attribute'),
                'fme_email',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'default'  => 0,
                    'length'   => '1',
                    'comment'  => 'Add checkout order attribute to Email',
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('eav_attribute'),
                'fme_country',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'default'  => '',
                    'comment'  => 'Dependent country',
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('eav_attribute'),
                'fme_pdf',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'default'  => 0,
                    'length'   => '1',
                    'comment'  => 'Add checkout order attribute to PDF',
                ]
            );
        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_extensions',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default'  => '',
                'length'   => '255',
                'comment'  => 'Allowed file extensions',
            ]
        );
        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_max_size',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default'  => '',
                'length'   => '255',
                'comment'  => 'Allowed file max size',
            ]
        );
        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_dependable',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'nullable' => true,
                'default'  => 0,
                'length'   => '1',
                'comment'  => 'Is Dependable',
            ]
        );

        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_dpath',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default'  => '',
                'length'   => '255',
                'comment'  => 'Dependency Path',
            ]
        );

        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_dcode',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default'  => '',
                'length'   => '255',
                'comment'  => 'Dependency Code',
            ]
        );
        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_did',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'nullable' => true,
                'default'  => 0,
                'length'   => '11',
                'comment'  => 'Dependable id',
            ]
        );

        $setup->getConnection()->addColumn(
            $installer->getTable('eav_attribute'),
            'fme_dvalue',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default'  => '',
                'length'   => '255',
                'comment'  => 'Dependency Value',
            ]
        );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('quote'),
                'coaf',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'default'  => null,
                    'comment'  => 'Add checkout order attribute to quote',
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'coaf',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'default'  => null,
                    'comment'  => 'Add checkout order attribute to order',
                ]
            );
        if (!$installer->tableExists('fme_checkoutorderattributesfields_stores')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('fme_checkoutorderattributesfields_stores'));
            $table->addColumn(
                    'attribute_id',
                    Table::TYPE_SMALLINT,
                    5,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    11,
                    [
                        'unsigned'  => true,
                        'nullable'  => false,
                        'primary'   => true,
                    ],
                    'Store ID'
                ) ->addIndex(
                    $installer->getIdxName('fme_checkoutorderattributesfields_stores', ['attribute_id']),
                    ['attribute_id']
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_stores',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $installer->getTable('eav_attribute'),
                    'attribute_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Assigned stores');

            $installer->getConnection()->createTable($table);

        }
        if (!$installer->tableExists('fme_checkoutorderattributesfields_customer_group')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('fme_checkoutorderattributesfields_customer_group'));
            $table->addColumn(
                    'attribute_id',
                    Table::TYPE_SMALLINT,
                    5,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Attribute Id'
                )
                ->addColumn(
                    'group_id',
                    Table::TYPE_INTEGER,
                    11,
                    [
                        'unsigned'  => true,
                        'nullable'  => false,
                        'primary'   => true,
                    ],
                    'Customer Group ID'
                ) ->addIndex(
                    $installer->getIdxName('fme_checkoutorderattributesfields_customer_group', ['attribute_id']),
                    ['attribute_id']
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_customer_group',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $installer->getTable('eav_attribute'),
                    'attribute_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Assigned Customers Group');
            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('fme_checkoutorderattributesfields_orders')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('fme_checkoutorderattributesfields_orders'));
            $table->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Record Id'
                )->addColumn(
                    'order_id',
                    Table::TYPE_INTEGER,
                    10,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Order Id'
                )
                ->addColumn(
                    'attribute_id',
                    Table::TYPE_SMALLINT,
                    5,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Attribute Id'
                )
                ->addColumn(
                    'fme_email',
                    Table::TYPE_SMALLINT,
                    1,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Include in emails'
                )
                ->addColumn(
                    'fme_pdf',
                    Table::TYPE_SMALLINT,
                    1,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Include in pdf'
                )
                ->addColumn(
                    'attribute_code',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false,
                    ],
                    'Attribute Code'
                )
                ->addColumn(
                    'admin_label',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false,
                    ],
                    'Attribute Admin Label'
                )
                ->addColumn(
                    'label',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false,
                    ],
                    'Attribute Label'
                )
                ->addColumn(
                    'value',
                    Table::TYPE_TEXT,
                    NULL,
                    [
                    ],
                    'Attribute Value'
                )->addColumn(
                    'value_id',
                    Table::TYPE_TEXT,
                    NULL,
                    [
                    ],
                    'Attribute Value ids'
                )->addIndex(
                    $installer->getIdxName('fme_checkoutorderattributesfields_orders', ['order_id']),
                    ['order_id']
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_orders',
                        'order_id',
                        'sales_order',
                        'entity_id'
                    ),
                    'order_id',
                    $installer->getTable('sales_order'),
                    'entity_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Attribute Values for orders');
            $installer->getConnection()->createTable($table);
        } else {
            $setup->getConnection()
            ->addColumn(
                $setup->getTable('fme_checkoutorderattributesfields_orders'),
                'value_id',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'default'  => null,
                    'comment'  => 'Attribute Value ids',
                ]
            );
        }


        if (!$installer->tableExists('fme_checkoutorderattributesfields_product')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('fme_checkoutorderattributesfields_product'));
            $table
            ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    10,
                    [
                      'unsigned' => true,
                      'nullable' => false,
                      'primary' => true

                    ],
                    'Attribute Id'
                )
                ->addColumn(
                        'attribute_id',
                        Table::TYPE_SMALLINT,
                        5,
                        [
                          'unsigned' => true,
                          'nullable' => false,
                          'primary' => true
                        ],
                        'Attribute Id'
                    )
                 
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_product',
                        'product_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_product',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $installer->getTable('eav_attribute'),
                    'attribute_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Assigned Customers Group');
            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('fme_checkoutorderattributesfields_category')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('fme_checkoutorderattributesfields_category'));
            $table
            ->addColumn(
                    'category_id',
                    Table::TYPE_INTEGER,
                    10,
                    [
                      'unsigned' => true,
                      'nullable' => false,
                      'primary' => true

                    ],
                    'Attribute Id'
                )
                ->addColumn(
                        'attribute_id',
                        Table::TYPE_SMALLINT,
                        5,
                        [
                          'unsigned' => true,
                          'nullable' => false,
                          'primary' => true
                        ],
                        'Attribute Id'
                    )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_category',
                        'category_id',
                        'catalog_category_entity',
                        'entity_id'
                    ),
                    'category_id',
                    $installer->getTable('catalog_category_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'fme_checkoutorderattributesfields_category',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $installer->getTable('eav_attribute'),
                    'attribute_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Assigned Customers Group');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
