<?php

namespace GestionPfeBundle\Controller;
use FOS\UserBundle\Model\UserInterface;
use GestionPfeBundle\Entity\centresInterets;
use GestionPfeBundle\Entity\CompetencesTechniques;
use GestionPfeBundle\Entity\Cv;
use GestionPfeBundle\Entity\formations;
use GestionPfeBundle\Entity\langues;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CvController extends Controller
{
    public function RemplirCvAction(Request $request)
    {
        //cv iduser
            $cv=new Cv();
            $em=$this->getDoctrine()->getManager();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $cv->setIdUser($user);

            $em->persist($cv);
            $em->flush();


            for($f=1;$f<=intval($request->get('maxformation'));$f++)
            {

                if($request->get('formation'.$f)!=null && $request->get('formation'.$f)!="")
                {
                    $formation=new formations();
                    $formation->setIdcv($cv);
                    $formation->setFormation($request->get('formation'.$f));
                    $em->persist($formation);
                    $em->flush();
                }

            }

        for($l=1;$l<=intval($request->get('maxlangue'));$l++)
        {

            if($request->get('langue'.$l)!=null && $request->get('langue'.$l)!="")
            {
                $langue=new langues();
                $langue->setIdcv($cv);
                $langue->setLangue($request->get('langue'.$l));
                $em->persist($langue);
                $em->flush();
            }

        }

        for($c=1;$c<=intval($request->get('maxcentre'));$c++)
        {

            if($request->get('centre'.$c)!=null && $request->get('centre'.$c)!="")
            {
                $centre=new centresInterets();
                $centre->setIdcv($cv);
                $centre->setCentreInteret($request->get('centre'.$c));
                $em->persist($centre);
                $em->flush();
            }

        }

        for($t=1;$t<=intval($request->get('maxtech'));$t++)
        {

            if($request->get('tech'.$t)!=null && $request->get('tech'.$t)!="")
            {
                $tech=new CompetencesTechniques();
                $tech->setIdcv($cv);
                $tech->setCompetence($request->get('tech'.$t));
                $em->persist($tech);
                $em->flush();
            }

        }
            $response= new Response("Bravo !");
            return $response;


    }


    public function AfficheCvAction()
    {   $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();

        $cv =$em->getRepository("GestionPfeBundle:Cv")->findOneBy(array("idUser"=>$user->getId()));
        if($cv==null){
            return $this->redirectToRoute('_afficheform_cv');
        }
        $formation=$em->getRepository("GestionPfeBundle:formations")->findBy(array("idcv"=>$cv->getId()));
        $langue=$em->getRepository("GestionPfeBundle:langues")->findBy(array("idcv"=>$cv->getId()));
        $centre=$em->getRepository("GestionPfeBundle:centresInterets")->findBy(array("idcv"=>$cv->getId()));
        $tech=$em->getRepository("GestionPfeBundle:CompetencesTechniques")->findBy(array("idCv"=>$cv->getId()));

        return $this->render('GestionPfeBundle:Cv:affiche_cv.html.twig', array(
        "cv"=>$cv ,"formation"=>$formation ,"langue"=>$langue ,"centre"=>$centre,"tech"=>$tech           // ...
        ));
    }

    public function afficheformcvAction()
    {   $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }


        $user = $this->container->get('security.token_storage')->getToken()->getUser();
          $em =$this->getDoctrine()->getManager();

        $cv =$em->getRepository("GestionPfeBundle:Cv")->findOneBy(array("idUser"=>$user->getId()));
        if($cv!=null){
           return $this->redirectToRoute('_affiche_cv');
        }


        return $this->render('GestionPfeBundle:Cv:afficheform_cv.html.twig', array(
            // ...
        ));
    }

    public function ModifierCvAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $cv = $em->getRepository("GestionPfeBundle:Cv")->find($id);
        $em->remove($cv);
        $em->flush();
        return $this->redirectToRoute('_afficheform_cv');

    }

}
