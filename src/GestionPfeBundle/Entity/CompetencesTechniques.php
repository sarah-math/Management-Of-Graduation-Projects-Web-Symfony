<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetencesTechniques
 *
 * @ORM\Table(name="competences_techniques")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\CompetencesTechniquesRepository")
 */
class CompetencesTechniques
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
     * @ORM\Column(name="level", type="text" ,nullable=true)
     */
    private $level;

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getIdCv()
    {
        return $this->idCv;
    }

    /**
     * @param mixed $idCv
     */
    public function setIdCv($idCv)
    {
        $this->idCv = $idCv;
    }

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Cv")
     * @ORM\JoinColumn(name="idcv", referencedColumnName="id",onDelete="CASCADE")
     */
    private $idCv;



    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="string", length=2000)
     */
    private $competence;


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
     * Set competence
     *
     * @param string $competence
     *
     * @return CompetencesTechniques
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}

