<?php

namespace App\Controller;

use App\Repository\WordListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListDetailsController
 * @IsGranted("ROLE_USER")
 */
class ListDetailsController extends BaseController
{
    /**
     * @var WordListRepository
     */
    private $wordListRepository;
    
    public function __construct(WordListRepository $wordListRepository)
    {
        $this->wordListRepository = $wordListRepository;
    }
    
    /**
     * @Route("/list/{id}/details", name="app_list_details")
     */
    public function index(int $id)
    {
        $currentUser = $this->getUser();
    
        $list = $this->wordListRepository->findOneBy([
            'user' => $currentUser,
            'id' => $id,
        ]);
        
        return $this->render('list_details/index.html.twig', [
            'user' => $currentUser,
            'list' => $list,
        ]);
    }
}
