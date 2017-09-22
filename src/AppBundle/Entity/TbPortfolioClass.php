<?php

namespace AppBundle\Entity;

/**
 * TbPortfolioClass
 */
class TbPortfolioClass
{
    /**
     * @var integer
     */
    private $idPortfolioClass;

    /**
     * @var \AppBundle\Entity\TbClass
     */
    private $idClass;

    /**
     * @var \AppBundle\Entity\TbPortfolio
     */
    private $idPortfolio;


    /**
     * Get idPortfolioClass
     *
     * @return integer
     */
    public function getIdPortfolioClass()
    {
        return $this->idPortfolioClass;
    }

    /**
     * Set idClass
     *
     * @param \AppBundle\Entity\TbClass $idClass
     *
     * @return TbPortfolioClass
     */
    public function setIdClass(\AppBundle\Entity\TbClass $idClass = null)
    {
        $this->idClass = $idClass;
    
        return $this;
    }

    /**
     * Get idClass
     *
     * @return \AppBundle\Entity\TbClass
     */
    public function getIdClass()
    {
        return $this->idClass;
    }

    /**
     * Set idPortfolio
     *
     * @param \AppBundle\Entity\TbPortfolio $idPortfolio
     *
     * @return TbPortfolioClass
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
