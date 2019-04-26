<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affectation
 *
 * @ORM\Table(name="affectation")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\AffectationRepository")
 */
class Affectation
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
     * @ORM\JoinColumn(name="idenseignant", referencedColumnName="id")
     */
    private $idEnseignant;

    /**
     * Affectation constructor.
     * @param $idEnseignant
     * @param $idSoutenance
     */


    /**
     * @return mixed
     */
    public function getIdSoutenance()
    {
        return $this->idSoutenance;
    }

    /**
     * @param mixed $idSoutenance
     */
    public function setIdSoutenance($idSoutenance)
    {
        $this->idSoutenance = $idSoutenance;
    }

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Soutenance")
     * @ORM\JoinColumn(name="idsoutenance", referencedColumnName="id")
     */
    private $idSoutenance;


    /**
     * @return mixed
     */
    public function getIdEnseignant()
    {
        return $this->idEnseignant;
    }

    /**
     * @param mixed $idEnseignant
     */
    public function setIdEnseignant($idEnseignant)
    {
        $this->idEnseignant = $idEnseignant;
    }


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

