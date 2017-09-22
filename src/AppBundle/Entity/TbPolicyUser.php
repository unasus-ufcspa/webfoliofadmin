<?php

namespace AppBundle\Entity;

/**
 * TbPolicyUser
 */
class TbPolicyUser
{
    /**
     * @var integer
     */
    private $idPolicyUser;

    /**
     * @var string
     */
    private $flAccept;

    /**
     * @var \AppBundle\Entity\TbPolicy
     */
    private $idPolicy;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idUser;


    /**
     * Get idPolicyUser
     *
     * @return integer
     */
    public function getIdPolicyUser()
    {
        return $this->idPolicyUser;
    }

    /**
     * Set flAccept
     *
     * @param string $flAccept
     *
     * @return TbPolicyUser
     */
    public function setFlAccept($flAccept)
    {
        $this->flAccept = $flAccept;
    
        return $this;
    }

    /**
     * Get flAccept
     *
     * @return string
     */
    public function getFlAccept()
    {
        return $this->flAccept;
    }

    /**
     * Set idPolicy
     *
     * @param \AppBundle\Entity\TbPolicy $idPolicy
     *
     * @return TbPolicyUser
     */
    public function setIdPolicy(\AppBundle\Entity\TbPolicy $idPolicy = null)
    {
        $this->idPolicy = $idPolicy;
    
        return $this;
    }

    /**
     * Get idPolicy
     *
     * @return \AppBundle\Entity\TbPolicy
     */
    public function getIdPolicy()
    {
        return $this->idPolicy;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\TbUser $idUser
     *
     * @return TbPolicyUser
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
