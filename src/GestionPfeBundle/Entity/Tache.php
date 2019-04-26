<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table(name="tache")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\TacheRepository")
 */
class Tache
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
     * @ORM\Column(name="tache", type="string", length=5000)
     */
    private $tache;

    /**
     * @var bool
     *
     * @ORM\Column(name="Etat", type="boolean")
     */
    private $etat;

    /**
     * Tache constructor.
     * @param string $tache
     * @param bool $etat
     * @param $idStage
     */

    /**
     * @return mixed
     */
    public function getIdStage()
    {
        return $this->idStage;
    }

    /**
     * @param mixed $idStage
     */
    public function setIdStage($idStage)
    {
        $this->idStage = $idStage;
    }
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Stage")
     * @ORM\JoinColumn(name="idestage", referencedColumnName="id")
     */
    private $idStage;


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
     * Set tache
     *
     * @param string $tache
     *
     * @return Tache
     */
    public function setTache($tache)
    {
        $this->tache = $tache;

        return $this;
    }

    /**
     * Get tache
     *
     * @return string
     */
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Tache
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return bool
     */
    public function getEtat()
    {
        return $this->etat;
    }
}

