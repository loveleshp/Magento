<?php
namespace Ambab\EMI\Api\Data;

interface AllemiInterface
{
	const EMI_ID = 'emi_id';
	const Bank_Name  = 'bank_name';
	const EMI_Plan = 'emi_plan';
	const Interest_Rate = 'interest_rate';

	public function getEMI_Id();

	public function getBank_Name();

	public function getEMI_Plan();

	public function getInterest_Rate();

	public function setEMI_Id($emi_id);

	public function setBank_Name($bank_name);

	public function setEMI_Plan($emi_plan);

	public function setInterest_Rate($interest_rate);

}
?>
