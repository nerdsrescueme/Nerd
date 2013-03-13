<?php

namespace CMS\Entity\Traits;

/**
 * Commentable entity extension
 * 
 * Adds shared comment functionality to an entity
 * 
 * @package NerdCMS
 * @category Entity\Extensions
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
trait Commentable
{
    /**
     * Return associated comment collection
     * 
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Test if comment exists in object collection
     * 
     * @param Comment $comment Comment comparator
     * @return boolean
     */
    public function hasComment($comment)
    {
        return $this->comments->has($comment);
    }

    /**
     * Attach a comment to the comment collection
     * 
     * @param Comment $comment Comment object
     * @return void
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Attach multiple comments to the comment collection
     * 
     * @param array[Comment] $comments Array of comment objects
     * @return void
     */
    public function addComments(array $comments)
    {
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }
    }
}