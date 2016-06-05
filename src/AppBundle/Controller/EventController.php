<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Evento;
use AppBundle\Form\EventoType;

class EventController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }
    
    /**
     * @Route("/eventos/add", name="add")
    */ 
    public function addAction(Request $request)
    {
        //Generar Formulario de eventos
        $evento = new Evento();
        $form = $this->createForm(EventoType::class,$evento);
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($evento);
                $flush = $em->flush();
                if($flush==null){
                    $status = "Los clientes ya pueden disfrutar de un nuevo evento";
                }else{
                    $status = "No se ha podido crear el evento revise los campos";
                }
                
                $status = "Los clientes ya pueden disfrutar de un nuevo evento";
            }else{
                $status = "No se ha podido crear el evento revise los campos";
            }
             $this->session->getFlashbag()->add("status",$status);
        }
        
       
        
        return $this->render('default/evento.html.twig',array(
            "form" => $form->createView()
        ));
    }
}