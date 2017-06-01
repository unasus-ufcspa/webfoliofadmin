<?php

namespace AppBundle\Entity;

/**
 * TbSyncDevice
 */
class TbSyncDevice
{
    /**
     * @var integer
     */
    private $idSyncDevice;

    /**
     * @var string
     */
    private $tpSync;

    /**
     * @var \DateTime
     */
    private $dtDevice;

    /**
     * @var \AppBundle\Entity\TbDevice
     */
    private $idDevice;

    /**
     * @var \AppBundle\Entity\TbSync
     */
    private $idSync;


    /**
     * Get idSyncDevice
     *
     * @return integer
     */
    public function getIdSyncDevice()
    {
        return $this->idSyncDevice;
    }

    /**
     * Set tpSync
     *
     * @param string $tpSync
     *
     * @return TbSyncDevice
     */
    public function setTpSync($tpSync)
    {
        $this->tpSync = $tpSync;
    
        return $this;
    }

    /**
     * Get tpSync
     *
     * @return string
     */
    public function getTpSync()
    {
        return $this->tpSync;
    }

    /**
     * Set dtDevice
     *
     * @param \DateTime $dtDevice
     *
     * @return TbSyncDevice
     */
    public function setDtDevice($dtDevice)
    {
        $this->dtDevice = $dtDevice;
    
        return $this;
    }

    /**
     * Get dtDevice
     *
     * @return \DateTime
     */
    public function getDtDevice()
    {
        return $this->dtDevice;
    }

    /**
     * Set idDevice
     *
     * @param \AppBundle\Entity\TbDevice $idDevice
     *
     * @return TbSyncDevice
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

    /**
     * Set idSync
     *
     * @param \AppBundle\Entity\TbSync $idSync
     *
     * @return TbSyncDevice
     */
    public function setIdSync(\AppBundle\Entity\TbSync $idSync = null)
    {
        $this->idSync = $idSync;
    
        return $this;
    }

    /**
     * Get idSync
     *
     * @return \AppBundle\Entity\TbSync
     */
    public function getIdSync()
    {
        return $this->idSync;
    }
}

