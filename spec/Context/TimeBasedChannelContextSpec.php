<?php

namespace spec\App\Context;

use App\ClockInterface;
use App\Context\TimeBasedChannelContext;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Behat\Context\Ui\ChannelContext;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

class TimeBasedChannelContextSpec extends ObjectBehavior
{
    function let(
        ClockInterface $clock,
        ChannelRepositoryInterface $channelRepository
    ): void
    {
        $this->beConstructedWith($clock, $channelRepository);
    }

    function it_is_a_channel_context(): void
    {
        $this->shouldImplement(ChannelContextInterface::class);
    }

    function it_should_return_fashion_web_odd(
        ClockInterface $clock,
        ChannelRepositoryInterface $channelRepository,
        ChannelInterface $channel
    ): void
    {
        $clock->getMinute()->willReturn(7);

        $channelRepository->findOneByCode('FASHION_WEB')->willReturn($channel);

        $this->getChannel()->shouldReturn($channel);
    }

    function it_should_return_fashion_web_2_odd(
        ClockInterface $clock,
        ChannelRepositoryInterface $channelRepository,
        ChannelInterface $channel
    ): void
    {
        $clock->getMinute()->willReturn(42);

        $channelRepository->findOneByCode('FASHION_WEB_2')->willReturn($channel);

        $this->getChannel()->shouldReturn($channel);
    }
}
