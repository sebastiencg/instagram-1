<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\PostRepository;
use App\Repository\RelationshipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(PostRepository $postRepository,RelationshipsRepository $relationshipsRepository ): Response
    {
        $image=new Image();
        $imageForm= $this->createForm(ImageType::class, $image);

        $posts=$postRepository->findBy(['author'=>$this->getUser()],['id'=>'DESC']);
        $friends=count($relationshipsRepository->findBy(['freind'=>$this->getUser()])) + count($relationshipsRepository->findBy(['user'=>$this->getUser()]));
        return $this->renderForm('user/index.html.twig', [
            'user'=>$this->getUser(),
            'posts'=>$posts,
            'numberPost'=>count($posts),
            'friends'=>$friends,
            'form'=>$imageForm
        ]);
    }
}
