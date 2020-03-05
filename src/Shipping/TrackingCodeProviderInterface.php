<?php

declare(strict_types=1);

namespace App\Shipping;

use Sylius\Component\Core\Model\ShipmentInterface;

interface TrackingCodeProviderInterface
{
    public function provide(ShipmentInterface $shipment): string;
}
