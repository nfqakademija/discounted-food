<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;

class ClosestStores
{

    /**
     * @param array      $addresses
     * @param array|null $products
     * @param            $currentLat
     * @param            $currentLong
     * @param            $countOfStores
     *
     * @return array
     */
    public function getMostClosest(array $addresses, array $products = null, $currentLat, $currentLong, $countOfStores)
    {
        $storesCounter = 0;
        $productsCounter = 0;
        $closestProducts = new Product();
        $stores = [];

        foreach ($addresses as $address) {
            $lat = $address->getLatitude();
            $long = $address->getLongitude();
            if ($products !== null) {

                $stores[$storesCounter]['companyName'] = $address->getShopOwner()->getCompanyName();
                $stores[$storesCounter]['address'] = $address->getAddress();
                $stores[$storesCounter]['distance'] = round($this->distance($lat, $long, $currentLat, $currentLong, 'K'),2);

                foreach ($products as $product) {
                    if ($product->getAddressId() === $address->getId()) {
                        $stores[$storesCounter]['products'][$productsCounter]['name'] = $product->getName();
                        $stores[$storesCounter]['products'][$productsCounter]['description'] = $product->getDescription(
                        );
                        $stores[$storesCounter]['products'][$productsCounter]['price'] = $product->getPrice();
                        $stores[$storesCounter]['products'][$productsCounter]['portions'] = $product->getPortions();
                        $productsCounter++;
                    }
                }
                $storesCounter++;
            }
        }

        return $this->sortByKilometers($stores, $storesCounter, $countOfStores);
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
    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(
                deg2rad($theta)
            );
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === "K") {
            return ($miles * 1.609344);
        } else {
            if ($unit === "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function sortByKilometers($stores, $counter, $returnCount): array
    {
        for ($i = 0; $i < $counter; $i++) {
            for ($j = 0; $j < $counter - 1; $j++) {
                if ($stores[$j]['distance'] > $stores[$j + 1]['distance']) {
                    $temp = $stores[$j];
                    $stores[$j] = $stores[$j + 1];
                    $stores[$j + 1] = $temp;
                }
            }
        }

        $stores2 = [];
        for ($i = 0; $i < $returnCount; $i++) {
            $stores2[$counter] = $stores[$i];
            $counter++;
        }

        return $stores2;
    }
}
