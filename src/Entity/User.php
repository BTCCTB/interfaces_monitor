<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hslavich\OneloginSamlBundle\Security\User\SamlUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ORM\Table(name="user")
 *
 * @UniqueEntity(fields={"email"}, message="It looks this user has already an account")
 *
 * @author  Damien Lagae <damien.lagae@enabel.be>
 */
class User implements SamlUserInterface, EquatableInterface
{
    public const DEFAULTLANGUAGE = 'EN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $employeeNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $displayName;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="users")
     *
     * @var ArrayCollection|Group[]
     */
    private $groups;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->setLanguage(self::DEFAULTLANGUAGE);
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
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getEmployeeNumber(): ?int
    {
        return $this->employeeNumber;
    }

    /**
     * @param int $employeeNumber
     *
     * @return User
     */
    public function setEmployeeNumber(int $employeeNumber): self
    {
        $this->employeeNumber = $employeeNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     *
     * @return User
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return User
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Set SAML attributes in user object.
     *
     * @param array $attributes
     */
    public function setSamlAttributes(array $attributes)
    {
        $this->setEmail($attributes['uid'][0]);
        $this->setEmployeeNumber($attributes['employeeNumber'][0]);
        $this->setDisplayName($attributes['displayName'][0]);
        if (!empty($attributes['preferredLanguage'][0])) {
            $this->setLanguage(strtoupper($attributes['preferredLanguage'][0]));
        } else {
            $this->setLanguage(self::DEFAULTLANGUAGE);
        }
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
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
     * @return User
     */
    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    /**
     * @param Group $group
     *
     * @return User
     */
    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $roles = new ArrayCollection();
        // Default role/permissions
        $roles->add("IS_AUTHENTICATED_ANONYMOUSLY");

        foreach ($this->groups as $group) {
            foreach ($group->getRoles() as $role) {
                if (!$roles->contains($role->getTechnicalName())) {
                    $roles->add($role->getTechnicalName());
                }
            }
        }

        return $roles->toArray();
    }

    /**
     * Returns the string representation of the class object
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->displayName;
    }

    /**
     * Returns the array representation of the class object
     *
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'employeeNumber' => $this->employeeNumber,
            'displayName' => $this->displayName,
            'language' => $this->language,
            'roles' => $this->getRoles(),
        ];
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return (
            md5($this->getUsername()) === md5($user->getUsername())) &&
            (
                md5(serialize($this->getRoles())) === md5(serialize($user->getRoles()))
            );
    }
}
