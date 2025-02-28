<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;
use Fykosak\NetteFKSDBDownloader\ORM\Services\ServiceEventList;
use Nette\ArgumentOutOfRangeException;
use Nette\DI\Container;
use Nette\SmartObject;
use Throwable;

class GamePhaseCalculator
{
    use SmartObject;

    private ServiceEventList $serviceEventList;
    private Container $container;

    public const BEFORE = 0;
    public const AFTER = 1;
    public const NOW = 2;
    private int $eventTypeId;

    protected function checkEvent(int $period, DateTimeInterface $start, DateTimeInterface $end): bool
    {
        $now = new \DateTime();
        switch ($period) {
            case self::BEFORE:
                return $now < $start;
            case self::AFTER:
                return $now > $end;
            case self::NOW:
                return $now > $start && $now < $end;
            default:
                throw new ArgumentOutOfRangeException('Invalid period');
        }
    }

    public function __construct(int $eventTypeId, ServiceEventList $serviceEventList, Container $container)
    {
        $this->eventTypeId = $eventTypeId;
        $this->serviceEventList = $serviceEventList;
        $this->container = $container;
    }

    /**
     * @throws Throwable
     */
    public function isDateKnown(): bool
    {
        return new \DateTime() < $this->getFKSDBEvent()->end;
    }

    /**
     * @throws Throwable
     */
    public function isRegistration(int $period): bool
    {
        return $this->checkEvent(
            $period,
            $this->getFKSDBEvent()->registrationBegin,
            $this->getFKSDBEvent()->registrationEnd,
        );
    }

    /**
     * @throws Throwable
     */
    public function isNearTheCompetition(int $period): bool
    {
        $begin = (new \DateTime())->setTimestamp($this->getFKSDBEvent()->begin->getTimestamp())
            ->sub(new \DateInterval('P3D'));
        $end = (new \DateTime())->setTimestamp($this->getFKSDBEvent()->begin->getTimestamp())
            ->add(new \DateInterval('P1D'));
        return $this->checkEvent(
            $period,
            $begin,
            $end,
        );
    }

    /**
     * The game itself, three hours long
     * @throws Throwable
     */
    public function isGame(int $period = self::NOW): bool
    {
        return $this->checkEvent(
            $period,
            $this->getGameBegin(),
            $this->getGameBegin()->add(new \DateInterval("PT3H")),
        );
    }

    /**
     * @throws Throwable
     */
    public function isAfterRegistration(): bool
    {
        return $this->isDateKnown() && new \DateTime() > $this->getFKSDBEvent()->registrationEnd;
    }

    /**
     * @throws Throwable
     */
    public function getGameBegin(): \DateTime
    {
        $time = new \DateTime($this->container->getParameters()['competitionBegin']);
        $day = $this->getFKSDBEvent()->begin;

        $time->setDate((int)$day->format('Y'), (int)$day->format('m'), (int)$day->format('d'));
        return $time;
    }

    /**
     * @throws Throwable
     */
    public function isGameRunning(): bool
    {
        return new \DateTime() > $this->getFKSDBEvent()->begin && new \DateTime() < $this->getFKSDBEvent()->end;
    }

    /**
     * Returns true about a week after the competition when no one is interested in game already.
     * @throws Throwable
     */
    public function isLongAfterTheGame(): bool
    {
        $event = (new \DateTime())->setTimestamp($this->getFKSDBEvent()->end->getTimestamp())
            ->add(new \DateInterval('P7D'));
        return new \DateTime() > $event;
    }

    /**
     * @throws Throwable
     */
    public function isResultsVisible(): bool
    {
        return $this->isGameRunning();/*&& new \DateTime() <  TODO*/
    }

    public function isResultsPublished(): bool
    {
        return false;// TODO;
    }

    /**
     * Returns newest FKSDB event. That means by creating a new one, the application automatically switches to the new
     * year.
     * @throws Throwable
     */
    public function getFKSDBEvent(): ?ModelEvent
    {
        static $fksdbEvent;
        if (!isset($fksdbEvent)) {
            $fksdbEvent = $this->serviceEventList->getNewest([$this->eventTypeId]);
        }
        return $fksdbEvent;
    }
}
