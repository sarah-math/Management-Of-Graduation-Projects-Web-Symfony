<?php

namespace GestionPfeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionPfeBundle:Default:index.html.twig');
    }
    public function indexUserAction(Request $request)
    {
       $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $affiche = array();
        $resultat="";
        $blackList=array();
        $em = $this->getDoctrine()->getManager();

        $cv=$em->getRepository("GestionPfeBundle:Cv")->findOneBy(array("idUser"=>$user->getId()));
        $competences=$em->getRepository("GestionPfeBundle:CompetencesTechniques")->findByIdCv($cv);
        $pourcentages=array();
        $offres=$em->getRepository("GestionPfeBundle:Offre")->findAll();

        if ($cv !=null){
            $resultat="OK";
        }
        else $resultat="NO";

        $k=0;
        foreach ($offres as $offre)
        {   $pourcentage=array();
            $techs=$em->getRepository("GestionPfeBundle:technolgies")->findByIdOffre($offre);
            array_push($affiche,$techs);
            foreach ($techs as $tech)
            {
                foreach ($competences as $competence)
                {
                    if ( strcmp($competence->getCompetence(),$tech->getTech()) == 0)
                    {
                        $k++;
                    }
                }
            }

            $a=($k /count($techs))*100;
            array_push($pourcentage,$offre->getId());
            array_push($pourcentage,$a);
            array_push($pourcentages,$pourcentage);
            unset($pourcentage);
            $k=0;
            $demandesExist=$em->getRepository("GestionPfeBundle:Demandes")->verifpost($offre->getId(),$user->getId());

            if($demandesExist!=null)
            {   $offreDemande=$em->getRepository("GestionPfeBundle:Offre")->findOneBy(array("id"=>$demandesExist->getIdOffre()));
                  if($offreDemande!=null){
                      array_push($blackList,$offreDemande);
                  }

            }


        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $offres, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('GestionPfeBundle:Default:indexUser.html.twig', array(
            "offres"=>$pagination,
            "AllTechs"=>$affiche,"resultat"=>$resultat,"blackList"=>$blackList,
            "pourcentages"=>$pourcentages
        ));

    }
    public function indexAdminAction()
    {



        return $this->render('GestionPfeBundle:Default:indexAdmin.html.twig');
    }
    public function indexEntrepriseAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em=$this->getDoctrine()->getManager();
        $result=array();
        $offres = $em->getRepository("GestionPfeBundle:Offre")->findBy(array('idUser'=>$user->getId()));
        $today = new \DateTime();
        $today=$today->format('Y-m-d H:i:s');

        foreach ($offres as $o)
        {


            $elapsed = date_diff(date_create(), $o->getDateCreation());
            $diff=$elapsed->format('%a');


            if ($diff>=60)
            {
                $demande = $em->getRepository("GestionPfeBundle:Demandes")->verif($o->getId());
                if($demande== null)
                    array_push($result, $o);
            }
            if ($diff>=90)
            {
                $demande = $em->getRepository("GestionPfeBundle:Demandes")->verif($o->getId());
                if($demande== null)
                {
                    $supprimer=$em->getRepository("GestionPfeBundle:Offre")->find($o->getId());
                    $em->remove($supprimer);
                    $em->flush();
                }

            }


        }

        $nbrNotif=0;
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);

        return $this->render('GestionPfeBundle:Default:indexEntreprise.html.twig',array(
            "result"=>$result,
            "nbrNotif"=>$nbrNotif,
            "notifications"=>$notifications
        ));
    }
    public function indexEnseignantAction()
    {
        return $this->render('GestionPfeBundle:Default:indexEnseignant.html.twig');
    }
}
