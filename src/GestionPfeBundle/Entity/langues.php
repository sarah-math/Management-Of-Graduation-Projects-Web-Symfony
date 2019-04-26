<?php

namespace GestionPfeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * langues
 *
 * @ORM\Table(name="langues")
 * @ORM\Entity(repositoryClass="GestionPfeBundle\Repository\languesRepository")
 */
class langues
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
     * @ORM\Column(name="langue", type="string", length=255, nullable=true)
     */
    private $langue;
    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;

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
     * Set langue
     *
     * @param string $langue
     *
     * @return langues
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param string $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
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

