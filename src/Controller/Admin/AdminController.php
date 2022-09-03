<?php

namespace App\Controller\Admin;


use App\Entity\Appointment;
use App\Entity\Speciality;
use App\Entity\User\Practitioner;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AKORY E!')
            ->disableDarkMode(false);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('PRATICIENS');
        // Section for language
        yield MenuItem::linkToCrud('PRATICIENS', 'fas fa-user-doctor', Practitioner::class)->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkToCrud('Specialités', 'fas fa-medkit', Speciality::class)->setAction(Crud::PAGE_INDEX);

        yield MenuItem::section('RENDEZ-VOUS');
        yield MenuItem::linkToCrud('Tous les rendez-vous', 'fas fa-calendar', Appointment::class)
            ->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkToCrud('Rendez-vous passé', 'fas fa-calendar-check', Appointment::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setQueryParameter('rdv', "passed");
        yield MenuItem::linkToCrud('Rendez-vous à venir', 'fas fa-calendar-plus', Appointment::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setQueryParameter('rdv', "futur");


    }
}
