<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table(name="stage")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\StageRepository")
 */
class Stage
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
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="identreprise", referencedColumnName="id")
     */
    private $idEntreprise;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idencadrant", referencedColumnName="id")
     */
    private $idEncadrant;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idetudiant", referencedColumnName="id")
     */
    private $idEtudiant;



    /**
     * @return mixed
     */
    public function getIdEntreprise()
    {
        return $this->idEntreprise;
    }

    /**
     * @param mixed $idEntreprise
     */
    public function setIdEntreprise($idEntreprise)
    {
        $this->idEntreprise = $idEntreprise;
    }

    /**
     * @return mixed
     */
    public function getIdEncadrant()
    {
        return $this->idEncadrant;
    }

    /**
     * @param mixed $idEncadrant
     */
    public function setIdEncadrant($idEncadrant)
    {
        $this->idEncadrant = $idEncadrant;
    }

    /**
     * @return mixed
     */
    public function getIdEtudiant()
    {
        return $this->idEtudiant;
    }

    /**
     * @param mixed $idEtudiant
     */
    public function setIdEtudiant($idEtudiant)
    {
        $this->idEtudiant = $idEtudiant;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="titreStage", type="string", length=255)
     */
    private $titreStage;

    /**
     * @var string
     *
     * @ORM\Column(name="Descreptif", type="string", length=5000)
     */
    private $descreptif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $dateFin;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titreStage
     *
     * @param string $titreStage
     *
     * @return Stage
     */
    public function setTitreStage($titreStage)
    {
        $this->titreStage = $titreStage;

        return $this;
    }

    /**
     * Get titreStage
     *
     * @return string
     */
    public function getTitreStage()
    {
        return $this->titreStage;
    }

    /**
     * Set descreptif
     *
     * @param string $descreptif
     *
     * @return Stage
     */
    public function setDescreptif($descreptif)
    {
        $this->descreptif = $descreptif;

        return $this;
    }

    /**
     * Get descreptif
     *
     * @return string
     */
    public function getDescreptif()
    {
        return $this->descreptif;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Stage
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Stage
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
}

