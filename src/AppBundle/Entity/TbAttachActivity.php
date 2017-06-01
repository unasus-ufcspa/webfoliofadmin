<?php

namespace AppBundle\Entity;

/**
 * TbAttachActivity
 */
class TbAttachActivity
{
    /**
     * @var integer
     */
    private $idAttachActivity;

    /**
     * @var \AppBundle\Entity\TbAttachment
     */
    private $idAttachment;

    /**
     * @var \AppBundle\Entity\TbActivityStudent
     */
    private $idActivityStudent;


    /**
     * Get idAttachActivity
     *
     * @return integer
     */
    public function getIdAttachActivity()
    {
        return $this->idAttachActivity;
    }

    /**
     * Set idAttachment
     *
     * @param \AppBundle\Entity\TbAttachment $idAttachment
     *
     * @return TbAttachActivity
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
     * Set idActivityStudent
     *
     * @param \AppBundle\Entity\TbActivityStudent $idActivityStudent
     *
     * @return TbAttachActivity
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

