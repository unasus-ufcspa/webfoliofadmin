<?php

namespace AppBundle\Entity;

/**
 * TbCommentVersion
 */
class TbCommentVersion
{
    /**
     * @var integer
     */
    private $idCommentVersion;

    /**
     * @var string
     */
    private $txReference;

    /**
     * @var integer
     */
    private $nuCommentActivity;

    /**
     * @var integer
     */
    private $nuInitialPos;

    /**
     * @var integer
     */
    private $nuSize;

    /**
     * @var integer
     */
    private $idCommentVersionSrv;

    /**
     * @var integer
     */
    private $flSrv;

    /**
     * @var \AppBundle\Entity\TbVersionActivity
     */
    private $idVersionActivity;


    /**
     * Get idCommentVersion
     *
     * @return integer
     */
    public function getIdCommentVersion()
    {
        return $this->idCommentVersion;
    }

    /**
     * Set txReference
     *
     * @param string $txReference
     *
     * @return TbCommentVersion
     */
    public function setTxReference($txReference)
    {
        $this->txReference = $txReference;
    
        return $this;
    }

    /**
     * Get txReference
     *
     * @return string
     */
    public function getTxReference()
    {
        return $this->txReference;
    }

    /**
     * Set nuCommentActivity
     *
     * @param integer $nuCommentActivity
     *
     * @return TbCommentVersion
     */
    public function setNuCommentActivity($nuCommentActivity)
    {
        $this->nuCommentActivity = $nuCommentActivity;
    
        return $this;
    }

    /**
     * Get nuCommentActivity
     *
     * @return integer
     */
    public function getNuCommentActivity()
    {
        return $this->nuCommentActivity;
    }

    /**
     * Set nuInitialPos
     *
     * @param integer $nuInitialPos
     *
     * @return TbCommentVersion
     */
    public function setNuInitialPos($nuInitialPos)
    {
        $this->nuInitialPos = $nuInitialPos;
    
        return $this;
    }

    /**
     * Get nuInitialPos
     *
     * @return integer
     */
    public function getNuInitialPos()
    {
        return $this->nuInitialPos;
    }

    /**
     * Set nuSize
     *
     * @param integer $nuSize
     *
     * @return TbCommentVersion
     */
    public function setNuSize($nuSize)
    {
        $this->nuSize = $nuSize;
    
        return $this;
    }

    /**
     * Get nuSize
     *
     * @return integer
     */
    public function getNuSize()
    {
        return $this->nuSize;
    }

    /**
     * Set idCommentVersionSrv
     *
     * @param integer $idCommentVersionSrv
     *
     * @return TbCommentVersion
     */
    public function setIdCommentVersionSrv($idCommentVersionSrv)
    {
        $this->idCommentVersionSrv = $idCommentVersionSrv;
    
        return $this;
    }

    /**
     * Get idCommentVersionSrv
     *
     * @return integer
     */
    public function getIdCommentVersionSrv()
    {
        return $this->idCommentVersionSrv;
    }

    /**
     * Set flSrv
     *
     * @param integer $flSrv
     *
     * @return TbCommentVersion
     */
    public function setFlSrv($flSrv)
    {
        $this->flSrv = $flSrv;
    
        return $this;
    }

    /**
     * Get flSrv
     *
     * @return integer
     */
    public function getFlSrv()
    {
        return $this->flSrv;
    }

    /**
     * Set idVersionActivity
     *
     * @param \AppBundle\Entity\TbVersionActivity $idVersionActivity
     *
     * @return TbCommentVersion
     */
    public function setIdVersionActivity(\AppBundle\Entity\TbVersionActivity $idVersionActivity = null)
    {
        $this->idVersionActivity = $idVersionActivity;
    
        return $this;
    }

    /**
     * Get idVersionActivity
     *
     * @return \AppBundle\Entity\TbVersionActivity
     */
    public function getIdVersionActivity()
    {
        return $this->idVersionActivity;
    }
}
