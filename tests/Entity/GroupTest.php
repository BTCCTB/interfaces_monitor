<?php

namespace App\Tests\Entity;

use App\Entity\Group;
use App\Entity\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GroupTest
 *
 * @author  Damien Lagae <damien.lagae@enabel.be>
 * @group entity
 * @group main
 */
class GroupTest extends KernelTestCase
{
    /**
     * @var array $groupData
     */
    private $groupData;

    /**
     * @var Group $group
     */
    private $group;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->group = new Group();
        $this->groupData = [
            'name' => 'Admin',
            'role' => new Role(),
        ];
        parent::setUp();
    }

    /**
     * Test getter & setter for name
     */
    public function testName()
    {
        $this->group->setName($this->groupData['name']);
        $this->assertEquals($this->groupData['name'], $this->group->getName());
    }

    /**
     * Test getter & setter for role
     */
    public function testRole()
    {
        $this->group->addRole($this->groupData['role']);
        $roles = new ArrayCollection();
        $roles->add($this->groupData['role']);
        $this->assertEquals($roles, $this->group->getRoles());
        $this->group->removeRole($this->groupData['role']);
        $this->assertTrue($this->group->getRoles()->isEmpty());
    }

    /**
     * Group class contains property
     */
    public function testProperty()
    {
        $this->assertTrue(property_exists(Group::class, 'name'));
        $this->assertTrue(property_exists(Group::class, 'roles'));
    }

    /**
     * Test class toString
     */
    public function testToString()
    {
        $this->group->setName($this->groupData['name']);
        $this->assertEquals($this->group->__toString(), $this->group->getName());
    }
}
