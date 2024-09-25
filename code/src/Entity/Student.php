<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="El nombre no puede estar vacío.")
     */
    private ?string $fullName = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La universidad no puede estar vacía.")
     */
    private ?string $university = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="El número de matrícula no puede estar vacío.")
     * @Assert\Length(
     *     max=255,
     *     maxMessage = "El número de matrícula no puede tener más de {{ limit }} caracteres."
     * )
     */
    private ?string $enrollmentNumber = null;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull(message="La fecha de matrícula no puede estar vacía.")
     * @Assert\DateTime(message="La fecha de matrícula debe ser una fecha válida.")
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
