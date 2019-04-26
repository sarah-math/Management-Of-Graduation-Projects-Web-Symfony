<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 2/13/2018
 * Time: 4:44 PM
 */

namespace GestionPfeBundle\Controller;
use GestionPfeBundle\Entity\technolgies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GestionPfeBundle\Entity\Offre;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class TechnologiesController extends Controller
{
    public function deleteTechAction (Request $request)
    {
        if($request->get('id')==NULL)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $tech=$em->getRepository("GestionPfeBundle:technolgies")->findOneById($request->get('id'));
        $em->remove($tech);
        $em->flush();
        return new Response("");
    }
}