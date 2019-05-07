<?php

namespace App\DataFixtures;

use App\Entity\WordList;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Debug\Exception\FatalErrorException;

class ListFixture extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    protected function loadData(ObjectManager $manager)
    {
        $users = $this->userRepository->findAll();
        
        if (!isset($users)) {
            throw new \LogicException('No users found');
        }
        
        $this->createMany(WordList::class, count($users) * 2, function (WordList $list) use ($users) {
            $list->setUser($this->faker->randomElement($users));
            $list->setName($this->faker->country);
            $list->setLastAccessDate($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
        });
        
        $manager->flush();
    }
    
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UsersFixture::class,
        ];
    }
}
