<?php

namespace AppBundle\Entity;

/**
 * TbClassStudent
 */
class TbClassStudent
{
    /**
     * @var integer
     */
    private $idClassStudent;

    /**
     * @var \AppBundle\Entity\TbClass
     */
    private $idClass;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idStudent;


    /**
     * Get idClassStudent
     *
     * @return integer
     */
    public function getIdClassStudent()
    {
        return $this->idClassStudent;
    }

    /**
     * Set idClass
     *
     * @param \AppBundle\Entity\TbClass $idClass
     *
     * @return TbClassStudent
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
     * Set idStudent
     *
     * @param \AppBundle\Entity\TbUser $idStudent
     *
     * @return TbClassStudent
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
}

