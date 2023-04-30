<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository, UserRepository $userRepository): Response
    {
        $guy=$postRepository->findBy([],['id'=>'DESC'],5);
        return $this->render('post/index.html.twig', [
            'users'=>$postRepository->findBy([],['id'=>'DESC'],5),
            'posts'=>$userRepository->findBy([],['id'=>'DESC'])
        ]);
    }
}
