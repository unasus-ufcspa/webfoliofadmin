<?php

namespace AppBundle\Entity;

/**
 * TbVersionActivity
 */
class TbVersionActivity
{
    /**
     * @var integer
     */
    private $idVersionActivity;

    /**
     * @var string
     */
    private $txActivity;

    /**
     * @var \DateTime
     */
    private $dtLastAccess;

    /**
     * @var \DateTime
     */
    private $dtSubmission;

    /**
     * @var \DateTime
     */
    private $dtVerification;

    /**
     * @var integer
     */
    private $idVersionActivitySrv;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;


    /**
     * Get idVersionActivity
     *
     * @return integer
     */
    public function getIdVersionActivity()
    {
        return $this->idVersionActivity;
    }

    /**
     * Set txActivity
     *
     * @param string $txActivity
     *
     * @return TbVersionActivity
     */
    public function setTxActivity($txActivity)
    {
        $this->txActivity = $txActivity;
    
        return $this;
    }

    /**
     * Get txActivity
     *
     * @return string
     */
    public function getTxActivity()
    {
        return $this->txActivity;
    }

    /**
     * Set dtLastAccess
     *
     * @param \DateTime $dtLastAccess
     *
     * @return TbVersionActivity
     */
    public function setDtLastAccess($dtLastAccess)
    {
        $this->dtLastAccess = $dtLastAccess;
    
        return $this;
    }

    /**
     * Get dtLastAccess
     *
     * @return \DateTime
     */
    public function getDtLastAccess()
    {
        return $this->dtLastAccess;
    }

    /**
     * Set dtSubmission
     *
     * @param \DateTime $dtSubmission
     *
     * @return TbVersionActivity
     */
    public function setDtSubmission($dtSubmission)
    {
        $this->dtSubmission = $dtSubmission;
    
        return $this;
    }

    /**
     * Get dtSubmission
     *
     * @return \DateTime
     */
    public function getDtSubmission()
    {
        return $this->dtSubmission;
    }

    /**
     * Set dtVerification
     *
     * @param \DateTime $dtVerification
     *
     * @return TbVersionActivity
     */
    public function setDtVerification($dtVerification)
    {
        $this->dtVerification = $dtVerification;
    
        return $this;
    }

    /**
     * Get dtVerification
     *
     * @return \DateTime
     */
    public function getDtVerification()
    {
        return $this->dtVerification;
    }

    /**
     * Set idVersionActivitySrv
     *
     * @param integer $idVersionActivitySrv
     *
     * @return TbVersionActivity
     */
    public function setIdVersionActivitySrv($idVersionActivitySrv)
    {
        $this->idVersionActivitySrv = $idVersionActivitySrv;
    
        return $this;
    }

    /**
     * Get idVersionActivitySrv
     *
     * @return integer
     */
    public function getIdVersionActivitySrv()
    {
        return $this->idVersionActivitySrv;
    }

    /**
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbVersionActivity
     */
    public function setIdActivityStudent(\AppBundle\Entity\TbActivityStudent $idActivityStudent = null)
    {
        $this->idActivityStudent = $idActivityStudent;
    
        return $this;
    }

    /**
     * Get idActivityStudent
     *
     * @return \AppBundle\Entity\TbActivityStudent
     */
    public function getIdActivityStudent()
    {
        return $this->idActivityStudent;
    }
}

