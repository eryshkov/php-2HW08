<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
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
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }
    
    protected function loadData(ObjectManager $manager): void
    {
        $user = new User();
        
        $user->setEmail('admin@mac.mac');
        
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        
        $user->setRegDate(new \DateTime());
        
        $manager->persist($user);
        
        $this->createMany(User::class, 10, function (User $user) {
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            $user->setRegDate($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setMiddleName($this->faker->colorName);
        });
        
        $manager->flush();
        
        $users = $this->userRepository->findAll();
        
        if (!isset($users)) {
            throw new \LogicException('No users found');
        }
        
        $count = count($users) * 3;
        while ($count > 0) {
            /** @var User $user */
            $user = $this->faker->randomElement($users);
            $user->addRole($this->faker->randomElement(self::$availableRoles));
            $manager->persist($user);
            $count--;
        }
        
        $user = $this->userRepository->findOneBy([
            'email' => 'admin@mac.mac',
        ]);
        $user->setRoles([
            'ROLE_ADMIN',
        ]);
        
        $manager->flush();
    }
}
