<?php

namespace App\Entity\Repository;

use App\Doctrine\Repository;
use App\Entity;
use Carbon\CarbonImmutable;
use DateTimeInterface;

class AnalyticsRepository extends Repository
{
    /**
     * @return mixed[]
     */
    public function findForStationAfterTime(
        Entity\Station $station,
        DateTimeInterface $threshold,
        string $type = Entity\Analytics::INTERVAL_DAILY
    ): array {
        return $this->em->createQuery(
            <<<'DQL'
                SELECT a FROM App\Entity\Analytics a
                WHERE a.station = :station AND a.type = :type AND a.moment >= :threshold
            DQL
        )->setParameter('station', $station)
            ->setParameter('type', $type)
            ->setParameter('threshold', $threshold)
            ->getArrayResult();
    }

    public function clearAllAfterTime(
        DateTimeInterface $threshold
    ): void {
        $this->em->createQuery(
            <<<'DQL'
                DELETE FROM App\Entity\Analytics a WHERE a.moment >= :threshold
            DQL
        )->setParameter('threshold', $threshold)
            ->execute();
    }

    public function clearAll(): void
    {
        $this->em->createQuery(
            <<<'DQL'
                DELETE FROM App\Entity\Analytics a
            DQL
        )->execute();
    }

    public function cleanup(): void
    {
        $hourlyRetention = CarbonImmutable::now()
            ->subDays(14);

        $this->em->createQuery(
            <<<'DQL'
                DELETE FROM App\Entity\Analytics a
                WHERE a.type = :type AND a.moment <= :threshold
            DQL
        )->setParameter('type', Entity\Analytics::INTERVAL_HOURLY)
            ->setParameter('threshold', $hourlyRetention)
            ->execute();
    }
}
