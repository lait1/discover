<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tour_options")
 * @ORM\Entity(repositoryClass="App\Repository\TourDescriptionRepository")
 */
class TourOption implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->id,
            'text'  => $this->name,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }
}
