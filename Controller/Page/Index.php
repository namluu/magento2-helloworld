<?php
declare(strict_types=1);

namespace Namluu\Helloworld\Controller\Page;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Model\OrderFactory;
use Namluu\Helloworld\ViewModel\OrderInfo;

class Index implements HttpGetActionInterface
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
     * @var PageFactory
     */
    private $pageFactory;

    private $viewModel;

    public function __construct(
        RequestInterface $request,
        PageFactory $pageFactory,
        OrderFactory $orderFactory,
        OrderInfo $viewModel
    ) {
        $this->_orderFactory = $orderFactory;
        $this->request = $request;
        $this->pageFactory = $pageFactory;
        $this->viewModel = $viewModel;
    }

    public function execute()
    {
        $orderId = (int) $this->request->getParam('id');
        $order = $this->_orderFactory->create();
        $order->load($orderId);
        $this->viewModel->setOrder($order);

        return $this->pageFactory->create();
    }
}
