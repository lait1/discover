<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\SettingType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 */
class Setting
{
    /**
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(name="type", type="string") */
    private string $type;

    /** @ORM\Column(name="name", type="string") */
    private string $name;

    /** @ORM\Column(name="value", type="string") */
    private string $value;

    public function __construct(string $name, SettingType $type, string $value)
    {
        $this->name = $name;
        $this->type = $type->getValue();
        $this->value = $value;
    }
}
