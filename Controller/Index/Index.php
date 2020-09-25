<?php
namespace Namluu\Helloworld\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    protected $getSourceItemsBySku;

    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        \Magento\InventoryApi\Api\GetSourceItemsBySkuInterface $getSourceItemsBySku
    ) {
        $this->_orderFactory = $orderFactory;
        $this->getSourceItemsBySku = $getSourceItemsBySku;
        parent::__construct($context);
    }

    public function execute()
    {
        $orderId = (int) $this->getRequest()->getParam('id');
        $order = $this->_orderFactory->create();
        $order->load($orderId);

        $orderData = [];
        if ($order->getId()) {
            $orderData['status'] = $order->getStatus();
            $orderData['total'] = $order->getGrandTotal();
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $sources = $this->getSourceItemsBySku->execute($item->getSku());
                $sourceCode = [];
                foreach ($sources as $source) {
                    $sourceCode[] = $source->getSourceCode();
                    // call API to check $sourceCode and $sku
                }
                $items[] = [
                    'sku' => $item->getSku(),
                    'item_id' => $item->getId(),
                    'price' => $item->getPriceInclTax(),
                    'warehouses' => $sourceCode
                ];
            }
            $orderData['items'] = $items;
            $orderData['total_invoiced'] = $order->getTotalInvoiced();



        } else {
            $orderData = 'Hello World!';
        }

        $this->getResponse()->setBody(json_encode($orderData));
    }
}
