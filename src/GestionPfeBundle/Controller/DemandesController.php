<?php

namespace GestionPfeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\Demandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class DemandesController extends Controller
{
    public function PostulerAction(Request $request)
    {
        $response="";

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $demande=new Demandes();
        $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $offre =$em->getRepository("GestionPfeBundle:Offre")->findOneById($request->get("id"));

            $today = new \DateTime('now');
            $today->format('Y-m-d H:i:s');
            $demande->setIdUser($user);
            $demande->setIdOffre($offre);
            $demande->setConfirmation(null);
            $demande->setEtatDemande(null);
            $demande->setEtatEntretien(null);
            $demande->setMethodeCommunication(null);
            $demande->setDateDemande($today);
            $em->persist($demande);
            $em->flush();
            $response=new Response("GG");
             return $response;
    }

    public function SupprimerDemandeAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $demande=new Demandes();
        $em=$this->getDoctrine()->getManager();


        //$demande->setIdUser($user);
        $demande =$em->getRepository("GestionPfeBundle:Demandes")->findOneById($request->get("id"));



        $demande->setEtatDemande(false);
        $em->persist($demande);
        $em->flush();
        $response=new Response("GG");
        return $response;
    }
    public function afficherDemandeAction()
    {
        $use = $this->getUser();
        if (!is_object($use) || !$use instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $offres =$em->getRepository("GestionPfeBundle:Offre")->findBy(array("idUser"=>$user->getId()));
         $demandes=$em->getRepository("GestionPfeBundle:Demandes")->findBy(array("idOffre"=>$offres));

         //$idetudiant=$em->getRepository("GestionPfeBundle:User")->findOneById($demandes->getIdUser());
        //$tech=$em->getRepository("GestionPfeBundle:CompetencesTechniques")->findBy(array("idcv"=>$cv->getId()));
        $result=array();
        $today = new \DateTime();
        $today=$today->format('Y-m-d H:i:s');
        $pourcentages=array();
        $k=0;
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

            $pourcentage=array();
            $techs=$em->getRepository("GestionPfeBundle:technolgies")->findByIdOffre($o);
            $ds=$em->getRepository("GestionPfeBundle:Demandes")->findByIdOffre($o);
            foreach ($ds as $d)
            {
                $cv = $em->getRepository("GestionPfeBundle:Cv")->findOneBy(array("idUser" => $d->getIdUser()->getId()));
                $competences = $em->getRepository("GestionPfeBundle:CompetencesTechniques")->findByIdCv($cv);
                foreach ($techs as $tech) {
                    foreach ($competences as $competence) {
                        if (strcmp($competence->getCompetence(), $tech->getTech()) == 0) {
                            $k++;
                        }
                    }
                }
                $a = ($k / count($techs)) * 100;
                array_push($pourcentage, $o->getId());
                array_push($pourcentage, $a);
                array_push($pourcentages, $pourcentage);
                unset($pourcentage);
                unset($techs);
                unset($cv);
                unset($ds);
                unset($competences);
                $k = 0;


            }
        }

        $nbrNotif=0;
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);



        // var_dump($demandes);
        return $this->render('GestionPfeBundle:Demandes:afficher_demande.html.twig', array(
            "demandes"=>$demandes,"result"=>$result,
            "pourcentages"=>$pourcentages,"notifications"=>$notifications,"nbrNotif"=>$nbrNotif

            // ...
        ));
    }
    public function rechercheajaxAction(Request $Request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("GestionPfeBundle:User")->findOneById($Request->get('idc'));
        $demande=$em->getRepository("GestionPfeBundle:Demandes")->findOneById($Request->get('idd'));
        $cv=$em->getRepository("GestionPfeBundle:Cv")->findOneBy(array("idUser"=>$user->getId()));
        //var_dump($cv);
        $formation=$em->getRepository("GestionPfeBundle:formations")->findBy(array("idcv"=>$cv->getId()));
        $langue=$em->getRepository("GestionPfeBundle:langues")->findBy(array("idcv"=>$cv->getId()));
        $centre=$em->getRepository("GestionPfeBundle:centresInterets")->findBy(array("idcv"=>$cv->getId()));
        $tech=$em->getRepository("GestionPfeBundle:CompetencesTechniques")->findBy(array("idCv"=>$cv->getId()));


       $html=$this->render("GestionPfeBundle:Demandes:recherchePartial.html.twig",array(
          "cv"=>$cv,"formation"=>$formation ,"langue"=>$langue ,"centre"=>$centre,"tech"=>$tech,"demande"=>$demande));
        $response=new Response($html->getContent());
        return $response;
    }//FindAction*/
    public function listAccepteAction(){

    $use = $this->getUser();
    if (!is_object($use) || !$use instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
    }
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $em=$this->getDoctrine()->getManager();
    $offres =$em->getRepository("GestionPfeBundle:Offre")->findBy(array("idUser"=>$user->getId()));
    $demandes=$em->getRepository("GestionPfeBundle:Demandes")->findBy(array("idOffre"=>$offres));
        $result=array();
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


        }

        $nbrNotif=0;
        $notifications = $em->getRepository("GestionPfeBundle:Notification")->findBy(array('idUser' => $user,'etat' => false));
        $nbrNotif=count($notifications);

    // var_dump($demandes);
    return $this->render('GestionPfeBundle:Demandes:listAccept.html.twig', array(
        "demandes"=>$demandes,"result"=>$result,"notifications"=>$notifications,"nbrNotif"=>$nbrNotif
        // ...
    ));
}
    public function ValiderEntretienAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $demande=new Demandes();
        $em=$this->getDoctrine()->getManager();


        //$demande->setIdUser($user);
        $demande =$em->getRepository("GestionPfeBundle:Demandes")->findOneById($request->get("id"));

        $demande->setEtatEntretien(true);
        $em->persist($demande);
        $em->flush();
        $response=new Response("GG");
        return $response;
    }
    public function SupprimerEntretienAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $demande=new Demandes();
        $em=$this->getDoctrine()->getManager();


        //$demande->setIdUser($user);
        $demande =$em->getRepository("GestionPfeBundle:Demandes")->findOneById($request->get("id"));
        $demande->setDateEntretien(null);
        $demande->setEtatEntretien(null);
        $demande->setMethodeCommunication(null);
        $demande->setEtatDemande(null);
        $em->persist($demande);
        $em->flush();
        $response=new Response("GG");
        return $response;
    }
    public function FixerEntretienAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $demande=new Demandes();
        $em=$this->getDoctrine()->getManager();


        //$demande->setIdUser($user);
        $demande =$em->getRepository("GestionPfeBundle:Demandes")->findOneById($request->get("id"));


        $date= \DateTime::createFromFormat('d/m/Y H:i',$request->get('date'));
        $date->format('Y-m-d H:i');
        $demande->setEtatDemande(true);
        $demande->setEtatEntretien(null);
        $demande->setMethodeCommunication($request->get("methode"));
       $demande->setDateEntretien($date);
        $em->persist($demande);
        $em->flush();
        $response=new Response("GG");
        return $response;
    }
    public function pdfAction(Request $request)
    {
            $demande=new Demandes();

        $em=$this->getDoctrine()->getManager();
            $idDemande=$request->get('idDemande');
            $demande=$em->getRepository("GestionPfeBundle:Demandes")->findOneById($idDemande);
            $offre=$em->getRepository("GestionPfeBundle:Offre")->findOneById($demande->getIdOffre());
            $etudiant=$em->getRepository("GestionPfeBundle:User")->findOneById($demande->getIdUser());
            $entreprise=$em->getRepository("GestionPfeBundle:User")->findOneById($offre->getIdUser());

        $today = new \DateTime('now');
        $today->format('Y-m-d H:i:s');


        $html = $this->renderView('GestionPfeBundle:Demandes:lettreConfirmation.html.twig', array(
            'etudiant'=>$etudiant,'offre'=>$offre,'demande'=>$demande,'entreprise'=>$entreprise,'date'=>$today
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            '+216'.$etudiant->getNumeroTel().'.pdf'
        );
    }
    public function afficherDemandeAdminAction()
    {
        $use = $this->getUser();
        if (!is_object($use) || !$use instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em=$this->getDoctrine()->getManager();
        $AllDemandes=$em->getRepository("GestionPfeBundle:Demandes")->findBy(
        array(),
        array('dateDemande' => 'DESC')
    );
        $admin=array();
        foreach ($AllDemandes as $d)
        {
            array_push($admin,$d->getIdOffre()->getTitre());
        }


        $values = array_count_values($admin);

        arsort($values);
        $popular = array_slice(array_keys($values), 0, 5, true);




        return $this->render('GestionPfeBundle:Demandes:afficher_demandeAdmin.html.twig', array(
            "demandes"=>$AllDemandes,"popular"=>$popular

            // ...
        ));

    }

    public function afficherDemandeEtudiantAction(Request $request)
    {
        $use = $this->getUser();
        if (!is_object($use) || !$use instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $affiche=array();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $demandes=$em->getRepository("GestionPfeBundle:Demandes")->findBy(array("idUser"=>$user));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $demandes, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        return $this->render('GestionPfeBundle:Demandes:affiche_demandesEtudiants.html.twig', array(
            "demandes"=>$pagination,

            // ...
        ));
    }

    public function AfficheDemandesAcceptAction()
    {
        $user=new User();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $Demandes = $em->getRepository("GestionPfeBundle:Demandes")
            ->AllDemandesAccept($user->getId());
        $d = $em->getRepository("GestionPfeBundle:Demandes")
            ->verifconfirmation($user->getId());
        if($d!=null)
        {
            $test="confirmer";
        }
        else{$test="non confirmer";}

        return $this->render('GestionPfeBundle:Profile:mesdemandes.html.twig', array(
            "Demandes"=>$Demandes,'test'=>$test
        ));
    }
}
