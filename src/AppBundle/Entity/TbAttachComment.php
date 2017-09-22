<?php

namespace AppBundle\Entity;

/**
 * TbAttachComment
 */
class TbAttachComment
{
    /**
     * @var integer
     */
    private $idAttachComment;

    /**
     * @var \AppBundle\Entity\TbAttachment
     */
    private $idAttachment;

    /**
     * @var \AppBundle\Entity\TbComment
     */
    private $idComment;


    /**
     * Get idAttachComment
     *
     * @return integer
     */
    public function getIdAttachComment()
    {
        return $this->idAttachComment;
    }

    /**
     * Set idAttachment
     *
     * @param \AppBundle\Entity\TbAttachment $idAttachment
     *
     * @return TbAttachComment
     */
    public function setIdAttachment(\AppBundle\Entity\TbAttachment $idAttachment = null)
    {
        $this->idAttachment = $idAttachment;
    
        return $this;
    }

    /**
     * Get idAttachment
     *
     * @return \AppBundle\Entity\TbAttachment
     */
    public function getIdAttachment()
    {
        return $this->idAttachment;
    }

    /**
     * Set idComment
     *
     * @param \AppBundle\Entity\TbComment $idComment
     *
     * @return TbAttachComment
     */
    public function setIdComment(\AppBundle\Entity\TbComment $idComment = null)
    {
        $this->idComment = $idComment;
    
        return $this;
    }

    /**
     * Get idComment
     *
     * @return \AppBundle\Entity\TbComment
     */
    public function getIdComment()
    {
        return $this->idComment;
    }
}
