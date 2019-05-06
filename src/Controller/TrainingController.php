<?php

namespace App\Controller;

use App\Form\ListDetailsFormModel;
use App\Form\ListDetailsFormType;
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
    public function index(Request $request)
    {
        $form = $this->createForm(ListDetailsFormType::class);
        $form->handleRequest($request);
    
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->redirectToRoute('app_lists');
        }
    
        /** @var ListDetailsFormModel $trainingSettings */
        $trainingSettings = $form->getData();
        
        return $this->render('training/index.html.twig', [
            '$trainingSettings' => $trainingSettings,
        ]);
    }
}
