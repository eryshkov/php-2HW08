<?php

namespace App\Controller\Training;

use App\Controller\BaseController;
use App\Form\DTO\ListDetailsFormModel;
use App\Form\ListDetailsFormType;
use App\Repository\WordListRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrainingController
 * @IsGranted("ROLE_USER")
 */
class TrainingController extends BaseController
{
    /**
     * @Route("/training", name="app_training")
     * @param Request $request
     * @param WordRepository $wordRepository
     * @param WordListRepository $wordListRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function index(Request $request, WordRepository $wordRepository, WordListRepository $wordListRepository, EntityManagerInterface $entityManager): Response
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
            'id'   => $trainingSettings->listId,
        ]);
        
        if (!isset($list)) {
            $this->addFlash('error', 'Не удалось найти список №' . $trainingSettings->listId);
            return $this->redirectToRoute('app_lists');
        }
        
        $words = $wordRepository->getAllFromListByIdDESC($list);
        
        if (!isset($words) || count($words) < 1) {
            $this->addFlash('error', 'Список "' . $list->getName() . '" не содержит слов для тренировки');
            return $this->redirectToRoute('app_lists');
        }
        
        if ($trainingSettings->isRandom) {
            shuffle($words);
        }
        
        $list->setLastAccessDate(new \DateTime());
        $entityManager->persist($list);
        $entityManager->flush();
        
        return $this->render('training/index.html.twig', [
            'words'            => $words,
            'list'             => $list,
            'trainingSettings' => $trainingSettings,
            'caption' => 'Простая тренировка',
        ]);
    }
}
