<?php
namespace Ambab\EMI\Api;

interface AllemiRepositoryInterface
{
	public function save(\Ambab\EMI\Api\Data\AllemiInterface $emi);

    public function getById($emi_id);

    public function delete(\Ambab\EMI\Api\Data\AllemiInterface $emi);

    public function deleteById($emi_id);
}
?>
