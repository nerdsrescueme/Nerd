<?php

namespace CMS\Entity;

/**
 * @Entity(readOnly=true)
 * @Table(name="nerd_states")
 */
class State
{
    /**
	 * @Id
	 * @Column(type="string", length=2, nullable=false)
	 */
	protected $code;

    /**
     * @OneToMany(targetEntity="City", mappedBy="stateObject")
     */
    protected $cities;

    /**
     * @Column(type="string", length=32, nullable=false, unique=true)
     */
    protected $name;


	public function __construct()
	{
		$this->cities = new \Doctrine\Common\Collections\ArrayCollection;
	}

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = trim((string) $code);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = trim((string) $name);
    }

    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Return string equivalent of this object
     * 
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.'['.$this->getCode().']';
    }
}