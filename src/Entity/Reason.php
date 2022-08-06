<?php

namespace App\Entity;

use App\Repository\ReasonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReasonRepository::class)
 */
class Reason
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
    private ?string $constant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="reasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Speciality $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConstant(): ?string
    {
        return $this->constant;
    }

    /**
     * @return $this
     */
    public function setConstant(string $constant): self
    {
        $this->constant = $constant;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Speciality
    {
        return $this->category;
    }

    /**
     * @return $this
     */
    public function setCategory(?Speciality $category): self
    {
        $this->category = $category;

        return $this;
    }
}
