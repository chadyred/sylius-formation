<?php

declare(strict_types=1);

namespace App\Context;

use App\ClockInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;

final class TimeBasedChannelContext implements ChannelContextInterface
{
    /**
     * @var ClockInterface
     */
    private $clock;

    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    public function __construct(
        ClockInterface $clock,
        ChannelRepositoryInterface $channelRepository
    )
    {
        $this->clock = $clock;
        $this->channelRepository = $channelRepository;
    }

    public function getChannel(): ChannelInterface
    {
        if (($this->clock->getMinute() % 2) === 0) {
            return $this->channelRepository->findOneByCode('FASHION_WEB_2');
        }

        return $this->channelRepository->findOneByCode('FASHION_WEB');
    }
}
