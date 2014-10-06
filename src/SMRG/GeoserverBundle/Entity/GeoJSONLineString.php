<?php
/**
 * Created by PhpStorm.
 * User: fp
 * Date: 05.10.14
 * Time: 14:03
 */

namespace SMRG\GeoserverBundle\Entity;


class GeoJSONLineString
{

    public $type = "LineString";

    public $coordinates;

    public $rating;

    public $properties;

    public function __construct($coordinates = array())
    {
        $this->coordinates = $coordinates;
    }

    public function addCoordinate($array)
    {
        $this->coordinates[] = $array;
    }

} 