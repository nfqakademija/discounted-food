<?php

namespace AppBundle\Service;

use AppBundle\Entity\Address;
use AppBundle\Entity\Product;

class ClosestStores
{

    /**
     * @param array      $addresses
     * @param array|null $products
     * @param            $currentLat
     * @param            $currentLong
     */
    public function getMostClosest(array $addresses, array $products = null, $currentLat, $currentLong)
    {
        $storesCounter = 0;
        $productsCounter = 0;
        $closestAddress = new Address();
        $closestProducts = new Product();
        $stores = [];

        foreach ($addresses as $address) {
            $lat = $address->getLatitude();
            $long = $address->getLongitude();
            if ($products !== null) {

                $stores[$storesCounter]['companyName'] = $address->getShopOwner()->getCompanyName();
                $closestAddress->setAddress($address->getAddress());
                $stores[$storesCounter]['distance'] = $this->distance($lat, $long, $currentLat, $currentLong, 'K');

                foreach ($products as $product) {
                    if ($product->getAddressId() === $address->getId()) {
                        $closestProducts->setName($product->getName());
                        $closestProducts->setDescription($product->getDescription());
                        $closestProducts->setPrice($product->getPrice());
                        $closestProducts->setPortions($product->getPortions());
                        $stores[$storesCounter]['products'][$productsCounter] = $closestProducts;
                        $productsCounter++;
                    }
                }
                $storesCounter++;
            }
        }

        return $this->sortByKilometers($stores);
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

    public function sortByKilometers($stores)
    {
        echo "<pre>";
        var_dump($stores);
        echo "</pre>";
        die;
    }
}
