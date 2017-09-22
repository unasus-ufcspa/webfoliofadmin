<?php

namespace AppBundle\Entity;

/**
 * TbNoticeDevice
 */
class TbNoticeDevice
{
    /**
     * @var integer
     */
    private $idNoticeDevice;

    /**
     * @var \AppBundle\Entity\TbNotice
     */
    private $idNotice;

    /**
     * @var \AppBundle\Entity\TbDevice
     */
    private $idDevice;


    /**
     * Get idNoticeDevice
     *
     * @return integer
     */
    public function getIdNoticeDevice()
    {
        return $this->idNoticeDevice;
    }

    /**
     * Set idNotice
     *
     * @param \AppBundle\Entity\TbNotice $idNotice
     *
     * @return TbNoticeDevice
     */
    public function setIdNotice(\AppBundle\Entity\TbNotice $idNotice = null)
    {
        $this->idNotice = $idNotice;
    
        return $this;
    }

    /**
     * Get idNotice
     *
     * @return \AppBundle\Entity\TbNotice
     */
    public function getIdNotice()
    {
        return $this->idNotice;
    }

    /**
     * Set idDevice
     *
     * @param \AppBundle\Entity\TbDevice $idDevice
     *
     * @return TbNoticeDevice
     */
    public function setIdDevice(\AppBundle\Entity\TbDevice $idDevice = null)
    {
        $this->idDevice = $idDevice;
    
        return $this;
    }

    /**
     * Get idDevice
     *
     * @return \AppBundle\Entity\TbDevice
     */
    public function getIdDevice()
    {
        return $this->idDevice;
    }
}
