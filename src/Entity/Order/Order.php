<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder
{
    public function getAdjustement($type)
    {
        return  $this->getAdjustmentsTotal($type);
    }
}
