<?php

namespace Ambab\EMI\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
   
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

      
        $dataemiRows = [
            [
                'bank_name' => 'SBI BANK',
                'emi_plan' => 3,
                'interest_rate' => 15
            ],
            [
                'bank_name' => 'HDFC BANK',
                'emi_plan' => 3,
                'interest_rate' => 15
            ]
        ];
        
        foreach($dataemiRows as $data) {
            $setup->getConnection()->insert($setup->getTable('emi'), $data);
        }
        
    }
}
?>

