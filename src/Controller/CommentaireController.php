<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
    #[Route('/commentaire/create/{id}', name: 'create_commentaire')]
    public function create(Request $request, EntityManagerInterface $manager, Post $post):Response
    {
        if(!$post){
            return $this->redirectToRoute('index_posts');
        }

        $comment = new Commentaire();
        $commentForm = $this->createForm(CommentaireType::class,$comment);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted() && $commentForm->isValid())
        {
            $comment->setAuthor($this->getUser());
            $comment->setPost($post);
            $comment->setCreatedAt(new \DateTime());
            $manager->persist($comment);
            $manager->flush();

        }

        return $this->redirectToRoute('show_post', ['id'=>$comment->getPost()->getId()]);

    }
}
