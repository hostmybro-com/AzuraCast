<?php

namespace App\Radio\Backend;

use App\Entity;

class None extends AbstractBackend
{
    public function start(Entity\Station $station): void
    {
        $this->logger->error(
            'Cannot start process; AutoDJ is currently disabled.',
            ['station_id' => $station->getId(), 'station_name' => $station->getName()]
        );
    }
}
