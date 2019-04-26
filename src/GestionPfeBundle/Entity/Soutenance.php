<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Soutenance
 *
 * @ORM\Table(name="soutenance")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\SoutenanceRepository")
 */
class Soutenance
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
     * Soutenance constructor.
     * @param $idUser
     * @param string $type
     * @param \DateTime $date
     */


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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     */
    private $idUser;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255,nullable=true)
     */
    private $type;
    /**
     * @var string
     *
     * @ORM\Column(name="salle", type="string", length=255,nullable=true)
     */
    private $salle;
    /**
     * @var bool
     *
     * @ORM\Column(name="etatDemandeSoutenance", type="boolean",nullable=true)
     */
    private $etatDemandeSoutenance;

    /**
     * @return bool
     */
    public function isEtatDemandeSoutenance()
    {
        return $this->etatDemandeSoutenance;
    }

    /**
     * @param bool $etatDemandeSoutenance
     */
    public function setEtatDemandeSoutenance($etatDemandeSoutenance)
    {
        $this->etatDemandeSoutenance = $etatDemandeSoutenance;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSoutenanceCommercial", type="datetime",nullable=true)
     */
    private $dateSoutenanceCommercial;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSoutenanceTechnique", type="datetime",nullable=true)
     */
    private $dateSoutenanceTechnique;

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
     * Set type
     *
     * @param string $type
     *
     * @return Soutenance
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateSoutenanceCommercial()
    {
        return $this->dateSoutenanceCommercial;
    }

    /**
     * @param \DateTime $dateSoutenanceCommercial
     */
    public function setDateSoutenanceCommercial($dateSoutenanceCommercial)
    {
        $this->dateSoutenanceCommercial = $dateSoutenanceCommercial;
    }

    /**
     * @return \DateTime
     */
    public function getDateSoutenanceTechnique()
    {
        return $this->dateSoutenanceTechnique;
    }

    /**
     * @param \DateTime $dateSoutenanceTechnique
     */
    public function setDateSoutenanceTechnique($dateSoutenanceTechnique)
    {
        $this->dateSoutenanceTechnique = $dateSoutenanceTechnique;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * @param string $salle
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;
    }


}

