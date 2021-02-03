<?php

namespace App\Controller\Admin;

use App\Entity\Exercise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
       // rediriger vers un contrôleur CRUD
       $routeBuilder = $this->get(AdminUrlGenerator::class);
       
       return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());

       // vous pouvez également rediriger vers différentes pages en fonction de l'utilisateur actuel
    //    if ('jane' === $this->getUser()->getUsername()) {
    //        return $this->redirect('...');
    //    }

       // vous pouvez également rendre un modèle pour afficher un tableau de bord approprié
       // (astuce: c'est plus facile si votre modèle s'étend de @ EasyAdmin / page / content.html.twig)
    //    return $this->render('un / chemin / mon-tableau de bord.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('O NE RM');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Entités');

        yield MenuItem::linktoDashboard('User', 'fa fa-list');
        yield MenuItem::linkToCrud('Exercise', 'fas fa-list', Exercise::class);
    }
}
