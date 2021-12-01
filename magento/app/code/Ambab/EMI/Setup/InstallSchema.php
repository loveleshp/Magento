<?php
namespace Ambab\EMI\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    
  public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
  {
    
    $emiTableName = $setup->getTable('emi');

    if($setup->getConnection()->isTableExists($emiTableName) != true) {

      $emiTable = $setup->getConnection()
          ->newTable($emiTableName)
          ->addColumn(
              'emi_id',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
              'Emi ID'
          )
          ->addColumn(
              'bank_name',
              \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
              255,
              ['nullable' => false, 'default' => ''],
                'Bank_Name'
          )
          ->addColumn(
              'emi_plan',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['nullable' => false,],
                'EMI Plan'
          )
          ->addColumn(
              'interest_rate',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['nullable' => false, 'unsigned' => true],
                'Interest Rate'
          )
          
          ->addIndex(
            $setup->getIdxName('emi', ['bank_name']),
            ['bank_name']
          )
          ->setComment("emi Table");

      $setup->getConnection()->createTable($emiTable);
    }
    
  }
}
?>
