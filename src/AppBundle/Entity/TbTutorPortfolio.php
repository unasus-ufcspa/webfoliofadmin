<?php

namespace AppBundle\Entity;

/**
 * TbTutorPortfolio
 */
class TbTutorPortfolio
{
    /**
     * @var integer
     */
    private $idTutorPortfolio;

    /**
     * @var \AppBundle\Entity\TbUser
     */
    private $idTutor;

    /**
     * @var \AppBundle\Entity\TbPortfolioStudent
     */
    private $idPortfolioStudent;


    /**
     * Get idTutorPortfolio
     *
     * @return integer
     */
    public function getIdTutorPortfolio()
    {
        return $this->idTutorPortfolio;
    }

    /**
     * Set idTutor
     *
     * @param \AppBundle\Entity\TbUser $idTutor
     *
     * @return TbTutorPortfolio
     */
    public function setIdTutor(\AppBundle\Entity\TbUser $idTutor = null)
    {
        $this->idTutor = $idTutor;

        return $this;
    }

    /**
     * Get idTutor
     *
     * @return \AppBundle\Entity\TbUser
     */
    public function getIdTutor()
    {
        return $this->idTutor;
    }

    /**
     * Set idPortfolioStudent
     *
     * @param \AppBundle\Entity\TbPortfolioStudent $idPortfolioStudent
     *
     * @return TbTutorPortfolio
     */
    public function setIdPortfolioStudent(\AppBundle\Entity\TbPortfolioStudent $idPortfolioStudent = null)
    {
        $this->idPortfolioStudent = $idPortfolioStudent;

        return $this;
    }

    /**
     * Get idPortfolioStudent
     *
     * @return \AppBundle\Entity\TbPortfolioStudent
     */
    public function getIdPortfolioStudent()
    {
        return $this->idPortfolioStudent;
    }
}

