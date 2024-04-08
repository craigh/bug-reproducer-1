<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/group/{id}/view', name: 'app_view_group', methods: ['GET'])]
    public function view(Group $group): Response
    {
        return $this->render('main/view.html.twig', [
            'group' => $group,
        ]);
    }

    /**
     * @throws RandomException
     */
    #[Route('/group/{id}/edit', name: 'app_edit_group', methods: ['GET'])]
    public function edit(Group $group, EntityManagerInterface $manager): Response
    {
        $group->setCount(random_int(5, 15));
        $manager->flush();

        return $this->render('main/edit.html.twig', [
            'group' => $group,
        ]);
    }
}
