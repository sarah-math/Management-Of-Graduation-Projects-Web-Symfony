<?php

namespace GestionPfeBundle\Controller;

use GestionPfeBundle\Entity\Affectation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SoutenanceController extends Controller
{
    public function AjouterDemandeSoutenanceAction()
    {
        return $this->render('GestionPfeBundle:Soutenance:ajouter_demande_soutenance.html.twig', array(
            // ...
        ));
    }

    public function AfficherDemandeSoutenanceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $soutenances=$em->getRepository("GestionPfeBundle:Soutenance")->findAll();
        $stages=array();
        foreach ($soutenances as $soutenance)
        {
            $stage=$em->getRepository("GestionPfeBundle:Stage")->findOneByIdEtudiant($soutenance->getIdUser());
            array_push($stages,$stage);
            unset($stage);
        }
        $temps=$em->getRepository("GestionPfeBundle:User")->findAll();
        $prof=array();
        foreach ($temps as $temp)
        {
            if($temp->hasRole("ROLE_ENSEIGNANT"))
                array_push($prof,$temp);
        }
        unset($temps);
        //var_dump($prof);
        return $this->render('GestionPfeBundle:Soutenance:afficher_demande_soutenance.html.twig', array(
            "soutenances"=>$soutenances,
            "stages"=>$stages,
            "profs"=>$prof
            // ...
        ));
    }

    public function AjouterSoutenanceAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $soutenance=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get('ids'));
        $jury=$em->getRepository("GestionPfeBundle:User")->findOneById($request->get('jury'));
       // $salle=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get('salle'));
        $soutenance->setType("technique");
        $date= \DateTime::createFromFormat('d/m/Y H:i',$request->get('date'));
        $date->format('Y-m-d H:i');
        $soutenance->setDateSoutenanceTechnique($date);
        $soutenance->setSalle($request->get('salle'));
        $affectation=new Affectation();
        $affectation->setIdEnseignant($jury);
        $affectation->setIdSoutenance($soutenance);

        $em->persist($affectation);
        $em->persist($soutenance);

        $em->flush();
        return new Response("gg");
    }

    public function AfficherSoutenanceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $soutenances=$em->getRepository("GestionPfeBundle:Soutenance")->findAll();
        $stages=array();
        foreach ($soutenances as $soutenance)
        {
            $stage=$em->getRepository("GestionPfeBundle:Stage")->findOneByIdEtudiant($soutenance->getIdUser());
            array_push($stages,$stage);
            unset($stage);
        }
        $temps=$em->getRepository("GestionPfeBundle:User")->findAll();
        $prof=array();
        foreach ($temps as $temp)
        {
            if($temp->hasRole("ROLE_ENSEIGNANT"))
                array_push($prof,$temp);
        }
        unset($temps);
        return $this->render('GestionPfeBundle:Soutenance:afficher_soutenance.html.twig', array(
            "soutenances"=>$soutenances,
            "stages"=>$stages,
            "profs"=>$prof
            // ...
        ));
    }

    public function ModiferSoutenanceAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $soutenance=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get("ids"));
        $soutenance->setSalle($request->get('salle'));
        $date= \DateTime::createFromFormat('d/m/Y H:i',$request->get('date'));
        $date->format('Y-m-d H:i');
        $soutenance->setDateSoutenanceTechnique($date);
        $em->persist($soutenance);
        $em->flush();
        return new Response("gg");
    }

    public function AffecterJuryAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $soutenance=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get('ids'));
        $jury1=$em->getRepository("GestionPfeBundle:User")->findOneById($request->get('jury1'));
        $jury2=$em->getRepository("GestionPfeBundle:User")->findOneById($request->get('jury2'));
        $jury3=$em->getRepository("GestionPfeBundle:User")->findOneById($request->get('jury3'));
        // $salle=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get('salle'));
        $soutenance->setType("commerciale");
        $date= \DateTime::createFromFormat('d/m/Y H:i',$request->get('date'));
        $date->format('Y-m-d H:i');
        $soutenance->setDateSoutenanceCommercial($date);
        $soutenance->setSalle($request->get('salle'));
        $affectation=new Affectation();
        $affectation->setIdEnseignant($jury1);
        $affectation->setIdSoutenance($soutenance);
        $em->persist($affectation);
        $em->persist($soutenance);
        $em->flush();
        $affectation1=new Affectation();
        $affectation1->setIdEnseignant($jury2);
        $affectation1->setIdSoutenance($soutenance);
        $em->persist($affectation1);
        $em->flush();
        $affectation2=new Affectation();
        $affectation2->setIdEnseignant($jury3);
        $affectation2->setIdSoutenance($soutenance);
        $em->persist($affectation2);
        $em->flush();
        return new Response("gg");
    }

    public function ModiferJuryAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $soutenance=$em->getRepository("GestionPfeBundle:Soutenance")->findOneById($request->get("ids"));
        $soutenance->setSalle($request->get('salle'));
        $date= \DateTime::createFromFormat('d/m/Y H:i',$request->get('date'));
        $date->format('Y-m-d H:i');
        $soutenance->setDateSoutenanceCommercial($date);
        $em->persist($soutenance);
        $em->flush();
        return new Response("gg");
    }

    public function ArchiverSoutenanceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $soutenances=$em->getRepository("GestionPfeBundle:Soutenance")->findAll();
        $stages=array();
        foreach ($soutenances as $soutenance)
        {
            $stage=$em->getRepository("GestionPfeBundle:Stage")->findOneByIdEtudiant($soutenance->getIdUser());
            array_push($stages,$stage);
            unset($stage);
        }
        $temps=$em->getRepository("GestionPfeBundle:User")->findAll();
        $prof=array();
        foreach ($temps as $temp)
        {
            if($temp->hasRole("ROLE_ENSEIGNANT"))
                array_push($prof,$temp);
        }
        unset($temps);
        return $this->render('GestionPfeBundle:Soutenance:archiver_soutenance.html.twig', array(
            "soutenances"=>$soutenances,
            "stages"=>$stages,
            "profs"=>$prof
            // ...
        ));
    }

}
