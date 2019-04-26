<?php

namespace GestionPfeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\formations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class formationsController extends Controller
{
    public function ajoutFormationAction(Request $request)
    {$user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em=$this->getDoctrine()->getManager();
        $formation= new formations();
        $em=$this->getDoctrine()->getManager();
        $cv =$em->getRepository("GestionPfeBundle:Cv")->find($request->get('idcv'));
        $formation->setIdcv($cv);
        $formation->setFormation($request->get('formation'));
        $formation->setAnnee($request->get('annee'));
        $em->persist($formation);
        $em->flush();

        return new Response($formation->getId());

    }

    public function modifierFormationAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $formation=new formations();
        $em =$this->getDoctrine()->getManager();
        $formation =$em->getRepository("GestionPfeBundle:formations")->findOneById($request->get('idf'));
        $formation->setFormation($request->get('formation'));
        $formation->setAnnee($request->get('annee'));
        $em->persist($formation);
        $em->flush();

        return new Response("ok");
    }

    public function supprimerFormationAction()
    {
        return $this->render('GestionPfeBundle:formations:supprimer_formation.html.twig', array(
            // ...
        ));
    }

}
