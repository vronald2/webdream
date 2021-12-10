<?php

namespace App\Services;

use App\Model\Stock;

class WarehouseService
{

    private $warehouses;


    public function __construct($warehouses)
    {
        $this->warehouses = $warehouses;
    }

    public function storeItems(Stock $stock)
    {

        $stored = false;

        foreach ($this->warehouses as $warehouse) {
            if ($warehouse->getEmptySpace() >= $stock->getQuantity() && !$stored) {
                $warehouse->addStock([$stock]);
                $stored = true;
            }
        }

        if ($stored) {
            return true;
        }

        throw new \Exception(sprintf('Cannot store %s items in any warehouse!', $stock->getQuantity()));

    }


    public function removeItems(Stock $stock)
    {

        $served = false;

        foreach ($this->warehouses as $warehouse) {

            $quantityInWarehouse = $warehouse->getQuantityForProduct($stock);

            if (!$quantityInWarehouse || $served == true) {
                continue;
            }

            if ($quantityInWarehouse >= $stock->getQuantity()) {
                $warehouse->removeStock($stock);
                $served = true;
            }

            if ($quantityInWarehouse < $stock->getQuantity()) {

                $tmp_stock = new Stock($stock->getProduct(), $quantityInWarehouse);

                $stock->setQuantity($stock->getQuantity() - $quantityInWarehouse);

                $warehouse->removeStock($tmp_stock);
                $served = false;
            }

        }

        if ($served) {
            return true;
        }


        throw new \Exception(sprintf('Cannot serve % items from all warehouse!', $stock->getQuantity()));

    }

    /**
     * @return mixed
     */
    public function getWarehouses()
    {
        return $this->warehouses;
    }

    /**
     * @param mixed $warehouses
     */
    public function setWarehouses($warehouses)
    {
        $this->warehouses = $warehouses;
    }
}
