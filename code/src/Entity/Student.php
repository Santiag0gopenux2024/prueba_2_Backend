<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private ?string $fullName = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $university = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private ?string $enrollmentNumber = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $enrollmentDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function getEnrollmentNumber(): ?string
    {
        return $this->enrollmentNumber;
    }

    public function getEnrollmentDate(): ?\DateTime
    {
        return $this->enrollmentDate;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function setUniversity(?string $university): self
    {
        $this->university = $university;
        return $this;
    }

    public function setEnrollmentNumber(?string $enrollmentNumber): self
    {
        $this->enrollmentNumber = $enrollmentNumber;
        return $this;
    }

    public function setEnrollmentDate(?\DateTime $enrollmentDate): self
    {
        $this->enrollmentDate = $enrollmentDate;
        return $this;
    }
}
