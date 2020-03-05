<?php

declare(strict_types=1);

namespace App\Shipping;


use Sylius\Component\Core\Model\ShipmentInterface;

final class TrackingCodeProvider implements TrackingCodeProviderInterface
{
    public function provide(ShipmentInterface $shipment): string
    {
        return uniqid();
    }

}
