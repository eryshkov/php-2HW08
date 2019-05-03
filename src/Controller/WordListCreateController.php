<?php

namespace App\Controller;

use App\Entity\WordList;
use App\Form\ListCreationFormModel;
use App\Form\ListCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordListCreateController
 * @IsGranted("ROLE_USER")
 */
class WordListCreateController extends BaseController
{
    /**
     * @Route("/word/list/create", name="app_word_list_create")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ListCreationFormType::class);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ListCreationFormModel $listModel */
            $listModel = $form->getData();
            $list = new WordList();
            $list->setName(ucfirst($listModel->name));
            $list->setUser($this->getUser());
            $list->setLastAccessDate(new \DateTime());
    
            $entityManager->persist($list);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_word_list');
        }
        
        return $this->render('word_list_create/index.html.twig', [
            'listCreateForm' => $form->createView(),
        ]);
    }
}
