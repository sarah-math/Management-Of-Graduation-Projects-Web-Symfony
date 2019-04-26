<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\CvRepository")
 */
class Cv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var string
     *
     * @ORM\Column(name="dateModif", type="datetime" ,nullable=true)
     */
    private $dateModif;

    /**
     * @return string
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * @param string $dateModif
     */
    public function setDateModif()
    {
        $this->dateModif = new \DateTime("now");

    }


    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }
    /**
     * @var
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     */
    private $idUser;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }





}

