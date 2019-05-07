<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixture extends Fixture
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
    
        $user->setEmail('admin@mac.mac');
    
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
    
        $user->setRegDate(new \DateTime());
        
        $user->setRoles([
            'ROLE_ADMIN',
            
        ]);
    
        $user1 = new User();
    
        $user1->setEmail('user@mac.mac');
    
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'test'));
        $user1->setRegDate(new \DateTime());
    
        $manager->persist($user);
        $manager->persist($user1);

        $manager->flush();
    }
}
