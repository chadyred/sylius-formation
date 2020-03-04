<?php

declare(strict_types=1);

namespace spec\App\Shipping;

use App\Shipping\CustomCalculator;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;

final class CustomCalculatorSpec extends ObjectBehavior
{
    function it_is_a_shipping_calculator(): void
    {
        $this->shouldImplement(CalculatorInterface::class);
    }

    function it_costs_2000_of_local_currency_if_there_are_no_jeans(
        ShipmentInterface $shipment,
        OrderInterface $order,
        ChannelInterface $channel
    ): void
    {
        $shipment->getOrder()->willReturn($order);
        $order->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn('CHANNEL_CODE');

        $shipment->getUnits()->willReturn(new ArrayCollection([]));

        $this->calculate($shipment, ['CHANNEL_CODE' => ['fee' => 1000]])->shouldReturn(2000);
    }

    function it_adds_1000_local_currency_for_each_pair_of_jeans(
        ShipmentInterface $shipment,
        OrderItemUnitInterface $firstPairOfJeansUnit,
        OrderItemUnitInterface $secondPairOfJeansUnit,
        OrderItemUnitInterface $capUnit,
        ProductVariantInterface $pairOfJeansVariant,
        ProductVariantInterface $capVariant,
        ProductInterface $pairOfJeansProduct,
        ProductInterface $capProduct,
        TaxonInterface $jeansTaxon,
        TaxonInterface $capTaxon,
        TaxonInterface $clothesTaxon,
        OrderInterface $order,
        ChannelInterface $channel
    ): void
    {
        $shipment->getUnits()->willReturn(new ArrayCollection([
            $firstPairOfJeansUnit->getWrappedObject(),
            $secondPairOfJeansUnit->getWrappedObject(),
            $capUnit->getWrappedObject(),
        ]));

        $firstPairOfJeansUnit->getShippable()->willReturn($pairOfJeansVariant);
        $secondPairOfJeansUnit->getShippable()->willReturn($pairOfJeansVariant);
        $capUnit->getShippable()->willReturn($capVariant);

        $pairOfJeansVariant->getProduct()->willReturn($pairOfJeansProduct);
        $capVariant->getProduct()->willReturn($capProduct);

        $pairOfJeansProduct->getTaxons()->willReturn(new ArrayCollection([
            $clothesTaxon->getWrappedObject(),
            $jeansTaxon->getWrappedObject(),
        ]));
        $capProduct->getTaxons()->willReturn(new ArrayCollection([
            $clothesTaxon->getWrappedObject(),
            $capTaxon->getWrappedObject(),
        ]));

        $clothesTaxon->getCode()->willReturn('clothes');
        $jeansTaxon->getCode()->willReturn('jeans');
        $capTaxon->getCode()->willReturn('cap');

        $shipment->getOrder()->willReturn($order);
        $order->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn('CHANNEL_CODE');

        $this->calculate($shipment, ['CHANNEL_CODE' => ['fee' => 1000]])->shouldReturn(4000);
    }
}
