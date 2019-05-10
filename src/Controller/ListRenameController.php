<?php

namespace App\Controller;

use App\Entity\WordList;
use App\Form\ListCreationFormModel;
use App\Form\ListCreationFormType;
use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListRenameController
 * @IsGranted("ROLE_USER")
 */
class ListRenameController extends BaseController
{
    /**
     * @Route("/list/{id}/rename", name="app_list_rename")
     */
    public function index(int $id, Request $request, EntityManagerInterface $entityManager, WordListRepository $wordListRepository)
    {
        $list = $wordListRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
        
        if (!isset($list)) {
            $this->addFlash('error', 'Вы не можете изменять этот список');
            return $this->redirectToRoute('app_lists');
        }
        
        $listFormModel = new ListCreationFormModel();
        $listFormModel->name = $list->getName();
        
        $form = $this->createForm(ListCreationFormType::class, $listFormModel);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ListCreationFormModel $listModel */
            $listModel = $form->getData();
            $list->setName(ucfirst($listModel->name));
            
            $entityManager->persist($list);
            $entityManager->flush();
            
            $this->addFlash('success', 'Список успешно переименован в ' . $list->getName());
            return $this->redirectToRoute('app_lists');
        }
        
        return $this->render('list_create_rename/index.html.twig', [
            'listCreateForm' => $form->createView(),
            'caption'        => 'Переименование списка ' . $list->getName(),
            'title'          => 'Renaming',
            'button_text'    => 'Переименовать',
        ]);
    }
}
