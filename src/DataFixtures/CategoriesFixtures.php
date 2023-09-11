<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $categories = [
            0 => ['name' => 'Необычное'],
            1 => ['name' => 'Природа'],
            2 => ['name' => 'История'],
            3 => ['name' => 'Религия'],
            4 => ['name' => 'Гастрономия'],
            5 => ['name' => 'Рыбалка'],
            6 => ['name' => 'Познавательные'],
            7 => ['name' => 'Развлекательные'],
        ];

        foreach ($categories as $category) {
            $this->repository->save(new Category($category['name']));
        }
    }
}
