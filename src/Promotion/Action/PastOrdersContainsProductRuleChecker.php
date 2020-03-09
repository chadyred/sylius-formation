<?php

declare(strict_types=1);

namespace App\Promotion\Action;

use App\Entity\Order\OrderItemUnit;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifier;
use Sylius\Component\Promotion\Action\PromotionActionCommandInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

class PastOrdersContainsProductRuleChecker implements PromotionActionCommandInterface
{
    private $productVariantRepository;

    private $orderItemQuantityModifier;

    public function __construct(
        ProductVariantRepositoryInterface $productVariantRepository,
        OrderItemQuantityModifier $orderItemQuantityModifier,
        AdjustmentInterface $adjustment
    )
    {
        $this->productVariantRepository = $productVariantRepository;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
    }

    public function execute(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion): bool
    {
        /** OrderInterface $subject */
        Assert::isInstanceOf($subject, OrderInterface::class);

        $productVariant = $this->productVariantRepository->findOneBy(['code' => 'GIFT_CARD_50']);
        $items = $subject->getItems();
        /** @var OrderItemUnit|null $itemFind */
        $itemFind = null;

        foreach ($items as $item) {
            if ($item->getCode() === $productVariant->getCode()) {
                $itemFind = $item;
                break;
            }
        }
        $this->orderItemQuantityModifier->modify($itemFind->getOrderItem()->getQuantity(), 1);



    }

    public function revert(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion): void
    {
        // TODO: Implement revert() method.
    }

}
