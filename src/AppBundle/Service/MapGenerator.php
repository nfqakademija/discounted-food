<?php
namespace AppBundle\Service;
use Ivory\GoogleMap\Map;

class MapGenerator
{
    private $map;

    public function __construct(Map $map)
    {
        $this->map = $map;
    }


}