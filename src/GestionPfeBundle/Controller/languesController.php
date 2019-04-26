<?php

namespace GestionPfeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\Cv;
use GestionPfeBundle\Entity\langues;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class languesController extends Controller
{
    public function ajoutLangueAction(Request $request)
    {$user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em=$this->getDoctrine()->getManager();
       $lang= new langues();
        $em=$this->getDoctrine()->getManager();
        $cv =$em->getRepository("GestionPfeBundle:Cv")->find($request->get('idcv'));
        $lang->setIdcv($cv);
        $lang->setLangue($request->get('langue'));
        $lang->setNiveau($request->get('niveau'));
        $em->persist($lang);
        $em->flush();

        return new Response($lang->getId());

    }

    public function ModifierLangueAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em =$this->getDoctrine()->getManager();
        $lang =$em->getRepository("GestionPfeBundle:langues")->findOneById($request->get('idl'));
        $lang->setLangue($request->get('langue'));
        $lang->setNiveau($request->get('niveau'));
        $em->persist($lang);
        $em->flush();

        return new Response("ok");
    }

    public function supprimerLangueAction()
    {
        return $this->render('GestionPfeBundle:langues:supprimer_langue.html.twig', array(
            // ...
        ));
    }

}
