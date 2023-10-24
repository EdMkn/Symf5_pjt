<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        //session_start()
        $session = $request->getSession();

        if(!$session->has('todos')){
            $todos = [
                'achat' => 'acheter clé USB',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos',$todos);
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name,$content){
        $session = $request->getSession();
        if($session->has('todos')){

        }
    }
}