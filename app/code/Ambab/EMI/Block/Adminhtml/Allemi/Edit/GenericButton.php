<?php
namespace Ambab\EMI\Block\Adminhtml\Allemi\Edit;

use Magento\Backend\Block\Widget\Context;
use Ambab\EMI\Api\AllemiRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allemiRepository;
    
    public function __construct(
        Context $context,
        AllemiRepositoryInterface $allemiRepository
    ) {
        $this->context = $context;
        $this->allemiRepository = $allemiRepository;
    }

    public function getEMI_Id()
    {
        try {
            return $this->allemiRepository->getById(
                $this->context->getRequest()->getParam('emi_id')
            )->getEMI_Id();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>
