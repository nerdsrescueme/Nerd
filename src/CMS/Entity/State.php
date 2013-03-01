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
	private $code;

    /**
     * @OneToMany(targetEntity="City", mappedBy="stateObject")
     */
    private $cities;

    /**
     * @Column(type="string", length=32, nullable=false, unique=true)
     */
    private $name;


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
        $this->code = $code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCities()
    {
        return $this->cities;
    }
}