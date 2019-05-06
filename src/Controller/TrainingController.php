<?php

namespace App\Controller;

use App\Form\ListDetailsFormModel;
use App\Form\ListDetailsFormType;
use App\Repository\WordListRepository;
use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrainingController
 * @IsGranted("ROLE_USER")
 */
class TrainingController extends AbstractController
{
    /**
     * @Route("/training", name="app_training")
     */
    public function index(Request $request, WordRepository $wordRepository, WordListRepository $wordListRepository)
    {
        $form = $this->createForm(ListDetailsFormType::class);
        $form->handleRequest($request);
    
        if (!($form->isSubmitted() && $form->isValid())) {
            $this->addFlash('error', 'Данные тренировки неверные');
            return $this->redirectToRoute('app_lists');
        }
    
        /** @var ListDetailsFormModel $trainingSettings */
        $trainingSettings = $form->getData();
    
        $list = $wordListRepository->findOneBy([
            'user' => $this->getUser(),
            'id' => $trainingSettings->listId,
        ]);
    
        if (!isset($list)) {
            $this->addFlash('error', 'Не удалось найти список №' . $trainingSettings->listId);
            return $this->redirectToRoute('app_lists');
        }
    
        $words = $wordRepository->getAllFromListById($list);
    
        if (!isset($words)) {
            $this->addFlash('error', 'Список №' . $trainingSettings->listId . ' не содержит слов для тренировки');
            return $this->redirectToRoute('app_lists');
        }
    
        if ($trainingSettings->isRandom) {
            //перемешать список
        }
        
        return $this->render('training/index.html.twig', [
            'words' => $words,
            'list' => $list,
            'trainingSettings' => $trainingSettings,
        ]);
    }
}
