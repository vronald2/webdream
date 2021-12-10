<?php

namespace App\Controllers;

use App\Model\Brand;
use App\Model\Product;
use App\Model\Stock;
use App\Model\Warehouse;
use App\Services\WarehouseService;

class DefaultController
{

    public function index()
    {

        try {
            $brand1 = new Brand('Ikea', 3);
        } catch (\Exception $exception) {
            $this->formatException($exception);
            die;
        }

        try {
            $brand2 = new Brand('Kik', 2);
        } catch (\Exception $exception) {
            $this->formatException($exception);
            die;
        }

        $product1 = new Product('50444306', 'LERHAMN', '22990', $brand1);
        $product2 = new Product('23221234', 'SOLLHETTA', '500', $brand2);

        $warehouses = [
            new Warehouse('Raktár 1', 'Teszt utca 1', 100,
                [
                    new Stock($product1, 15),
                    new Stock($product2, 20),
                    new Stock($product2, 30)
                ]
            ),
            new Warehouse('Raktár 2', 'Teszt utca 2', 200,
                [
                    new Stock($product1, 30),
                    new Stock($product2, 20)
                ]),
            new Warehouse('Raktár 3', 'Teszt utca 3', 300,
                [
                    new Stock($product1, 40),
                    new Stock($product2, 90)
                ])
        ];

        $warehouseService = new WarehouseService($warehouses);

        echo "<b>Raktárak tartalma</b>";

        $this->formatWarehouseOutput($warehouses);

        echo "<b>Raktárak tartalma miután hozzáadunk termékeket </b>";

        try {
            $warehouseService->storeItems(new Stock($product2, 30));
        } catch (\Exception $exception) {
            $this->formatException($exception);
        }

        try {
            $warehouseService->storeItems(new Stock($product2, 500));
        } catch (\Exception $exception) {
            $this->formatException($exception);
        }

        try {
            $warehouseService->storeItems(new Stock($product2, 10));
        } catch (\Exception $exception) {
            $this->formatException($exception);
        }


        $this->formatWarehouseOutput($warehouses);

        echo "<b>Raktárak tartalma miután kikérünk termékeket </b>";

        try {

            $warehouseService->removeItems(new Stock($product2, 100));

        } catch (\Exception $exception) {

            $this->formatException($exception);

        }

        try {
            $warehouseService->removeItems(new Stock($product2, 20));
        } catch (\Exception $exception) {

            $this->formatException($exception);

        }

        $this->formatWarehouseOutput($warehouses);

    }

    private function formatException(\Exception $exception)
    {
        echo "<br/><span style='color:red'>";
        echo $exception->getMessage();
        echo "</span>";
    }

    private function formatWarehouseOutput($warehouses)
    {
        foreach ($warehouses as $warehouse) {
            echo "<table>";
            echo sprintf("<tr><td>%s</td><td>Kapacitás: %s / %s</td></tr>", $warehouse->getName(), $warehouse->getEmptySpace(), $warehouse->getCapacity());
            foreach ($warehouse->getStock() as $stock) {

                echo sprintf("<tr><td>%s</td><td>%s</td></tr>", $stock->getProduct()->getName(), $stock->getQuantity());
            }
            echo "</table><br/>";

        }
    }
}