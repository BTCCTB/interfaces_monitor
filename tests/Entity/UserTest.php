<?php

namespace App\Tests\Entity;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Hslavich\OneloginSamlBundle\Security\User\SamlUserInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * @var User $user
     */
    private $user;

    /**
     * @var array $userData
     */
    private $userData;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->userData = [
            'employeeNumber' => 1,
            'email' => 'firstname.lastname@enabel.be',
            'displayName' => 'Firstname LASTNAME',
            'language' => 'FR',
            'group' => new Group(),
        ];

        $this->user = new User();

        parent::setUp();
    }

    /**
     * User class implement SamlUserInterface
     */
    public function testImplementSaml()
    {
        $interfaces = class_implements(User::class);
        $this->assertTrue(isset($interfaces[SamlUserInterface::class]), 'Class ' . User::class . "does't implement SamlUserInterface!");
    }

    /**
     * Test getter & setter for employeeNumber
     */
    public function testEmployeeNumber()
    {
        $this->user->setEmployeeNumber($this->userData['employeeNumber']);
        $this->assertEquals($this->userData['employeeNumber'], $this->user->getEmployeeNumber());
    }

    /**
     * Test getter & setter for email
     */
    public function testEmail()
    {
        $this->user->setEmail($this->userData['email']);
        $this->assertEquals($this->userData['email'], $this->user->getEmail());
    }

    /**
     * Test getter & setter for displayName
     */
    public function testDisplayName()
    {
        $this->user->setDisplayName($this->userData['displayName']);
        $this->assertEquals($this->userData['displayName'], $this->user->getDisplayName());
    }

    /**
     * Test getter & setter for language
     */
    public function testLanguage()
    {
        $this->user->setLanguage($this->userData['language']);
        $this->assertEquals($this->userData['language'], $this->user->getLanguage());
    }

    /**
     * Test getter & setter for group
     */
    public function testGroup()
    {
        $this->user->addGroup($this->userData['group']);
        $groups = new ArrayCollection();
        $groups->add($this->userData['group']);
        $this->assertEquals($groups, $this->user->getGroups());
        $this->user->removeGroup($this->userData['group']);
        $this->assertTrue($this->user->getGroups()->isEmpty());
    }

    /**
     * User class contains property
     */
    public function testProperty()
    {
        $this->assertTrue(property_exists(User::class, 'employeeNumber'));
        $this->assertTrue(property_exists(User::class, 'email'));
        $this->assertTrue(property_exists(User::class, 'displayName'));
        $this->assertTrue(property_exists(User::class, 'language'));
        $this->assertTrue(property_exists(User::class, 'groups'));
    }

    /**
     * Test class toString
     */
    public function testToString()
    {
        $this->user->setDisplayName($this->userData['displayName']);
        $this->assertEquals($this->user->__toString(), $this->user->getDisplayName());
    }
}
