<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function sprintf;

class UserFixtures extends Fixture
{
    private const USERS_CREATED_AMOUNT = 90;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::USERS_CREATED_AMOUNT; $i++) {
            $username = sprintf('test_%d', $i);

            $user = new User();
            $user->setUsername($username);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $username
                )
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
