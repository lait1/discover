<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Setting;
use App\Enum\SettingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    public function getByType(SettingType $type): array
    {
        return $this->findBy(['type' => $type->getValue()]);
    }
}
