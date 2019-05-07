<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserDeleteController
 * @IsGranted("ROLE_ADMIN")
 */
class UserDeleteController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/user/{id}/delete", name="app_user_delete")
     * @param int $id
     * @return Response
     */
    public function index(int $id)
    {
        $user = $this->userRepository->findOneBy([
            'id' => $id,
        ]);
        
        if (!isset($user)) {
            $this->addFlash('error', 'Пользователь не может быть удален');
            $this->redirectToRoute('app_admin');
        }
        
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        
        return $this->render('user_delete/index.html.twig', [
            'deletedUser' => $user,
        ]);
    }
}
