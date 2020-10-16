<?php
namespace Namluu\Helloworld\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Sales\Model\OrderFactory;
class OrderInfo implements ArgumentInterface
{
    public $data;

    public $countryInformationAcquirer;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformationAcquirer,
        RequestInterface $request,
        OrderFactory $orderFactory
    )
    {
        $this->countryInformationAcquirer = $countryInformationAcquirer;
        $this->orderFactory = $orderFactory;
        $this->request = $request;
    }

    public function getOrder()
    {
        $orderId = (int) $this->request->getParam('id');
        $order = $this->orderFactory->create();
        $order->load($orderId);
        return $order;
    }

    public function getCountryName()
    {
        //$countryId = $this->data->getExtensionAttributes();
        $countryId = 'AU';
        $country = $this->countryInformationAcquirer->getCountryInfo($countryId);
        return $country->getFullNameEnglish();
    }
}
