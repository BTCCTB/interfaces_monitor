<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $friendlyName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $technicalName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="roles")
     */
    private $groups;

    /**
     * Role constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFriendlyName(): ?string
    {
        return $this->friendlyName;
    }

    /**
     * @param string $friendlyName
     *
     * @return Role
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->friendlyName = $friendlyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTechnicalName(): ?string
    {
        return $this->technicalName;
    }

    /**
     * @param string $technicalName
     *
     * @return Role
     */
    public function setTechnicalName(string $technicalName): self
    {
        $this->technicalName = $technicalName;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param Group $group
     *
     * @return Role
     */
    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addRole($this);
        }

        return $this;
    }

    /**
     * @param Group $group
     *
     * @return Role
     */
    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeRole($this);
        }

        return $this;
    }

    /**
     * Returns the string representation of the class object
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->friendlyName;
    }
}
