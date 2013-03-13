<?php

namespace CMS\Entity;

/**
 * @Entity(readOnly=true)
 * @Table(name="nerd_words")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Word
{
    /**
     * @Id
     * @Column(type="string", length=32, nullable=false)
     */
    protected $word;

    public function getWord()
    {
        return $this->word;
    }
}