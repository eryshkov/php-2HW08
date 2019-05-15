<?php

namespace App\Controller\Training;

use App\Controller\BaseController;
use App\Form\DTO\MultipleListFormModel;
use App\Form\MultipleListFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultipleTrainingController
 * @IsGranted("ROLE_USER")
 */
class MultipleTrainingController extends BaseController
{
    /**
     * @Route("/multiple/training", name="app_multiple_training")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MultipleListFormType::class);
        $form->handleRequest($request);
    
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('multiple_training/index.html.twig', [
                'listsForm' => $form->createView(),
            ]);
        }
    
        /** @var MultipleListFormModel $trainingSettings */
        $trainingSettings = $form->getData();
        $selectedLists = $trainingSettings->lists;
        
        $words = [];
        foreach ($selectedLists as $list) {
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $words = array_merge($words, $list->getWordsForTraining($trainingSettings->countFromList, $trainingSettings->isRandom));
            $list->setLastAccessDate(new \DateTime());
            $entityManager->persist($list);
        }
    
        if (!isset($words) || count($words) < 1) {
            $this->addFlash('error', 'Вы не выбрали ни одного слова для тренировки');
            return $this->redirectToRoute('app_lists');
        }
        
        $entityManager->flush();
    
        if ($trainingSettings->isRandom) {
            shuffle($words);
        }
    
        return $this->render('training/index.html.twig', [
            'words' => $words,
            'trainingSettings' => $trainingSettings,
            'caption' => 'Умная тренировка',
        ]);
    }
}
