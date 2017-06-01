<?php

namespace AppBundle\Entity;

/**
 * TbGuest
 */
class TbGuest
{
    /**
     * @var integer
     */
    private $idGuest;

    /**
     * @var string
     */
    private $flComments;

    /**
     * @var \AppBundle\Entity\TbClass
     */
    private $idClass;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idUser;


    /**
     * Get idGuest
     *
     * @return integer
     */
    public function getIdGuest()
    {
        return $this->idGuest;
    }

    /**
     * Set flComments
     *
     * @param string $flComments
     *
     * @return TbGuest
     */
    public function setFlComments($flComments)
    {
        $this->flComments = $flComments;
    
        return $this;
    }

    /**
     * Get flComments
     *
     * @return string
     */
    public function getFlComments()
    {
        return $this->flComments;
    }

    /**
     * Set idClass
     *
     * @param \AppBundle\Entity\TbClass $idClass
     *
     * @return TbGuest
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
     * Set idUser
     *
     * @param \AppBundle\Entity\TbUser $idUser
     *
     * @return TbGuest
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

