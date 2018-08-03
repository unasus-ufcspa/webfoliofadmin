<?php

namespace AppBundle\Entity;

/**
 * TbActivity
 */
class TbActivity
{
    /**
     * @var integer
     */
    private $idActivity;

    /**
     * @var integer
     */
    private $nuOrder;

    /**
     * @var string
     */
    private $dsTitle;

    /**
     * @var string
     */
    private $dsDescription;

    /**
     * @var \AppBundle\Entity\TbPortfolio
     */
    private $idPortfolio;


    /**
     * Get idActivity
     *
     * @return integer
     */
    public function getIdActivity()
    {
        return $this->idActivity;
    }

    /**
     * Set nuOrder
     *
     * @param integer $nuOrder
     *
     * @return TbActivity
     */
    public function setNuOrder($nuOrder)
    {
        $this->nuOrder = $nuOrder;

        return $this;
    }

    /**
     * Get nuOrder
     *
     * @return integer
     */
    public function getNuOrder()
    {
        return $this->nuOrder;
    }

    /**
     * Set dsTitle
     *
     * @param string $dsTitle
     *
     * @return TbActivity
     */
    public function setDsTitle($dsTitle)
    {
        $this->dsTitle = $dsTitle;

        return $this;
    }

    /**
     * Get dsTitle
     *
     * @return string
     */
    public function getDsTitle()
    {
        return $this->dsTitle;
    }

    /**
     * Set dsDescription
     *
     * @param string $dsDescription
     *
     * @return TbActivity
     */
    public function setDsDescription($dsDescription)
    {
        $this->dsDescription = $dsDescription;

        return $this;
    }

    /**
     * Get dsDescription
     *
     * @return string
     */
    public function getDsDescription()
    {
        return $this->dsDescription;
    }

    /**
     * Set idPortfolio
     *
     * @param \AppBundle\Entity\TbPortfolio $idPortfolio
     *
     * @return TbActivity
     */
    public function setIdPortfolio(\AppBundle\Entity\TbPortfolio $idPortfolio = null)
    {
        $this->idPortfolio = $idPortfolio;

        return $this;
    }

    /**
     * Get idPortfolio
     *
     * @return \AppBundle\Entity\TbPortfolio
     */
    public function getIdPortfolio()
    {
        return $this->idPortfolio;
    }
}
