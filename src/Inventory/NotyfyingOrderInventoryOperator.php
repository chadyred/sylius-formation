<?php

declare(strict_types=1);

namespace App\Inventory;

use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Inventory\Operator\OrderInventoryOperatorInterface;
use Sylius\Component\Core\Model\OrderInterface;

class NotyfyingOrderInventoryOperator implements OrderInventoryOperatorInterface
{
    private  $decorateOperator;
    private  $logger;

    public function __construct(
        OrderInventoryOperatorInterface $orderInventoryOperator,
        LoggerInterface $logger
    )
    {
        $this->decorateOperator = $orderInventoryOperator;
        $this->logger = $logger;
    }

    public function cancel(OrderInterface $order): void
    {
        $this->decorateOperator->cancel($order);

        foreach ($order->getItems() as $orderItem) {
            $this->logger->log('info',$orderItem->getProduct()->getName());
        }
    }

    public function hold(OrderInterface $order): void
    {
        $this->decorateOperator->hold($order);
    }

    public function sell(OrderInterface $order): void
    {
        $this->decorateOperator->sell($order);

        foreach ($order->getItems() as $orderItem) {
            $this->logger->log('info',$orderItem->getProduct()->getName());
        }
    }
}
