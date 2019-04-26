<?php

namespace GestionPfeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\centresInterets;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class centresController extends Controller
{
    public function ajoutCentreAction(Request $request)
    { $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em=$this->getDoctrine()->getManager();
        $centre= new centresInterets();
        $em=$this->getDoctrine()->getManager();
        $cv =$em->getRepository("GestionPfeBundle:Cv")->find($request->get('idcv'));
        $centre->setIdcv($cv);
        $centre->setCentreInteret($request->get('centre'));
        $em->persist($centre);
        $em->flush();

        return new Response($centre->getId());
    }

    public function modifierCentreAction(Request $request)
    { $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em =$this->getDoctrine()->getManager();
        $centres =$em->getRepository("GestionPfeBundle:centresInterets")->findOneById($request->get('idc'));
        $centres->setCentreInteret($request->get('centre'));

        $em->persist($centres);
        $em->flush();

        return new Response("ok");
    }

    public function supprimerCentreAction()
    {
        return $this->render('GestionPfeBundle:centres:supprimer_centre.html.twig', array(
            // ...
        ));
    }

}
