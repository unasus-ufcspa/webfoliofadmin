<?php

namespace AppBundle\Entity;

/**
 * TbClassTutor
 */
class TbClassTutor
{
    /**
     * @var integer
     */
    private $idClassTutor;

    /**
     * @var \AppBundle\Entity\TbClass
     */
    private $idClass;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idTutor;


    /**
     * Get idClassTutor
     *
     * @return integer
     */
    public function getIdClassTutor()
    {
        return $this->idClassTutor;
    }

    /**
     * Set idClass
     *
     * @param \AppBundle\Entity\TbClass $idClass
     *
     * @return TbClassTutor
     */
    public function setIdClass(\AppBundle\Entity\TbClass $idClass = null)
    {
        $this->idClass = $idClass;
    
        return $this;
    }

    /**
     * Get idClass
     *
     * @return \AppBundle\Entity\TbClass
     */
    public function getIdClass()
    {
        return $this->idClass;
    }

    /**
     * Set idTutor
     *
     * @param \AppBundle\Entity\TbUser $idTutor
     *
     * @return TbClassTutor
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
