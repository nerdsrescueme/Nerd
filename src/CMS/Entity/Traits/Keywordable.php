<?php

namespace CMS\Entity\Traits;

/**
 * Keywordable entity extension
 * 
 * Adds shared keyword functionality to an entity
 * 
 * @package NerdCMS
 * @category Entity\Extensions
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
trait Keywordable
{
    /**
     * Return associated keyword collection
     * 
     * @return ArrayCollection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Return array of associated keyword ids
     * 
     * @return array[integer]
     */
    public function getKeywordIds()
    {
        $ids = [];
        foreach ($this->getKeywords() as $keyword) {
            $ids[] = $keyword->getId();
        }

        return $ids;
    }

    /**
     * Return array of associated keyword strings
     * 
     * @return array[string]
     */
    public function getKeywordsArray()
    {
        $keywords = [];
        foreach ($this->getKeywords() as $keyword) {
            $keywords[] = $keyword->getKeyword();
        }

        return $keywords;
    }

    /**
     * Test if keyword exists in object collection
     * 
     * Tests a few different scenarios based on the PHP type of the $keyword
     * argument. Strings compare to array of keywords, integer to array of
     * keyword ids and object to keyword collection object.
     * 
     * @param mixed $keyword Keyword comparator
     * @return boolean
     */
    public function hasKeyword($keyword)
    {
        switch(gettype($keyword)) {
            case 'string':
                return in_array($keyword, $this->getKeywordsArray());
                break;
            case 'integer':
                return in_array($keyword, $this->getKeywordIds());
                break;
            case 'object':
                return $this->keywords->has($keyword);
                break;
            default:
                return false;
        }
    }

    /**
     * Attach a keyword to the keyword collection
     * 
     * @param Keyword $keyword Keyword object
     * @return void
     */
    public function addKeyword(Keyword $keyword)
    {
        $this->keywords[] = $keyword;
    }

    /**
     * Attach multiple keywords to the keyword collection
     * 
     * @param array[Keyword] $keywords Array of keyword objects
     * @return void
     */
    public function addKeywords(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->addKeyword($keyword);
        }
    }
}