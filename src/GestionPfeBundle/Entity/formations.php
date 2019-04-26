<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * formations
 *
 * @ORM\Table(name="formations")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\formationsRepository")
 */
class formations
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
     * @ORM\Column(name="formation", type="text" ,nullable=true)
     */
    private $formation;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="text" ,nullable=true)
     */
    private $annee;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Cv")
     * @ORM\JoinColumn(name="idcv", referencedColumnName="id",onDelete="CASCADE")
     */
    private $idcv;

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
     * Set formation
     *
     * @param string $formation
     *
     * @return formations
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return string
     */
    public function getFormation()
    {
        return $this->formation;
    }


    /**
     * @return mixed
     */
    public function getIdcv()
    {
        return $this->idcv;
    }

    /**
     * @param mixed $idcv
     */
    public function setIdcv($idcv)
    {
        $this->idcv = $idcv;
    }

    /**
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param string $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

}

