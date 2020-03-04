<?php

declare(strict_types=1);

namespace App\Shipping;

use Sylius\Component\Core\Exception\MissingChannelConfigurationException;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

final class CustomCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        $price = 2000;

        $channelCode = $subject->getOrder()->getChannel()->getCode();
        if (!isset($configuration[$channelCode]['fee'])) {
            throw new MissingChannelConfigurationException(sprintf(
                'Channel %s has no fee defined for shipping method %s',
                $subject->getOrder()->getChannel()->getName(),
                $subject->getMethod()->getName()
            ));
        }

        /** @var OrderItemUnitInterface[] $units */
        $units = $subject->getUnits();
        foreach ($units as $unit) {
            /** @var ProductVariantInterface $productVariant */
            $productVariant = $unit->getShippable();

            /** @var ProductInterface $product */
            $product = $productVariant->getProduct();

            $applyFee = $product
                ->getTaxons()
                ->exists(static function ($key, TaxonInterface $taxon): bool {
                    return $taxon->getCode() === 'jeans';
                })
            ;

            if ($applyFee) {
                $price += $configuration[$channelCode]['fee'];
            }
        }

        return $price;
    }

    public function getType(): string
    {
        return 'custom';
    }
}
