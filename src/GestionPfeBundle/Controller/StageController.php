<?php

namespace GestionPfeBundle\Controller;

use GestionPfeBundle\Entity\Encadrement;
use GestionPfeBundle\Entity\Stage;
use GestionPfeBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserInterface;




class StageController extends Controller
{

    public function AfficheStageAction()
    {
        $user=new User();
        $temp2=array();

        $em = $this->getDoctrine()->getManager();

        $Stage = $em->getRepository("GestionPfeBundle:Stage")
            ->findAll();

        $Encadrant = $em->getRepository("GestionPfeBundle:User")
            ->findAll();
        foreach ($Encadrant as $temp)
        {
            if($temp->hasRole("ROLE_ENSEIGNANT"))
            {
                array_push($temp2,$temp);
            }

        }

        //$Stage=array();
        return $this->render('GestionPfeBundle:Stages:afiche_stages.html.twig', array(
            "Stage"=>$Stage,"encadrant"=>$temp2
        ));
    }
    public function AfficheMesStagesAction()
    {


        return $this->render('GestionPfeBundle:Profile:mesdemandes.html.twig', array(

        ));
    }


    public function AfficheEncadrantAction()
    {
        $em = $this->getDoctrine()->getManager();


        return $this->render('GestionPfeBundle:Stages:afiche_encadrant.html.twig', array(

        ));
    }
    public function AffecterEncadrantAction(Request $request)
    {
      $idStage = $request->get('idStage');
      $idEncadrant = $request->get('idEncadrant');
      $em= $this->getDoctrine()->getManager();
        $Stage = $em->getRepository("GestionPfeBundle:Stage")
            ->findOneById($idStage);

        $encadrant = $em->getRepository("GestionPfeBundle:User")
            ->findOneById($idEncadrant);

        $Stage->setIdEncadrant($encadrant);
        $em->persist($Stage);
        $em->flush();
        $encadrement=new Encadrement();
        $encadrement->setIdStage($Stage);
        $em->persist($encadrement);
        $em->flush();

       return New Response('Ok');

    }

    public function AnnulerEncadrantAction(Request $request)
    {
        $idStage = $request->get('idStage');

        $em= $this->getDoctrine()->getManager();
        $Stage = $em->getRepository("GestionPfeBundle:Stage")
            ->findOneById($idStage);

        $Stage->setIdEncadrant(null);
        $em->persist($Stage);
        $em->flush();
        $Encadrement = $em->getRepository("GestionPfeBundle:Encadrement")
            ->findOneBy(array("idStage"=>$idStage));
        $em->remove($Encadrement);
        $em->flush();

        return New Response('Ok');

    }

    public function confirmerDemandeAction(Request $request, $id) {
            $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $demande=$em->getRepository("GestionPfeBundle:Demandes")->findOneById($id);

            $idetudiant=$em->getRepository("GestionPfeBundle:User")->findOneById($demande->getIdUser());

            $offre=$em->getRepository("GestionPfeBundle:Offre")->findOneById($demande->getIdOffre());

            $titreOffre=$em->getRepository("GestionPfeBundle:Offre")->findOneBy(array("titre"=>$offre->getTitre()));

            $descriptionOffre=$em->getRepository("GestionPfeBundle:Offre")
                ->findOneBy(array("description"=>$offre->getDescription()));


            $identreprise=$em->getRepository("GestionPfeBundle:User")->findOneById($offre->getIdUser());



            $demandess=$em->getRepository("GestionPfeBundle:Demandes")->findOneById($user->getId());

            $stage=new Stage();
            $stage->setDescreptif($descriptionOffre);
            $stage->setIdEntreprise($identreprise);
            $stage->setIdEtudiant($idetudiant);
            $stage->setTitreStage($titreOffre);
            $em->persist($stage);
            $demande->setConfirmation(1);
            $em->persist($demande);
            $em->flush();
            $em->flush();
        return $this->render('GestionPfeBundle:Default:index.html.twig', array(

        ));

    }



}
