<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
            $this->addFlash(
               'info',
               "La liste des todos vient d'être initialisée"
            );
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name,$content):RedirectResponse{
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(isset($todos[$name])) {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name existe déjà"
                 );
            } else {
                $todos[$name] = $content;
                $this->addFlash(
                    'success',
                    "Le todo d'id $name a été ajouté"
                 );
                 $session->set('todos',$todos);
            }
        } else{
            $this->addFlash(
               'error',
               "La liste des todos n'est pas encore initialisée"
            );
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name,$content):RedirectResponse{
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(!isset($todos[$name])) {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name n'existe pas"
                 );
            } else {
                $todos[$name] = $content;
                $session->set('todos',$todos);
                $this->addFlash(
                    'success',
                    "Le todo d'id $name a été modifié"
                 );
                 
            }
        } else{
            $this->addFlash(
               'error',
               "La liste des todos n'est pas encore initialisée"
            );
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name):RedirectResponse{
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(!isset($todos[$name])) {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name n'existe pas dans la liste"
                 );
            } else {
                unset ($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash(
                    'success',
                    "Le todo d'id $name a été supprimé de la liste"
                 );
                 
            }
        } else{
            $this->addFlash(
               'error',
               "La liste des todos n'est pas encore initialisée"
            );
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/reset', name: 'todo.reset')]
    public function resetTodo(Request $request):RedirectResponse{
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}