<?php

namespace CMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(type="integer", name="type")
 * @ORM\DiscriminatorMap({1="Post", 2="Product", 3="Page"})
 */
abstract class BaseAbstract
{
}