<?php

namespace App\Controller\ListOfWords;

use App\Controller\BaseController;
use App\Repository\WordListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListDeleteConfirmController
 * @IsGranted("ROLE_USER")
 */
class ListDeleteConfirmController extends BaseController
{
    /**
     * @Route("/list/{id}/delete/confirm", name="app_list_delete_confirm")
     */
    public function index(int $id, WordListRepository $wordListRepository)
    {
        $list = $wordListRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($list)) {
            $this->addFlash('error', 'Невозможно удалить этот список');
            return $this->redirectToRoute('app_lists');
        }
        
        return $this->render('list_delete_confirm/index.html.twig', [
            'listForDeletion' => $list,
        ]);
    }
}
