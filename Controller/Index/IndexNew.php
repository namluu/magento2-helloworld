<?php
declare(strict_types=1);

namespace Namluu\Helloworld\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Sales\Model\OrderFactory;

class IndexNew implements HttpGetActionInterface
{
    /**
     * @var OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    public function __construct(
        RequestInterface $request,
        JsonFactory $jsonFactory,
        OrderFactory $orderFactory
    ) {
        $this->_orderFactory = $orderFactory;
        $this->request = $request;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        $orderId = (int) $this->request->getParam('id');
        $order = $this->_orderFactory->create();
        $order->load($orderId);

        $orderData = [];
        if ($order->getId()) {
            $orderData['status'] = $order->getStatus();
            $orderData['total'] = $order->getGrandTotal();
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = [
                    'sku' => $item->getSku(),
                    'item_id' => $item->getId(),
                    'price' => $item->getPriceInclTax()
                ];
            }
            $orderData['items'] = $items;
            $orderData['total_invoiced'] = $order->getTotalInvoiced();
        } else {
            $orderData = 'Hello World!';
        }

        return $this->jsonFactory->create()->setData($orderData);
    }
}
