<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demandes
 *
 * @ORM\Table(name="demandes")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\DemandesRepository")
 */
class Demandes
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
     * @var bool
     *
     * @ORM\Column(name="etatDemande", type="boolean",nullable=true)
     */
    private $etatDemande;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEntretien", type="datetime", nullable=true)
     */
    private $dateEntretien;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDemande", type="datetime", nullable=true)
     */
    private $dateDemande;

    /**
     * @var bool
     *
     * @ORM\Column(name="etatEntretien", type="boolean",nullable=true)
     */
    private $etatEntretien;

    /**
     * @var string
     *
     * @ORM\Column(name="methodeCommunication", type="string", nullable=true)
     */
    private $methodeCommunication;


    /**
     * @var bool
     *
     * @ORM\Column(name="confirmation", type="boolean", nullable=true)
     */
    private $confirmation;

    /**
     * @return mixed
     */
    public function getIdOffre()
    {
        return $this->idOffre;
    }

    /**
     * @param mixed $idOffre
     */
    public function setIdOffre($idOffre)
    {
        $this->idOffre = $idOffre;
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
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumn(name="idoffre", referencedColumnName="id")
     */
    private $idOffre;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User")
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

    /**
     * Set etatDemande
     *
     * @param boolean $etatDemande
     *
     * @return Demandes
     */
    public function setEtatDemande($etatDemande)
    {
        $this->etatDemande = $etatDemande;

        return $this;
    }

    /**
     * Get etatDemande
     *
     * @return bool
     */
    public function getEtatDemande()
    {
        return $this->etatDemande;
    }

    /**
     * Set dateEntretien
     *
     * @param \DateTime $dateEntretien
     *
     * @return Demandes
     */
    public function setDateEntretien($dateEntretien)
    {
        $this->dateEntretien = $dateEntretien;

        return $this;
    }

    /**
     * Get dateEntretien
     *
     * @return \DateTime
     */
    public function getDateEntretien()
    {
        return $this->dateEntretien;
    }

    /**
     * Set etatEntretien
     *
     * @param boolean $etatEntretien
     *
     * @return Demandes
     */
    public function setEtatEntretien($etatEntretien)
    {
        $this->etatEntretien = $etatEntretien;

        return $this;
    }

    /**
     * Get etatEntretien
     *
     * @return bool
     */
    public function getEtatEntretien()
    {
        return $this->etatEntretien;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return Demandes
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * @return string
     */
    public function getMethodeCommunication()
    {
        return $this->methodeCommunication;
    }

    /**
     * @param string $methodeCommunication
     */
    public function setMethodeCommunication($methodeCommunication)
    {
        $this->methodeCommunication = $methodeCommunication;
    }

    /**
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * @param \DateTime $dateDemande
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;
    }


}

