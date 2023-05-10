<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\RelationshipsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository, UserRepository $userRepository,RelationshipsRepository $relationshipsRepository): Response
    {

        return $this->render('post/index.html.twig', [
            'posts'=>$postRepository->findBy([],['id'=>'DESC']),
            'users'=>$userRepository->findBy([],['id'=>'DESC'],5),
            'userConnected'=>$this->getUser(),
            'relationList1'=>$relationshipsRepository->findBy(['user'=>$this->getUser()],['id'=>'DESC'],3),
            'relationList2'=>$relationshipsRepository->findBy(['freind'=>$this->getUser()],['id'=>'DESC'],3)
        ]);
    }
    #[Route('/post/create', name: 'create_post')]
    public function create(Request $request , EntityManagerInterface $entityManager): Response
    {
        /*$post=new Post();

                $form= $this->createForm(PostType::class, $post);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    $entityManager->persist($post);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_user');
                }

                return $this->render('post/create.html.twig', [
                    'postForm'=>$form->createView(),
                ]);*/

        $post = new Post();

        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            dd($post);
            $post->setAuthor($this->getUser());
            $post->setCreatedAt(new \DateTime());
            $post->setAvis(0);
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_user');
        }
        return $this->renderForm('post/create.html.twig', [
            'form'=>$form,
            'user'=>$this->getUser()
        ]);
    }
    #[Route("/post/{id}", name:"show_post")]

    public function show(Post $post, PostRepository $postRepository, RelationshipsRepository $relationshipsRepository):Response
    {

        $posts=$postRepository->findBy(['author'=>$this->getUser()],['id'=>'DESC']);
        $friends=count($relationshipsRepository->findBy(['freind'=>$this->getUser()])) + count($relationshipsRepository->findBy(['user'=>$this->getUser()]));

        $comment = new Commentaire();
        $commentForm = $this->createForm(CommentaireType::class, $comment);

        return $this->renderForm('post/show.html.twig', [
            'user'=>$this->getUser(),
            'post'=>$post,
            'commentForm'=>$commentForm,
            'posts'=>$posts,
            'numberPost'=>count($posts),
            'friends'=>$friends
        ]);
    }
}
