<?php

namespace App\DataFixtures;

use App\Entity\Word;
use App\Entity\WordList;
use App\Repository\WordListRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class WordFixture extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @var WordListRepository
     */
    private $wordListRepository;
    
    public function __construct(WordListRepository $wordListRepository)
    {
        $this->wordListRepository = $wordListRepository;
    }
    
    protected function loadData(ObjectManager $manager)
    {
        $lists = $this->wordListRepository->findAll();
        
        if (!isset($lists)) {
            throw new \LogicException('No lists found');
        }
        
        $this->createMany(Word::class, count($lists) * 5, function (Word $word) use ($lists) {
            /** @var WordList $list */
            $list = $this->faker->randomElement($lists);
            $word->setList($list);
            $word->setUser($list->getUser());
            $word->setEnglish($this->faker->word);
            $word->setRussian($this->faker->word);
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
            ListFixture::class,
        ];
    }
}
