<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\User;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index( EntityManagerInterface $entityManager , Request $request): Response
    {
        $profil=$this->getUser()->getProfil();
        $form= $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $entityManager->persist($profil);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_user');

    }
}
