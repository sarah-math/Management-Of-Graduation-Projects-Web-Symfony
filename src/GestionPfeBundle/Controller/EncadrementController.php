<?php

namespace GestionPfeBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use GestionPfeBundle\Entity\Tache;
use GestionPfeBundle\Form\TacheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CMEN\GoogleChartsBundle\CMENGoogleChartsBundle;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EncadrementController extends Controller
{


    public function AfficheMesEtudiantsAction() {
        $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $idencadrantstage=$em->getRepository("GestionPfeBundle:Stage")->findBy(array("idEncadrant"=>$user->getId()));

        $stages=$em->getRepository("GestionPfeBundle:Stage")->findBy(array("id"=>$idencadrantstage));
        //var_dump($stage);



       return $this->render("GestionPfeBundle:Encadrement:mesetudiants.html.twig",array("stages"=>$stages) );

    }


        public function DetailsEncadrementAction(Request $request) {
        $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $stages=$em->getRepository("GestionPfeBundle:Stage")->findOneById($request->get('id'));


        $taches=$em->getRepository("GestionPfeBundle:Tache")->findBy(array("idStage"=>$stages->getId()));



        $nbr=sizeof($taches);
        $completed=0.0;
        $noncompleted=0.0;
        foreach($taches as $t)
        {
            if($t->getEtat()==1){$completed++;}
            else {$noncompleted++;}
        }
        if ($nbr>0){
            $percent=($completed/$nbr)*100;
        }else {$percent=0.0;}

        $percent=number_format($percent, 2, '.', '');

        //CodePieChartAPI
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Etat', 'tache'],
                ['Validées',$completed],
                ['Non validées',$noncompleted]
            ]
        );
        $pieChart->getOptions()->setTitle('Le pourcentage des taches validées/non validées');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('white');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Georgia');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(23);
        $pieChart->getOptions()->setIs3D(true);
        $pieChart->getOptions()->setBackgroundColor('#222c3c');



        $encad=$em->getRepository("GestionPfeBundle:Encadrement")->findOneBy(array("idStage"=>$request->get('id')));


        if($percent==100.00){
            $encad->setEtat(true);
            $em->persist($encad);
            $em->flush();
            $temp2='Toutes vos taches ont été validés par vontre encadrant! vous pouvez maintenant passez votre soutenance';
            $this->sendMail($stages->getIdEtudiant(),$temp2);
            unset($temp2);
        }
        else
        {
            $encad->setEtat(false);
            $em->persist($encad);
            $em->flush();
        }


        $dater=$encad->getDateReunion();




        //var_dump($stage);


        return $this->render("GestionPfeBundle:Encadrement:detailsencadrement.html.twig",array("taches"=>$taches,"stage"=> $stages,'percent'=>$percent,'piechart' => $pieChart,'dater'=>$dater ));

    }

    public function ValiderTacheAction(Request $request)
    {
        $idtache = $request->get('id');

        $em= $this->getDoctrine()->getManager();


        $tache = $em->getRepository("GestionPfeBundle:Tache")
            ->findOneById($idtache);

        $tache->setEtat(true);
        $em->persist($tache);
        $em->flush();


        return New Response('Ok');

    }
    public function InvaliderTacheAction(Request $request)
    {
        $idtache = $request->get('id');

        $em= $this->getDoctrine()->getManager();


        $tache = $em->getRepository("GestionPfeBundle:Tache")
            ->findOneById($idtache);

        $tache->setEtat(false);
        $em->persist($tache);
        $em->flush();


        return New Response('Ok');

    }

    public function AjouttacheAction(Request $request)
    {



        $em= $this->getDoctrine()->getManager();

        $stages=$em->getRepository("GestionPfeBundle:Stage")->findOneById($request->get('id'));

        $tache=new Tache();
        $tache->setIdStage(($stages));
        $tache->setTache($request->get("tache"));
        $tache->setEtat(false);
        $em->persist($tache);
        $em->flush();


        return New Response($tache->getId());

    }

    public function indexAction()
    {


        return $this->render("GestionPfeBundle:Encadrement:detailsencadrement.html.twig", array());
    }

    public function AjoutDateReunionAction(Request $request)
    {


        $em= $this->getDoctrine()->getManager();

        $encad=$em->getRepository("GestionPfeBundle:Encadrement")->findOneBy(array("idStage"=>$request->get('id')));
        $stages=$em->getRepository("GestionPfeBundle:Stage")->findOneById($request->get('id'));

       $date= \DateTime::createFromFormat('Y-m-d',$request->get('date'));
       $date->format('Y-m-d');
        $encad->setDateReunion($date);
        $em->persist($encad);
        $em->flush();

        $temp='Vous avez une nouvelle Reunion Planifiée'.$request->get('date');
        $this->sendMail($stages->getIdEtudiant(),$temp);
        unset($temp);



        return New Response($encad->getId());

    }

    public function DownloadExcelAction(Request $request)
    {


        $em= $this->getDoctrine()->getManager();

        $tache=$em->getRepository("GestionPfeBundle:Tache")->findBy(array("idStage"=>$request->get('idStage')));

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Nadhem")
            ->setLastModifiedBy("Nadhem Haggui")
            ->setTitle("Liste Taches")
            ->setSubject("Liste Taches")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");

        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', "Titre Stage")
            ->setCellValue('B1', "Desciption")
            ->setCellValue('C1', "Etat")

        ;



        for($i = 0; $i < sizeof($tache); $i++)
        {
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.strval($i+2), $tache[$i]->getIdStage()->getTitreStage())
                ->setCellValue('B'.strval($i+2), $tache[$i]->getTache())
                ->setCellValue('C'.strval($i+2), $tache[$i]->getEtat())

            ;

        }

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->setActiveSheetIndex(0);
        foreach(range('A','C') as $columnID) {
            $phpExcelObject->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'Liste taches.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    private function sendMail($user,$msg){

        $mail=new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'espritpfecare@gmail.com';                 // SMTP username
            $mail->Password = 'Kiflefacebook0';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Recipients
            $mail->setFrom('espritpfecare@gmail.com', 'GestionPfeEsprit alerting mail');
            //Set who the message is to be sent to
            $mail->addAddress($user->getEmail(), $user->getNom()." ".$user->getPrenom());
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Notification';
            $html=$this->renderView(
                'GestionPfeBundle:Encadrement:mail.html.twig',
                array('user' => $user,'msg'=>$msg)
            );

            $mail->Body    = $html;
            $mail->AltBody = $msg;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }







}
