<?php

namespace AppBundle\Entity;

/**
 * TbNotice
 */
class TbNotice
{
    /**
     * @var integer
     */
    private $idNotice;

    /**
     * @var string
     */
    private $nmTable;

    /**
     * @var integer
     */
    private $coIdTable;

    /**
     * @var integer
     */
    private $coIdTableSrv;

    /**
     * @var \DateTime
     */
    private $dtNotice;

    /**
     * @var \DateTime
     */
    private $dtRead;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idAuthor;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idDestination;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;


    /**
     * Get idNotice
     *
     * @return integer
     */
    public function getIdNotice()
    {
        return $this->idNotice;
    }

    /**
     * Set nmTable
     *
     * @param string $nmTable
     *
     * @return TbNotice
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
     * @return TbNotice
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
     * Set coIdTableSrv
     *
     * @param integer $coIdTableSrv
     *
     * @return TbNotice
     */
    public function setCoIdTableSrv($coIdTableSrv)
    {
        $this->coIdTableSrv = $coIdTableSrv;
    
        return $this;
    }

    /**
     * Get coIdTableSrv
     *
     * @return integer
     */
    public function getCoIdTableSrv()
    {
        return $this->coIdTableSrv;
    }

    /**
     * Set dtNotice
     *
     * @param \DateTime $dtNotice
     *
     * @return TbNotice
     */
    public function setDtNotice($dtNotice)
    {
        $this->dtNotice = $dtNotice;
    
        return $this;
    }

    /**
     * Get dtNotice
     *
     * @return \DateTime
     */
    public function getDtNotice()
    {
        return $this->dtNotice;
    }

    /**
     * Set dtRead
     *
     * @param \DateTime $dtRead
     *
     * @return TbNotice
     */
    public function setDtRead($dtRead)
    {
        $this->dtRead = $dtRead;
    
        return $this;
    }

    /**
     * Get dtRead
     *
     * @return \DateTime
     */
    public function getDtRead()
    {
        return $this->dtRead;
    }

    /**
     * Set idAuthor
     *
     * @param \AppBundle\Entity\TbUser $idAuthor
     *
     * @return TbNotice
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
     * @return TbNotice
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

    /**
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbNotice
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

