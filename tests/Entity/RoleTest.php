<?php

namespace App\Tests\Entity;

use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class RoleTest
 *
 * @author  Damien Lagae <damien.lagae@enabel.be>
 * @group entity
 * @group main
 */
class RoleTest extends KernelTestCase
{
    /**
     * @var array $roleData
     */
    private $roleData;

    /**
     * @var Role $role
     */
    private $role;

    /**
     * {@inheritDoc}
     */
    public function setUp():void
    {
        $this->role = new Role();
        $this->roleData = [
            'technicalName' => 'ROLE_ROLE',
            'friendlyName' => 'Basic user',
        ];
        parent::setUp();
    }

    public function testTechnicalName()
    {
        $this->role->setTechnicalName($this->roleData['technicalName']);
        $this->assertEquals($this->roleData['technicalName'], $this->role->getTechnicalName());
    }

    public function testFriendlyName()
    {
        $this->role->setFriendlyName($this->roleData['friendlyName']);
        $this->assertEquals($this->roleData['friendlyName'], $this->role->getFriendlyName());
    }

    /**
     * Role class contains property
     */
    public function testProperty()
    {
        $this->assertTrue(property_exists(Role::class, 'technicalName'));
        $this->assertTrue(property_exists(Role::class, 'friendlyName'));
        $this->assertTrue(property_exists(Role::class, 'groups'));
    }

    /**
     * Test class toString
     */
    public function testToString()
    {
        $this->role->setFriendlyName($this->roleData['friendlyName']);
        $this->assertEquals($this->role->__toString(), $this->role->getFriendlyName());
    }
}
