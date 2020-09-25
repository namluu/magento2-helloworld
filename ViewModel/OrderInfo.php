<?php
namespace Namluu\Helloworld\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;
class OrderInfo implements ArgumentInterface
{
    public $data;

    public $countryInformationAcquirer;

    public function __construct(
        \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformationAcquirer
    )
    {
        $this->countryInformationAcquirer = $countryInformationAcquirer;
    }


    public function setOrder($data)
    {
        $this->data = $data;
    }

    public function getOrder()
    {
        return $this->data;
    }

    public function getCountryName()
    {
        //$countryId = $this->data->getExtensionAttributes();
        $countryId = 'AU';
        $country = $this->countryInformationAcquirer->getCountryInfo($countryId);
        return $country->getFullNameEnglish();
    }
}
