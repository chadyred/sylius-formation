<?php

declare(strict_types=1);

namespace App\Listener;

use App\Shipping\TrackingCodeProviderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

class AutomaticTrackingCodeAssignerListener
{
    private $trackingCodeProvider;

    private $shipment;

    public function __construct(TrackingCodeProviderInterface $trackingCodeProvider, ShipmentInterface $shipment)
    {
        $this->trackingCodeProvider = $trackingCodeProvider;
        $this->shipment = $shipment;
    }

    public function __invoke()
    {
        return $this->trackingCodeProvider->provide($this->shipment);
    }
}
