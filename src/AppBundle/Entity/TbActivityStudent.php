<?php

namespace AppBundle\Entity;

/**
 * TbActivityStudent
 */
class TbActivityStudent
{
    /**
     * @var integer
     */
    private $idActivityStudent;

    /**
     * @var \DateTime
     */
    private $dtConclusion;

    /**
     * @var \DateTime
     */
    private $dtFirstSync;

    /**
     * @var integer
     */
    private $idActivityStudentSrv;

    /**
     * @var \AppBundle\Entity\TbPortfolioStudent
     */
    private $idPortfolioStudent;

    /**
     * @var \AppBundle\Entity\TbActivity
     */
    private $idActivity;


    /**
     * Get idActivityStudent
     *
     * @return integer
     */
    public function getIdActivityStudent()
    {
        return $this->idActivityStudent;
    }

    /**
     * Set dtConclusion
     *
     * @param \DateTime $dtConclusion
     *
     * @return TbActivityStudent
     */
    public function setDtConclusion($dtConclusion)
    {
        $this->dtConclusion = $dtConclusion;
    
        return $this;
    }

    /**
     * Get dtConclusion
     *
     * @return \DateTime
     */
    public function getDtConclusion()
    {
        return $this->dtConclusion;
    }

    /**
     * Set dtFirstSync
     *
     * @param \DateTime $dtFirstSync
     *
     * @return TbActivityStudent
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
     * Set idActivityStudentSrv
     *
     * @param integer $idActivityStudentSrv
     *
     * @return TbActivityStudent
     */
    public function setIdActivityStudentSrv($idActivityStudentSrv)
    {
        $this->idActivityStudentSrv = $idActivityStudentSrv;
    
        return $this;
    }

    /**
     * Get idActivityStudentSrv
     *
     * @return integer
     */
    public function getIdActivityStudentSrv()
    {
        return $this->idActivityStudentSrv;
    }

    /**
     * Set idPortfolioStudent
     *
     * @param \AppBundle\Entity\TbPortfolioStudent $idPortfolioStudent
     *
     * @return TbActivityStudent
     */
    public function setIdPortfolioStudent(\AppBundle\Entity\TbPortfolioStudent $idPortfolioStudent = null)
    {
        $this->idPortfolioStudent = $idPortfolioStudent;
    
        return $this;
    }

    /**
     * Get idPortfolioStudent
     *
     * @return \AppBundle\Entity\TbPortfolioStudent
     */
    public function getIdPortfolioStudent()
    {
        return $this->idPortfolioStudent;
    }

    /**
     * Set idActivity
     *
     * @param \AppBundle\Entity\TbActivity $idActivity
     *
     * @return TbActivityStudent
     */
    public function setIdActivity(\AppBundle\Entity\TbActivity $idActivity = null)
    {
        $this->idActivity = $idActivity;
    
        return $this;
    }

    /**
     * Get idActivity
     *
     * @return \AppBundle\Entity\TbActivity
     */
    public function getIdActivity()
    {
        return $this->idActivity;
    }
}

