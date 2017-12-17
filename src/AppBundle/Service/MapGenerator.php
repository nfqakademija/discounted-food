<?php

namespace AppBundle\Service;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\Marker;

class MapGenerator
{

    /**
     * @param array      $addresses
     * @param array|null $products
     *
     * @return Map
     */
    public function generateMap(array $addresses, array $products = null): Map
    {
        $map = new Map();
        $map->setStylesheetOption('height', '750px');
        $map->setStylesheetOption('width', '100%');
        $map->setMapOption('zoom', 12);


        $map->setMapOption(
            'styles',
            [
                ['featureType' => 'water', 'stylers' => [['color' => '#e9e9e9']]],
                ['stylers' => [['hue' => 'red', 'saturation' => '-20']]],
            ]
        );
        $map->setCenter(new Coordinate(54.687157, 25.279652));
        $temp = '';
        $i = 0;
        foreach ($addresses as $address) {
            $marker = new Marker(new Coordinate($address->getLatitude(), $address->getLongitude()));
            $marker->setIcon(new Icon('https://i.imgur.com/B8URPHY.png'));
            $map->getOverlayManager()->addMarker($marker);
            if ($products !== null) {
                foreach ($products as $product) {
                    if ($product->getAddressId() === $address->getId()) {
                        $temp .= "<input type = 'hidden' id = '".$address->getId()
                            ."n-".$i."' value = '".$product->getName()
                            ."'/><input type = 'hidden' id = '".$address->getId()
                            ."d-".$i."' value = '".$product->getDescription()
                            ."'/><input type = 'hidden' id = '".$address->getId()
                            ."pr-".$i."' value = '".$product->getPrice()
                            ."'/><input type = 'hidden' id = '".$address->getId()
                            ."po-".$i."' value = '".$product->getPortions()."'/>";
                        $i++;
                    }
                }
                $temp .= "<input type = 'hidden' id = '".$address->getId()."iterator' value = '".$i."'/>";
                $temp .= "<input type = 'hidden' id = '".$address->getId()."company' value = '".$address->getShopOwner()
                        ->getCompanyName()."'/>";
                $i = 0;
            }
            $infowindow = new InfoWindow(
                $temp."<input type = 'hidden' id = '".$address->getId()."a' value = '".$address->getAddress(
                )."'/><input type = 'hidden' id = '".$address->getId(
                )."i' value = 'https://ibb.co/c53Nnm'/>".$address->getAddress(
                )."<br><br><button class = 'btn btn-success btn-block' id = '".$address->getId(
                )."' >View offers</button></div >"
            );
            $marker->setInfoWindow($infowindow);
            $temp = '';
        }

        return $map;
    }
}
