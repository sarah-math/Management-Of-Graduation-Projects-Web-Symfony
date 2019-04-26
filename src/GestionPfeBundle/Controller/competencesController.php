<?php

namespace GestionPfeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\CompetencesTechniques;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class competencesController extends Controller
{
    public function ajoutCompetenceAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em=$this->getDoctrine()->getManager();
        $tech= new CompetencesTechniques();
        $em=$this->getDoctrine()->getManager();
        $cv =$em->getRepository("GestionPfeBundle:Cv")->find($request->get('idcv'));
        $tech->setIdcv($cv);
        $tech->setCompetence($request->get('technologie'));
        $tech->setLevel($request->get('level'));
        $em->persist($tech);
        $em->flush();

        return new Response($tech->getId());
    }

    public function supprimerCompetenceAction()
    {
        return $this->render('GestionPfeBundle:competences:supprimer_competence.html.twig', array(
            // ...
        ));
    }

    public function modifierCompetenceAction(Request $request)
    { $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $tech=new CompetencesTechniques();
        $em =$this->getDoctrine()->getManager();
        $tech =$em->getRepository("GestionPfeBundle:CompetencesTechniques")->findOneById($request->get('idt'));
        $tech->setCompetence($request->get('competence'));
        $tech->setLevel($request->get('level'));
        $em->persist($tech);
        $em->flush();

        return new Response("ok");
    }

}
