<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="participations")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    private ?Student $student = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ResearchProject", inversedBy="participations")
     * @ORM\JoinColumn(name="research_code", referencedColumnName="id", nullable=false)
     */
    private ?ResearchProject $researchProject = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $startDate = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $estimatedEndDate = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $actualEndDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;
        return $this;
    }

    public function getResearchProject(): ?ResearchProject
    {
        return $this->researchProject;
    }

    public function setResearchProject(?ResearchProject $researchProject): self
    {
        $this->researchProject = $researchProject;
        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEstimatedEndDate(): ?\DateTime
    {
        return $this->estimatedEndDate;
    }

    public function setEstimatedEndDate(?\DateTime $estimatedEndDate): self
    {
        $this->estimatedEndDate = $estimatedEndDate;
        return $this;
    }

    public function getActualEndDate(): ?\DateTime
    {
        return $this->actualEndDate;
    }

    public function setActualEndDate(?\DateTime $actualEndDate): self
    {
        $this->actualEndDate = $actualEndDate;
        return $this;
    }
}
