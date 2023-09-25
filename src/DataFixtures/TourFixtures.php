<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tour;
use App\Repository\TourRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TourFixtures extends Fixture
{
    private TourRepository $repository;

    public function __construct(TourRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $this->repository->save(new Tour(Tour::UNIQ_TOUR));
    }
}
