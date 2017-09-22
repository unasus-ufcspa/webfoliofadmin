<?php

namespace AppBundle\Entity;

/**
 * TbAttachment
 */
class TbAttachment
{
    /**
     * @var integer
     */
    private $idAttachment;

    /**
     * @var string
     */
    private $tpAttachment;

    /**
     * @var string
     */
    private $nmFile;

    /**
     * @var string
     */
    private $nmSystem;

    /**
     * @var integer
     */
    private $idAttachmentSrv;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idAuthor;


    /**
     * Get idAttachment
     *
     * @return integer
     */
    public function getIdAttachment()
    {
        return $this->idAttachment;
    }

    /**
     * Set tpAttachment
     *
     * @param string $tpAttachment
     *
     * @return TbAttachment
     */
    public function setTpAttachment($tpAttachment)
    {
        $this->tpAttachment = $tpAttachment;
    
        return $this;
    }

    /**
     * Get tpAttachment
     *
     * @return string
     */
    public function getTpAttachment()
    {
        return $this->tpAttachment;
    }

    /**
     * Set nmFile
     *
     * @param string $nmFile
     *
     * @return TbAttachment
     */
    public function setNmFile($nmFile)
    {
        $this->nmFile = $nmFile;
    
        return $this;
    }

    /**
     * Get nmFile
     *
     * @return string
     */
    public function getNmFile()
    {
        return $this->nmFile;
    }

    /**
     * Set nmSystem
     *
     * @param string $nmSystem
     *
     * @return TbAttachment
     */
    public function setNmSystem($nmSystem)
    {
        $this->nmSystem = $nmSystem;
    
        return $this;
    }

    /**
     * Get nmSystem
     *
     * @return string
     */
    public function getNmSystem()
    {
        return $this->nmSystem;
    }

    /**
     * Set idAttachmentSrv
     *
     * @param integer $idAttachmentSrv
     *
     * @return TbAttachment
     */
    public function setIdAttachmentSrv($idAttachmentSrv)
    {
        $this->idAttachmentSrv = $idAttachmentSrv;
    
        return $this;
    }

    /**
     * Get idAttachmentSrv
     *
     * @return integer
     */
    public function getIdAttachmentSrv()
    {
        return $this->idAttachmentSrv;
    }

    /**
     * Set idAuthor
     *
     * @param \AppBundle\Entity\TbUser $idAuthor
     *
     * @return TbAttachment
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
}
