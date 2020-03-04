<?php

declare(strict_types=1);

namespace App\Listener;

use App\Entity\Supplier;
use Sylius\Component\Mailer\Sender\SenderInterface;

class SupplierNotifier
{
    private $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function __invoke(Supplier $supplier)
    {
        $this
            ->sender
            ->send(
                'supplier_verified',
                [$supplier->getEmail()],
                ['supplier' => $supplier]
            );
    }
}
