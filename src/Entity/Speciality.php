<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 */
class Speciality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToMany(targetEntity=Practitioner::class, inversedBy="specialities")
     * @ORM\JoinTable(name="practitioners_specialities",
     *      joinColumns={@ORM\JoinColumn(name="speciality_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")}
     * )
     */
    private Collection $practitioners;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * Speciality constructor.
     */
    public function __construct()
    {
        $this->practitioners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Practitioner[]
     */
    public function getPractitioners(): Collection
    {
        return $this->practitioners;
    }

    /**
     * @return $this
     */
    public function addPractitioner(Practitioner $practitioner): self
    {
        if (!$this->practitioners->contains($practitioner)) {
            $this->practitioners[] = $practitioner;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removePractitioner(Practitioner $practitioner): self
    {
        $this->practitioners->removeElement($practitioner);

        return $this;
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
}
