<?php
namespace App\Console\Command\Internal;

use App\Entity;
use App\Service\AzuraCastCentral;
use App\Console\Command\CommandAbstract;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetIpCommand extends CommandAbstract
{
    public function __invoke(
        SymfonyStyle $io,
        Entity\Repository\SettingsRepository $settings_repo,
        AzuraCastCentral $acCentral
    ) {
        $io->write($acCentral->getIp());
        return 0;
    }
}
