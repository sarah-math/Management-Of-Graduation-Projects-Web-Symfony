<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 2/10/2018
 * Time: 12:30 AM
 */

namespace GestionPfeBundle\Controller;
use GestionPfeBundle\Entity\Notification;
use GestionPfeBundle\Entity\technolgies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GestionPfeBundle\Entity\Offre;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;




class OffreController extends Controller
{
    public function ajouterOffreEntrepriseAction(Request $request)
    {
        // 1) build the form
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em=$this->getDoctrine()->getManager();
        $nbrNotif=0;
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
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);
            return $this->render('GestionPfeBundle:Offre:ajouterOffreEntreprise.html.twig',array(
                "nbrNotif"=>$nbrNotif,"result"=>$result,"notifications"=>$notifications
            ));

    }
    public function ajouterOffreEntrepriseAjaxAction(Request $request)
    {
        if($request->get('nbrDemandes')==NULL)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $offre=new Offre();

        $offre->setNbrDemandes($request->get('nbrDemandes'));
        $offre->setTitre($request->get('titre'));
        $offre->setDuree($request->get('duree'));
        $offre->setDescription($request->get('Description'));
        $offre->setIdUser($user);
        $offre->setEtat(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($offre);
        $em->flush();

        for ($x = 1; $x <= $request->get('max'); $x++)
        {
            if($request->get($x) != NULL)
            {
                $technologie=new technolgies();
                $technologie->setIdOffre($offre);
                $technologie->setTech($request->get($x));
                $em->persist($technologie);
                $em->flush();
                unset($technologie);
            }
        }

        return new Response("");
    }


    public function afficherOffreEntrepriseAction (Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $affiche = array();
        $em = $this->getDoctrine()->getManager();
        $offres=$em->getRepository("GestionPfeBundle:Offre")->findByIdUser($user);
        $result=array();
        $offress = $em->getRepository("GestionPfeBundle:Offre")->findBy(array('idUser'=>$user->getId()));
        $today = new \DateTime();
        $today=$today->format('Y-m-d H:i:s');

        foreach ($offress as $o)
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
        foreach ($offres as $offre)
        {
            $techs=$em->getRepository("GestionPfeBundle:technolgies")->findByIdOffre($offre);


            $affiche[$offre->getid()] = $techs;

        }
        $nbrNotif=0;
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);
        return $this->render('GestionPfeBundle:Offre:afficherOffreEntreprise.html.twig', array(
            "offres"=>$offres,
            "arrayKeyIsIdOffreAndValueIsArrayOfTechnologies"=>$affiche,
            "nbrNotif"=>$nbrNotif,
            "result"=>$result,"notifications"=>$notifications
        ));
    }
    public function editOffreAction (Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $offre=$em->getRepository("GestionPfeBundle:Offre")->findOneById($id);
        $technologies=$em->getRepository("GestionPfeBundle:technolgies")->findByidOffre($offre);
        $nbrNotif=0;
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);
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
        if($request->get('nbrDemandes')==NULL)
            {
                return $this->render('GestionPfeBundle:Offre:editOffre.html.twig', array(
                "offre"=>$offre,
                "technologies"=>$technologies,
                    "nbrNotif"=>$nbrNotif,
                    "result"=>$result,"notifications"=>$notifications

                ));
            }
        else
            {
                foreach ($technologies as $technology)
                {
                    $em->remove($technology);
                    $em->flush();
                }

                 $offre->setNbrDemandes($request->get('nbrDemandes'));
                 $offre->setTitre($request->get('titre'));
                 $offre->setDuree($request->get('duree'));
                 $offre->setDescription($request->get('Description'));
                 $em->persist($offre);
                 $em->flush();

                 for ($x = 1; $x <= $request->get('max'); $x++)
                 {
                     if($request->get($x) != NULL)
                     {
                         $technologie=new technolgies();
                         $technologie->setIdOffre($offre);
                         $technologie->setTech($request->get($x));
                         $em->persist($technologie);
                         $em->flush();
                         unset($technologie);
                     }
                 }

                return new Response("");
            }
    }
    public function approuverOffresAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        if($request->get('idOffre') == NULL)
        {
            $affiche = array();
            $offres = $em->getRepository("GestionPfeBundle:Offre")->findByEtat(false);
            foreach ($offres as $offre) {
                $techs = $em->getRepository("GestionPfeBundle:technolgies")->findByIdOffre($offre);


                $affiche[$offre->getid()] = $techs;

            }
            return $this->render('GestionPfeBundle:Offre:afficherOffreAdmin.html.twig', array(
                "offres" => $offres,
                "arrayKeyIsIdOffreAndValueIsArrayOfTechnologies" => $affiche
            ));
        }
        else
            {
                $offre = $em->getRepository("GestionPfeBundle:Offre")->findOneById($request->get('idOffre'));
                $offre->setEtat(true);
                $em->persist($offre);
                $em->flush();
                $notification=new Notification();
                $today = new \DateTime('now');
                $today->format('Y-m-d H:i:s');
                $notification->setDate($today);
                $notification->setEtat(false);
                $notification->setMessage("Votre Offre ".$offre->getTitre()." a été validé");
                $notification->setIdUser($offre->getIdUser());
                $em->persist($notification);
                $em->flush();
                return new Response("");
            }
    }




}

