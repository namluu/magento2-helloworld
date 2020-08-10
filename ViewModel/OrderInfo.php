<?php
namespace Namluu\Helloworld\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;
class OrderInfo implements ArgumentInterface
{
    public $data;

    public function setOrder($data)
    {
        $this->data = $data;
    }

    public function getOrder()
    {
        return $this->data;
    }
}
