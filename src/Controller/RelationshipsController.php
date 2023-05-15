<?php

namespace App\Controller;

use App\Entity\Relationships;
use App\Entity\User;
use App\Repository\RelationshipsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelationshipsController extends AbstractController
{
    #[Route('/relationships/{id}', name: 'app_relationships')]
    public function index(EntityManagerInterface $entityManager, RelationshipsRepository $relationshipsRepository, User $user): Response
    {
        if($relationshipsRepository->findOneBy(['freind'=>$user, 'user'=>$this->getUser()]) ||  $relationshipsRepository->findOneBy(['user'=>$user, 'freind'=>$this->getUser()])){
            $data = [
                'response'=>"vous êtes deja amis ",
            ];
            return $this->json($data, 200);
        } else{
            $relation =new Relationships();
            $relation->setUser($this->getUser());
            $relation->setFreind($user);
            $entityManager->persist($relation);
            $entityManager->flush();

            $data = [
                'response'=>'vous êtes  maintenant amis',
            ];
            return $this->json($data, 200);
        }

    }
}
