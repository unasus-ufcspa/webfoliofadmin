<?php

namespace AppBundle\Entity;

/**
 * TbPortfolioStudent
 */
class TbPortfolioStudent
{
    /**
     * @var integer
     */
    private $idPortfolioStudent;

    /**
     * @var \DateTime
     */
    private $dtFirstSync;

    /**
     * @var string
     */
    private $nuPortfolioVersion;

    /**
     * @var \AppBundle\Entity\TbPortfolioClass
     */
    private $idPortfolioClass;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idStudent;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idTutor;


    /**
     * Get idPortfolioStudent
     *
     * @return integer
     */
    public function getIdPortfolioStudent()
    {
        return $this->idPortfolioStudent;
    }

    /**
     * Set dtFirstSync
     *
     * @param \DateTime $dtFirstSync
     *
     * @return TbPortfolioStudent
     */
    public function setDtFirstSync($dtFirstSync)
    {
        $this->dtFirstSync = $dtFirstSync;
    
        return $this;
    }

    /**
     * Get dtFirstSync
     *
     * @return \DateTime
     */
    public function getDtFirstSync()
    {
        return $this->dtFirstSync;
    }

    /**
     * Set nuPortfolioVersion
     *
     * @param string $nuPortfolioVersion
     *
     * @return TbPortfolioStudent
     */
    public function setNuPortfolioVersion($nuPortfolioVersion)
    {
        $this->nuPortfolioVersion = $nuPortfolioVersion;
    
        return $this;
    }

    /**
     * Get nuPortfolioVersion
     *
     * @return string
     */
    public function getNuPortfolioVersion()
    {
        return $this->nuPortfolioVersion;
    }

    /**
     * Set idPortfolioClass
     *
     * @param \AppBundle\Entity\TbPortfolioClass $idPortfolioClass
     *
     * @return TbPortfolioStudent
     */
    public function setIdPortfolioClass(\AppBundle\Entity\TbPortfolioClass $idPortfolioClass = null)
    {
        $this->idPortfolioClass = $idPortfolioClass;
    
        return $this;
    }

    /**
     * Get idPortfolioClass
     *
     * @return \AppBundle\Entity\TbPortfolioClass
     */
    public function getIdPortfolioClass()
    {
        return $this->idPortfolioClass;
    }

    /**
     * Set idStudent
     *
     * @param \AppBundle\Entity\TbUser $idStudent
     *
     * @return TbPortfolioStudent
     */
    public function setIdStudent(\AppBundle\Entity\TbUser $idStudent = null)
    {
        $this->idStudent = $idStudent;
    
        return $this;
    }

    /**
     * Get idStudent
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdStudent()
    {
        return $this->idStudent;
    }

    /**
     * Set idTutor
     *
     * @param \AppBundle\Entity\TbUser $idTutor
     *
     * @return TbPortfolioStudent
     */
    public function setIdTutor(\AppBundle\Entity\TbUser $idTutor = null)
    {
        $this->idTutor = $idTutor;
    
        return $this;
    }

    /**
     * Get idTutor
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdTutor()
    {
        return $this->idTutor;
    }
}
