<?php

namespace AppBundle\Entity;

/**
 * TbPortfolio
 */
class TbPortfolio
{
    /**
     * @var integer
     */
    private $idPortfolio;

    /**
     * @var string
     */
    private $dsTitle;

    /**
     * @var string
     */
    private $dsDescription;

    /**
     * @var string
     */
    private $nuPortfolioVersion;


    /**
     * Get idPortfolio
     *
     * @return integer
     */
    public function getIdPortfolio()
    {
        return $this->idPortfolio;
    }

    /**
     * Set dsTitle
     *
     * @param string $dsTitle
     *
     * @return TbPortfolio
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
     * @return TbPortfolio
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
     * Set nuPortfolioVersion
     *
     * @param string $nuPortfolioVersion
     *
     * @return TbPortfolio
     */
    public function setNuPortfolioVersion($nuPortfolioVersion)
    {
        $this->nuPortfolioVersion = $nuPortfolioVersion;
    
        return $this;
    }

    /**
     * Get nuPortfolioVersion
     *
     * @return string
     */
    public function getNuPortfolioVersion()
    {
        return $this->nuPortfolioVersion;
    }
}
