<?php
/**
 * Created by PhpStorm.
 * User: Miky
 * Date: 29.09.2020
 * Time: 17:04
 */

namespace App\Core\Service;


use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractEntityManager
{

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}