<?php

namespace AppBundle\Entity;

/**
 * TbSync
 */
class TbSync
{
    /**
     * @var integer
     */
    private $idSync;

    /**
     * @var string
     */
    private $nmTable;

    /**
     * @var integer
     */
    private $coIdTable;

    /**
     * @var \DateTime
     */
    private $dtSync;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idAuthor;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idDestination;


    /**
     * Get idSync
     *
     * @return integer
     */
    public function getIdSync()
    {
        return $this->idSync;
    }

    /**
     * Set nmTable
     *
     * @param string $nmTable
     *
     * @return TbSync
     */
    public function setNmTable($nmTable)
    {
        $this->nmTable = $nmTable;
    
        return $this;
    }

    /**
     * Get nmTable
     *
     * @return string
     */
    public function getNmTable()
    {
        return $this->nmTable;
    }

    /**
     * Set coIdTable
     *
     * @param integer $coIdTable
     *
     * @return TbSync
     */
    public function setCoIdTable($coIdTable)
    {
        $this->coIdTable = $coIdTable;
    
        return $this;
    }

    /**
     * Get coIdTable
     *
     * @return integer
     */
    public function getCoIdTable()
    {
        return $this->coIdTable;
    }

    /**
     * Set dtSync
     *
     * @param \DateTime $dtSync
     *
     * @return TbSync
     */
    public function setDtSync($dtSync)
    {
        $this->dtSync = $dtSync;
    
        return $this;
    }

    /**
     * Get dtSync
     *
     * @return \DateTime
     */
    public function getDtSync()
    {
        return $this->dtSync;
    }

    /**
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbSync
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

    /**
     * Set idAuthor
     *
     * @param \AppBundle\Entity\TbUser $idAuthor
     *
     * @return TbSync
     */
    public function setIdAuthor(\AppBundle\Entity\TbUser $idAuthor = null)
    {
        $this->idAuthor = $idAuthor;
    
        return $this;
    }

    /**
     * Get idAuthor
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdAuthor()
    {
        return $this->idAuthor;
    }

    /**
     * Set idDestination
     *
     * @param \AppBundle\Entity\TbUser $idDestination
     *
     * @return TbSync
     */
    public function setIdDestination(\AppBundle\Entity\TbUser $idDestination = null)
    {
        $this->idDestination = $idDestination;
    
        return $this;
    }

    /**
     * Get idDestination
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdDestination()
    {
        return $this->idDestination;
    }
}
