<?php

// IndexController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class IndexController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('index/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/delete-user/{id}', name: 'delete_user')]
        public function deleteUser(User $user): Response
        {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        
            // Rediriger vers la page d'index après la suppression
            return $this->redirectToRoute('app_index');
        }
}

