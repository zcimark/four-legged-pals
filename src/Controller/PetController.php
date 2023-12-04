<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PetController extends AbstractController
{
    #[Route('/pet', name: 'pet')]
    public function index(): Response
    {
        return $this->render('pet/index.html.twig', [
            'controller_name' => 'PetController',
        ]);
    }

    #[Route('/pet-register', name: 'pet_register', methods: 'POST')]
    public function post(Request $request, EntityManagerInterface $entityManager): JsonResponse 
    {
        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet);

        $form->handleRequest($request);
dd($form);
        // if (!$form->isSubmitted() || !$form->isValid()) {
            // $errors = [];
            // foreach ($form->getErrors(true) as $error) {
                // $errors[$error->getOrigin()->getName()] = $error->getMessage();
            // }

            // return new JsonResponse($errors, 400);
        // }

        $petInfo = json_decode($request->getContent(), false);

        $pet->setType($petInfo->type);
        $pet->setName($petInfo->name);
        $pet->setBreed($petInfo->breed);
        $pet->setGender($petInfo->gender);
        
        $entityManager->persist($pet);
        dd($pet);
        $entityManager->flush();

        return new JsonResponse();
    }
}