<?php
namespace AppBundle\Service;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\Marker;

class MapGenerator
{

    public function generateMap(array $addresses) : Map
    {
        $map = new Map();
        $map->setStylesheetOption('height', '400px');
        $map->setStylesheetOption('width', '100%');
        $map->setMapOption('zoom', 12);
        $map->setCenter(new Coordinate(54.687157, 25.279652));


        foreach($addresses as $address) {
            $marker = new Marker(new Coordinate($address->getLatitude(), $address->getLongitude()));
            $map->getOverlayManager()->addMarker($marker);
            $infowindow = new InfoWindow($address->getAddress());
            $marker->setInfoWindow($infowindow);
        }
        return $map;
    }


}   