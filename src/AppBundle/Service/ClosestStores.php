<?php

namespace AppBundle\Service;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\Marker;

class ClosestStores
{

    public function getMostClosest(array $products = null)
    {
        return 0;
    }
    /**
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @param $unit
     *
     * @return float
     */
    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === "K") {
            return ($miles * 1.609344);
        } else if ($unit === "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function sortByKilometers(){

    }
}
