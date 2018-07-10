<?php

namespace AppBundle\Entity;

/**
 * TbClass
 */
class TbClass
{
    /**
     * @var integer
     */
    private $idClass;

    /**
     * @var string
     */
    private $dsCode;

    /**
     * @var string
     */
    private $dsDescription;

    /**
     * @var string
     */
    private $stStatus;

    /**
     * @var \DateTime
     */
    private $dtStart;

    /**
     * @var \DateTime
     */
    private $dtFinish;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idProposer;


    /**
     * Get idClass
     *
     * @return integer
     */
    public function getIdClass()
    {
        return $this->idClass;
    }

    /**
     * Set dsCode
     *
     * @param string $dsCode
     *
     * @return TbClass
     */
    public function setDsCode($dsCode)
    {
        $this->dsCode = $dsCode;

        return $this;
    }

    /**
     * Get dsCode
     *
     * @return string
     */
    public function getDsCode()
    {
        return $this->dsCode;
    }

    /**
     * Set dsDescription
     *
     * @param string $dsDescription
     *
     * @return TbClass
     */
    public function setDsDescription($dsDescription)
    {
        $this->dsDescription = $dsDescription;

        return $this;
    }

    /**
     * Get dsDescription
     *
     * @return string
     */
    public function getDsDescription()
    {
        return $this->dsDescription;
    }

    /**
     * Set stStatus
     *
     * @param string $stStatus
     *
     * @return TbClass
     */
    public function setStStatus($stStatus)
    {
        $this->stStatus = $stStatus;

        return $this;
    }

    /**
     * Get stStatus
     *
     * @return string
     */
    public function getStStatus()
    {
        return $this->stStatus;
    }

    /**
     * Set dtStart
     *
     * @param \DateTime $dtStart
     *
     * @return TbClass
     */
    public function setDtStart($dtStart)
    {
        $this->dtStart = $dtStart;

        return $this;
    }

    /**
     * Get dtStart
     *
     * @return \DateTime
     */
    public function getDtStart()
    {
        return $this->dtStart;
    }

    /**
     * Set dtFinish
     *
     * @param \DateTime $dtFinish
     *
     * @return TbClass
     */
    public function setDtFinish($dtFinish)
    {
        $this->dtFinish = $dtFinish;

        return $this;
    }

    /**
     * Get dtFinish
     *
     * @return \DateTime
     */
    public function getDtFinish()
    {
        return $this->dtFinish;
    }

    /**
     * Set idProposer
     *
     * @param \AppBundle\Entity\TbUser $idProposer
     *
     * @return TbClass
     */
    public function setIdProposer(\AppBundle\Entity\TbUser $idProposer = null)
    {
        $this->idProposer = $idProposer;

        return $this;
    }

    /**
     * Get idProposer
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdProposer()
    {
        return $this->idProposer;
    }
}
