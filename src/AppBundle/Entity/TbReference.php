<?php

namespace AppBundle\Entity;

/**
 * TbReference
 */
class TbReference
{
    /**
     * @var integer
     */
    private $idReference;

    /**
     * @var string
     */
    private $dsUrl;

    /**
     * @var integer
     */
    private $idReferenceSrv;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;


    /**
     * Get idReference
     *
     * @return integer
     */
    public function getIdReference()
    {
        return $this->idReference;
    }

    /**
     * Set dsUrl
     *
     * @param string $dsUrl
     *
     * @return TbReference
     */
    public function setDsUrl($dsUrl)
    {
        $this->dsUrl = $dsUrl;
    
        return $this;
    }

    /**
     * Get dsUrl
     *
     * @return string
     */
    public function getDsUrl()
    {
        return $this->dsUrl;
    }

    /**
     * Set idReferenceSrv
     *
     * @param integer $idReferenceSrv
     *
     * @return TbReference
     */
    public function setIdReferenceSrv($idReferenceSrv)
    {
        $this->idReferenceSrv = $idReferenceSrv;
    
        return $this;
    }

    /**
     * Get idReferenceSrv
     *
     * @return integer
     */
    public function getIdReferenceSrv()
    {
        return $this->idReferenceSrv;
    }

    /**
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbReference
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
