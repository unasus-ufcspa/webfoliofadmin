<?php

namespace AppBundle\Entity;

/**
 * TbUser
 */
class TbUser
{
    /**
     * @var integer
     */
    private $idUser;

    /**
     * @var string
     */
    private $nmUser;

    /**
     * @var string
     */
    private $nuIdentification;

    /**
     * @var string
     */
    private $dsEmail;

    /**
     * @var string
     */
    private $dsPassword;

    /**
     * @var string
     */
    private $nuCellphone;

    /**
     * @var string
     */
    private $imPhoto;

    /**
     * @var string
     */
    private $flAdmin;

    /**
     * @var string
     */
    private $flProposer;


    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set nmUser
     *
     * @param string $nmUser
     *
     * @return TbUser
     */
    public function setNmUser($nmUser)
    {
        $this->nmUser = $nmUser;
    
        return $this;
    }

    /**
     * Get nmUser
     *
     * @return string
     */
    public function getNmUser()
    {
        return $this->nmUser;
    }

    /**
     * Set nuIdentification
     *
     * @param string $nuIdentification
     *
     * @return TbUser
     */
    public function setNuIdentification($nuIdentification)
    {
        $this->nuIdentification = $nuIdentification;
    
        return $this;
    }

    /**
     * Get nuIdentification
     *
     * @return string
     */
    public function getNuIdentification()
    {
        return $this->nuIdentification;
    }

    /**
     * Set dsEmail
     *
     * @param string $dsEmail
     *
     * @return TbUser
     */
    public function setDsEmail($dsEmail)
    {
        $this->dsEmail = $dsEmail;
    
        return $this;
    }

    /**
     * Get dsEmail
     *
     * @return string
     */
    public function getDsEmail()
    {
        return $this->dsEmail;
    }

    /**
     * Set dsPassword
     *
     * @param string $dsPassword
     *
     * @return TbUser
     */
    public function setDsPassword($dsPassword)
    {
        $this->dsPassword = $dsPassword;
    
        return $this;
    }

    /**
     * Get dsPassword
     *
     * @return string
     */
    public function getDsPassword()
    {
        return $this->dsPassword;
    }

    /**
     * Set nuCellphone
     *
     * @param string $nuCellphone
     *
     * @return TbUser
     */
    public function setNuCellphone($nuCellphone)
    {
        $this->nuCellphone = $nuCellphone;
    
        return $this;
    }

    /**
     * Get nuCellphone
     *
     * @return string
     */
    public function getNuCellphone()
    {
        return $this->nuCellphone;
    }

    /**
     * Set imPhoto
     *
     * @param string $imPhoto
     *
     * @return TbUser
     */
    public function setImPhoto($imPhoto)
    {
        $this->imPhoto = $imPhoto;
    
        return $this;
    }

    /**
     * Get imPhoto
     *
     * @return string
     */
    public function getImPhoto()
    {
        return $this->imPhoto;
    }

    /**
     * Set flAdmin
     *
     * @param string $flAdmin
     *
     * @return TbUser
     */
    public function setFlAdmin($flAdmin)
    {
        $this->flAdmin = $flAdmin;
    
        return $this;
    }

    /**
     * Get flAdmin
     *
     * @return string
     */
    public function getFlAdmin()
    {
        return $this->flAdmin;
    }

    /**
     * Set flProposer
     *
     * @param string $flProposer
     *
     * @return TbUser
     */
    public function setFlProposer($flProposer)
    {
        $this->flProposer = $flProposer;
    
        return $this;
    }

    /**
     * Get flProposer
     *
     * @return string
     */
    public function getFlProposer()
    {
        return $this->flProposer;
    }
}

