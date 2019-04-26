<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * technolgies
 *
 * @ORM\Table(name="technolgies")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\technolgiesRepository")
 */
class technolgies
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
     * @ORM\Column(name="tech", type="string", length=255)
     */
    private $tech;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumn(name="idoffre", referencedColumnName="id")
     */
    private $idOffre;

    /**
     * @return
     */
    public function getIdOffre()
    {
        return $this->idOffre;
    }

    /**
     * @param $idOffre
     */
    public function setIdOffre($idOffre)
    {
        $this->idOffre = $idOffre;
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

    /**
     * Set tech
     *
     * @param string $tech
     *
     * @return technolgies
     */
    public function setTech($tech)
    {
        $this->tech = $tech;

        return $this;
    }

    /**
     * Get tech
     *
     * @return string
     */
    public function getTech()
    {
        return $this->tech;
    }
}

