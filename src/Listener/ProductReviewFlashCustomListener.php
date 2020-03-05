<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\HttpFoundation\Session\Session;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Review\Model\ReviewInterface;
use Webmozart\Assert\Assert;

class ProductReviewFlashCustomListener
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __invoke(ResourceControllerEvent $event)
    {
        /** @var ReviewInterface $review */
        $review = $event->getSubject();

        Assert::isInstanceOf($review, ReviewInterface::class);

        if ($review->getStatus() !== ReviewInterface::STATUS_NEW) {
            return;
        }

        $flashBag = $this->session->getFlashBag();
        $flashBagType = $flashBag->all();

        foreach ($flashBagType as $type => $flashed) {
            foreach ($flashed as $key => $message) {
                if ($message === 'sylius.review.wait_for_the_acceptation') {
                    continue;
                }
                $flashBag->add($type, $message);
            }
        }

        if ($review->getStatus() === ReviewInterface::STATUS_ACCEPTED) {
            $flashBag->add('success', 'app.review.accepted');
        }

        if ($review->getStatus() === ReviewInterface::STATUS_REJECTED) {
            $flashBag->add('error', 'app.review.reject');
        }

    }
}
