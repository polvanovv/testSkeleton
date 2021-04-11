<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{

    protected $container;

    /**
     * @return mixed
     */
    public function setContainer()
    {
        $previous        = $this->container;
        $this->container = include __DIR__."/../../config/container.php";

        return $previous;
    }

    protected function get(string $id)
    {
        return $this->container->get($id);
    }

    protected function twig()
    {
        return  $this->container->get('twig');
    }
}