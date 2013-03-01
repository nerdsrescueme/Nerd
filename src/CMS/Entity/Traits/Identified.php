<?php

namespace CMS\Entity\Traits;

trait Identified
{
    // Property MUST be set in parent class

	/**
	 * Get entity ID
	 * 
	 * @return integer Entity ID
	 */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entity ID
     * 
     * @throws LogicException when id reset is attempted
     * @throws InvalidArgumentException if non-integer id set is attempt
     * @param integer $id ID
     * @return void
     */
    public function setId($id)
    {
        if ($this->id !== null) {
            throw new \LogicException('Id cannot be reset');
        }

        if (!is_int($id)) {
            throw new \InvalidArgumentException('Id must be an integer');
        }

        $this->id = $id;
    }
}