<?php

namespace App\Controller\Training;

use App\Controller\BaseController;
use App\Form\DTO\MultipleListFormModel;
use App\Form\MultipleListFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultipleTrainingController
 * @IsGranted("ROLE_USER")
 */
class MultipleTrainingController extends BaseController
{
    /**
     * @Route("/multiple/training", name="app_multiple_training")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(MultipleListFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var MultipleListFormModel $selectedLists */
            $selectedLists = $form->getData();
            dd($selectedLists);
        }
        
        return $this->render('multiple_training/index.html.twig', [
            'listsForm' => $form->createView(),
        ]);
    }
}
