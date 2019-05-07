<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixture extends BaseFixture
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;
    
    private static $availableRoles = [
        'ROLE_ADMIN',
        'ROLE_MANAGER',
        'ROLE_CREATOR',
    ];
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    protected function loadData(ObjectManager $manager): void
    {
        $user = new User();
    
        $user->setEmail('admin@mac.mac');
    
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
    
        $user->setRegDate(new \DateTime());
    
        $user->setRoles([
            'ROLE_ADMIN',
    
        ]);
        $manager->persist($user);
    
        $this->createMany(User::class, 10, function (User $user) {
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            $user->setRegDate($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $user->setRoles([$this->faker->randomElement(self::$availableRoles)]);
        });
    
        $manager->flush();
    }
}
