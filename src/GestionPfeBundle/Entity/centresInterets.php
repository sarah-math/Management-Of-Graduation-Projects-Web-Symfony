<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * centresInterets
 *
 * @ORM\Table(name="centres_interets")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\centresInteretsRepository")
 */
class centresInterets
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
     * @ORM\Column(name="centreInteret", type="string", length=255, nullable=true)
     */
    private $centreInteret;

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
     * Set centreInteret
     *
     * @param string $centreInteret
     *
     * @return centresInterets
     */
    public function setCentreInteret($centreInteret)
    {
        $this->centreInteret = $centreInteret;

        return $this;
    }

    /**
     * Get centreInteret
     *
     * @return string
     */
    public function getCentreInteret()
    {
        return $this->centreInteret;
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

}

