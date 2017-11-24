<?php

namespace AppBundle\Service;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;

class MapGenerator
{

    public function generateMap(array $addresses, array $products = null): Map
    {
        $map = new Map();
        $map->setStylesheetOption('height', '620px');
        $map->setStylesheetOption('width', '100%');
        $map->setMapOption('zoom', 12);
        $map->setCenter(new Coordinate(54.687157, 25.279652));
        $temp = '';
        $i = 0;
        foreach ($addresses as $address) {
            $marker = new Marker(new Coordinate($address->getLatitude(), $address->getLongitude()));
            $map->getOverlayManager()->addMarker($marker);
            if ($products !== null) {
                foreach ($products as $product) {
                    if ($product->getAddressId() == $address->getId()) {
                        $temp .= "<input type = 'hidden' id = '".$address->getId(
                            )."n-".$i."' value = '".$product->getName(
                            )."'/><input type = 'hidden' id = '".$address->getId(
                            )."d-".$i."' value = '".$product->getDescription(
                            )."'/><input type = 'hidden' id = '".$address->getId(
                            )."pr-".$i."' value = '".$product->getPrice(
                            )."'/><input type = 'hidden' id = '".$address->getId(
                            )."po-".$i."' value = '".$product->getPortions()."'/>";
                        $i++;
                    }
                }
                $temp .= "<input type = 'hidden' id = '".$address->getId()."iterator' value = '".$i."'/>";
                $temp .= "<input type = 'hidden' id = '".$address->getId()."company' value = '".$address->getShopOwner(
                    )->getCompanyName()."'/>";
                $i = 0;
            }
            $infowindow = new InfoWindow(
                $temp."<button class = 'btn btn-success' id = '".$address->getId(
                )."' >View offers</button><br><input type = 'hidden' id = '".$address->getId(
                )."a' value = '".$address->getAddress()."'/><input type = 'hidden' id = '".$address->getId(
                )."i' value = 'http://retaildesignblog.net/wp-content/uploads/2013/01/Max-Mara-flagship-store-Duccio-Grassi-Architects-Hong-Kong.jpg'/>".$address->getAddress(
                )."<img width = '100px' height = '100px' src = '". '../../../web/images/addresses/'.$address->getImageName()."' /></div > "
            );
            $marker->setInfoWindow($infowindow);
//            $marker->setSymbol(new Symbol(SymbolPath::FORWARD_OPEN_ARROW));
//            $marker->setIcon(new Icon('https://pasteboard.co/GUZqrTG.vnd.microsoft.icon'));
            $temp = '';
        }

        return $map;
    }


}   