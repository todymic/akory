<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\DegreeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DegreeRepository::class)
 */
class Degree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="degrees")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Practitioner $practitioner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPractitioner(): ?Practitioner
    {
        return $this->practitioner;
    }

    /**
     * @return $this
     */
    public function setPractitioner(?Practitioner $practitioner): self
    {
        $this->practitioner = $practitioner;

        return $this;
    }
}
