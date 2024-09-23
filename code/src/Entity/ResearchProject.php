<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ResearchProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResearchProjectRepository::class)
 */
class ResearchProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private ?string $researchCode = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $availableSpots = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getResearchCode(): ?string
    {
        return $this->researchCode;
    }

    public function getAvailableSpots(): ?int
    {
        return $this->availableSpots;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setResearchCode(?string $researchCode): self
    {
        $this->researchCode = $researchCode;
        return $this;
    }

    public function setAvailableSpots(?int $availableSpots): self
    {
        $this->availableSpots = $availableSpots;
        return $this;
    }
}
