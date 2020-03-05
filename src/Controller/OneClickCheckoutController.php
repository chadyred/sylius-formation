<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order\OrderItem;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use SM\StateMachine\StateMachine;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductVariantRepository;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Context\ShopperContext;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Factory\OrderItemUnitFactoryInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class OneClickCheckoutController
{
    public function checkoutAction(
        FactoryInterface $orderFactory,
        FactoryInterface $orderItemFactory,
        OrderRepositoryInterface $orderRepository,
        ProductVariantRepository $productVariantRepository,
        ChannelContextInterface $channelContext,
        OrderProcessorInterface $orderProcessor,
        OrderItemUnitFactoryInterface $orderItemUnitFactory,
        ShopperContext $shopperContext,
        StateMachineFactoryInterface $smf,
        UrlGeneratorInterface $urlGenerator,
        int $variantId
    )
    {
        $customer = $shopperContext->getCustomer();

        /** @var OrderInterface $order */
        $order = $orderFactory->createNew();
        $order->setCustomer($customer);

        // assign channel, currency and locale to the order
        $order->setChannel($shopperContext->getChannel());
        $order->setCurrencyCode($shopperContext->getCurrencyCode());
        $order->setLocaleCode($shopperContext->getLocaleCode());

        $order->setChannel($channelContext->getChannel());
        $variant = $productVariantRepository->find($variantId);

        /** @var OrderItem $item */
        $item = $orderItemUnitFactory->createNew();
        $item->setVariant($variant);
        $order->addItem($item);

        $orderProcessor->process($order);

        // complete the checkout with the state machine
        /** @var StateMachine $stateMachine */
        $stateMachine = $smf->get($order, OrderCheckoutTransitions::GRAPH);
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_ADDRESS);
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING);
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);


        // persist the order
        $orderRepository->add($order);

        // redirect the customer to order show page
        return new RedirectResponse($urlGenerator->generate(
            'sylius_shop_account_order_show',
            ['number' => $order->getNumber()]
        ));

    }
}
