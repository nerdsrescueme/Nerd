<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product comment entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="nerd_comments")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class ProductComment
{
    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     * @Assert\Choice(callback="getTypes")
     * @Assert\NotBlank
     */
    protected $type = self::TYPE_PRODUCT;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="comments")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * Return associated product entity
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set associated product entity
     *
     * @param Product $product Product entity
     * @return void
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}