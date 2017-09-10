<?php
namespace Framework\Router;

/**
* Class Route
*/
class Route
{
    /**
    * @var string
    */
    private $name;

    /**
    * @var callable
    */
    private $callable;

    /**
    * @var array
    */
    private $params;

    public function __construct(string $name, callable $callable, array $params)
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->params = $params;
    }

    /**
    * @return string[]
    */
    public function getName(): string
    {
        return $this->name;
    }

    /**
    * @return callable
    */
    public function getCallback(): callable
    {
        return $this->callable;
    }

    /**
    * Retrieve the URL params
    * @return string[]
    */
    public function getParams(): array
    {
        return $this->params;
    }
}
