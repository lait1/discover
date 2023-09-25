<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\TourOption;
use App\Repository\TourOptionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OptionsFixtures extends Fixture
{
    private TourOptionRepository $repository;

    public function __construct(TourOptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $options = [
            0 => 'Комфортабельный транспорт',
            1 => 'Все транспортные расходы',
            2 => 'Услуги гида',
            3 => 'Обед',
            4 => 'Входные билеты',
            5 => 'Фото и видеосъемка (по желанию)',
            6 => 'Встреча у места проживания',
        ];

        foreach ($options as $option) {
            $this->repository->save(new TourOption($option));
        }
    }
}
