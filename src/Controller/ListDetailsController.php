<?php

namespace App\Controller;

use App\Form\ListDetailsFormType;
use App\Repository\WordListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(int $id, Request $request)
    {
        $list = $this->wordListRepository->findOneBy([
            'user' => $this->getUser(),
            'id' => $id,
        ]);
    
        if (!isset($list)) {
            return $this->redirectToRoute('app_lists');
        }
    
        $form = $this->createForm(ListDetailsFormType::class, null, [
            'action' => $this->generateUrl('app_training'),
            
        ]);
        
        return $this->render('list_details/index.html.twig', [
            'list' => $list,
            'listDetailsForm' => $form->createView(),
        ]);
    }
}
