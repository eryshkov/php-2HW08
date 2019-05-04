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
class ListCreateController extends BaseController
{
    /**
     * @Route("/list/create", name="app_list_create")
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
    
            return $this->redirectToRoute('app_lists');
        }
        
        return $this->render('list_create/index.html.twig', [
            'listCreateForm' => $form->createView(),
        ]);
    }
}