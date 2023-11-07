<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstCtrlerController extends AbstractController
{/*
    d'abord les routes spécifiques puis les routes génériques
    */
    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first_ctrler/index.html.twig',[
            'name' => 'Copyaouti',
            'firstname' => 'Aymen'
        ]);
    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name,$firstname): Response
    {
        dd($request);
        return $this->render('first_ctrler/hello.html.twig',[
            'nom' => $name,
            'prenom' => $firstname
        ]);
    }

    #[Route(
        'multi/{entier1}/{entier2<\d+>}',
        name:'multiplication',
        requirements: ['entier1' => '\d+']
    )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
