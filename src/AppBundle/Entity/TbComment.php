<?php

namespace AppBundle\Entity;

/**
 * TbComment
 */
class TbComment
{
    /**
     * @var integer
     */
    private $idComment;

    /**
     * @var string
     */
    private $txComment;

    /**
     * @var string
     */
    private $tpComment;

    /**
     * @var integer
     */
    private $idCommentSrv;

    /**
     * @var \DateTime
     */
    private $dtComment;

    /**
     * @var \DateTime
     */
    private $dtSend;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idAuthor;

    /**
     * @var \AppBundle\Entity\TbCommentVersion
     */
    private $idCommentVersion;


    /**
     * Get idComment
     *
     * @return integer
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * Set txComment
     *
     * @param string $txComment
     *
     * @return TbComment
     */
    public function setTxComment($txComment)
    {
        $this->txComment = $txComment;
    
        return $this;
    }

    /**
     * Get txComment
     *
     * @return string
     */
    public function getTxComment()
    {
        return $this->txComment;
    }

    /**
     * Set tpComment
     *
     * @param string $tpComment
     *
     * @return TbComment
     */
    public function setTpComment($tpComment)
    {
        $this->tpComment = $tpComment;
    
        return $this;
    }

    /**
     * Get tpComment
     *
     * @return string
     */
    public function getTpComment()
    {
        return $this->tpComment;
    }

    /**
     * Set idCommentSrv
     *
     * @param integer $idCommentSrv
     *
     * @return TbComment
     */
    public function setIdCommentSrv($idCommentSrv)
    {
        $this->idCommentSrv = $idCommentSrv;
    
        return $this;
    }

    /**
     * Get idCommentSrv
     *
     * @return integer
     */
    public function getIdCommentSrv()
    {
        return $this->idCommentSrv;
    }

    /**
     * Set dtComment
     *
     * @param \DateTime $dtComment
     *
     * @return TbComment
     */
    public function setDtComment($dtComment)
    {
        $this->dtComment = $dtComment;
    
        return $this;
    }

    /**
     * Get dtComment
     *
     * @return \DateTime
     */
    public function getDtComment()
    {
        return $this->dtComment;
    }

    /**
     * Set dtSend
     *
     * @param \DateTime $dtSend
     *
     * @return TbComment
     */
    public function setDtSend($dtSend)
    {
        $this->dtSend = $dtSend;
    
        return $this;
    }

    /**
     * Get dtSend
     *
     * @return \DateTime
     */
    public function getDtSend()
    {
        return $this->dtSend;
    }

    /**
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbComment
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
     * @return TbComment
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
     * Set idCommentVersion
     *
     * @param \AppBundle\Entity\TbCommentVersion $idCommentVersion
     *
     * @return TbComment
     */
    public function setIdCommentVersion(\AppBundle\Entity\TbCommentVersion $idCommentVersion = null)
    {
        $this->idCommentVersion = $idCommentVersion;
    
        return $this;
    }

    /**
     * Get idCommentVersion
     *
     * @return \AppBundle\Entity\TbCommentVersion
     */
    public function getIdCommentVersion()
    {
        return $this->idCommentVersion;
    }
}

