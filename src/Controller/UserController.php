<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\RelationshipsRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', priority: 2)]
    #[Route('/user/{id}', name: 'app_user_picture', priority: 2)]

    public function index(PostRepository $postRepository,RelationshipsRepository $relationshipsRepository, EntityManagerInterface $entityManager , Request $request, Profil $profil=null): Response
    {


        $form= $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            dd($form);
            $entityManager->persist($profil);
            $entityManager->flush();
            return $this->redirectToRoute('app_user');
        }
        $posts=$postRepository->findBy(['author'=>$this->getUser()],['id'=>'DESC']);
        $friends=count($relationshipsRepository->findBy(['freind'=>$this->getUser()])) + count($relationshipsRepository->findBy(['user'=>$this->getUser()]));
        return $this->renderForm('user/index.html.twig', [
            'user'=>$this->getUser(),
            'posts'=>$posts,
            'numberPost'=>count($posts),
            'friends'=>$friends,
            'form'=>$form
        ]);
    }
}
