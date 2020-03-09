<?php

namespace App\Tests\Behat\Context;

use Sylius\Behat\Page\Shop\ProductReview\CreatePageInterface;

class NotificationCheckerContext implements \Behat\Behat\Context\Context
{
    /**
     * @var NotificationCheckerContext
     */
    private $checkerContext;
    /**
     * @var CreatePageInterface
     */
    private $createPageProductReview;

    /**
     * NotificationCheckerContext constructor.
     * @param NotificationCheckerContext $checkerContext
     * @param CreatePageInterface $createPageProductReview
     */
    public function __construct(
        NotificationCheckerContext $checkerContext,
        CreatePageInterface $createPageProductReview)
    {
        $this->checkerContext = $checkerContext;
        $this->createPageProductReview = $createPageProductReview;
    }


}
