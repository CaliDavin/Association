<?php

namespace App\Entity;

use App\Repository\Category2Repository;
use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: Category2Repository::class)]
class Category2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    // #[ORM\Column]
    private ?int $id = null;

    // #[ORM\Column(length: 60, unique:true)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
