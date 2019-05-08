<?php

namespace App\Controller;

use App\Form\ListDetailsFormModel;
use App\Form\ListDetailsFormType;
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
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(int $id)
    {
        $list = $this->wordListRepository->findOneBy([
            'user' => $this->getUser(),
            'id'   => $id,
        ]);
        
        if (!isset($list)) {
            $this->addFlash('error', 'Не удалось найти список №' . $id);
            return $this->redirectToRoute('app_lists');
        }
        
        $defaultValue = new ListDetailsFormModel();
        $defaultValue->isShowTranslation = false;
        $defaultValue->isRandom = true;
        $defaultValue->listId = $list->getId();
        
        $form = $this->createForm(ListDetailsFormType::class, $defaultValue, [
            'action' => $this->generateUrl('app_training'),
        ]);
        
        return $this->render('list_details/index.html.twig', [
            'list'            => $list,
            'listDetailsForm' => $form->createView(),
        ]);
    }
}
