<?php

namespace GestionPfeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;

class AffectationController extends Controller
{
    public function AfficherSoutenancesAffectesAction()
    {
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $affectations=$em->getRepository("GestionPfeBundle:Affectation")->findByIdEnseignant($user);
       /* $soutenances=array();
        foreach ($affectations as $affectation)
        {
            $soutenance=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($affectation->getIdEnseignant());
            array_push($soutenances,$soutenance);
            unset($soutenance);
        }*/

        return $this->render('GestionPfeBundle:Affectation:afficher_soutenances_affectes.html.twig', array(
           // "soutenances"=>$soutenances,
            "affectations"=>$affectations
            // ...
        ));
    }

}
