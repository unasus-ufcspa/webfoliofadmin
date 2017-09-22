<?php

namespace AppBundle\Entity;

/**
 * TbAnnotation
 */
class TbAnnotation
{
    /**
     * @var integer
     */
    private $idAnnotation;

    /**
     * @var string
     */
    private $dsAnnotation;

    /**
     * @var integer
     */
    private $idAnnotationSrv;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idUser;


    /**
     * Get idAnnotation
     *
     * @return integer
     */
    public function getIdAnnotation()
    {
        return $this->idAnnotation;
    }

    /**
     * Set dsAnnotation
     *
     * @param string $dsAnnotation
     *
     * @return TbAnnotation
     */
    public function setDsAnnotation($dsAnnotation)
    {
        $this->dsAnnotation = $dsAnnotation;
    
        return $this;
    }

    /**
     * Get dsAnnotation
     *
     * @return string
     */
    public function getDsAnnotation()
    {
        return $this->dsAnnotation;
    }

    /**
     * Set idAnnotationSrv
     *
     * @param integer $idAnnotationSrv
     *
     * @return TbAnnotation
     */
    public function setIdAnnotationSrv($idAnnotationSrv)
    {
        $this->idAnnotationSrv = $idAnnotationSrv;
    
        return $this;
    }

    /**
     * Get idAnnotationSrv
     *
     * @return integer
     */
    public function getIdAnnotationSrv()
    {
        return $this->idAnnotationSrv;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\TbUser $idUser
     *
     * @return TbAnnotation
     */
    public function setIdUser(\AppBundle\Entity\TbUser $idUser = null)
    {
        $this->idUser = $idUser;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
