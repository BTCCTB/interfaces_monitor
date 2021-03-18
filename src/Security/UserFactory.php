<?php

namespace App\Security;

use App\Entity\User;
use Hslavich\OneloginSamlBundle\Security\Authentication\Token\SamlTokenInterface;
use Hslavich\OneloginSamlBundle\Security\User\SamlUserFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserFactory
 *
 * @package App\Security
 *
 * @author  Damien Lagae <damien.lagae@enabel.be>
 */
class UserFactory implements SamlUserFactoryInterface
{
    /**
     * Creates a new User object from SAML Token.
     *
     * @param SamlTokenInterface $username SAML token
     * @param array              $attributes
     *
     * @return UserInterface
     */
    public function createUser($username, array $attributes = []): UserInterface
    {
        $user = new User();
        $user->setSamlAttributes($username->getAttributes());

        return $user;
    }
}
