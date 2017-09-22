<?php

namespace AppBundle\Entity;

/**
 * TbPolicy
 */
class TbPolicy
{
    /**
     * @var integer
     */
    private $idPolicy;

    /**
     * @var string
     */
    private $txPolicy;


    /**
     * Get idPolicy
     *
     * @return integer
     */
    public function getIdPolicy()
    {
        return $this->idPolicy;
    }

    /**
     * Set txPolicy
     *
     * @param string $txPolicy
     *
     * @return TbPolicy
     */
    public function setTxPolicy($txPolicy)
    {
        $this->txPolicy = $txPolicy;
    
        return $this;
    }

    /**
     * Get txPolicy
     *
     * @return string
     */
    public function getTxPolicy()
    {
        return $this->txPolicy;
    }
}
