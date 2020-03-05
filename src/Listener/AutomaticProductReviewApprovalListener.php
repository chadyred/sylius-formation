<?php

declare(strict_types=1);

namespace App\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Mockery\Exception;
use SM\SMException;
use SM\StateMachine\StateMachineInterface;
use Sylius\Component\Core\ProductReviewTransitions;
use SM\Factory\FactoryInterface;
use Sylius\Component\Review\Model\ReviewInterface;

class AutomaticProductReviewApprovalListener
{
    /**
     * @var FactoryInterface
     */
    private $stateMachineFactory;

    public function __construct(FactoryInterface $stateMachineFactory)
    {
        $this->stateMachineFactory = $stateMachineFactory;
    }

    public function __invoke(LifecycleEventArgs $event): void
    {
        /** @var ReviewInterface $review */
        $review = $event->getEntity();

        if (!$review instanceof ReviewInterface) {
            return;
        }

        /** @var StateMachineInterface $stateMachine */
        $stateMachine = $this
            ->stateMachineFactory
            ->get($review, ProductReviewTransitions::GRAPH)
        ;


        if ($review->getRating() >= 4) {
            $stateMachine->apply(ProductReviewTransitions::TRANSITION_ACCEPT, $review);
        }

        if ($review->getRating() === 1) {
            $stateMachine->apply(ProductReviewTransitions::TRANSITION_REJECT, $review);
        }
    }
}
