<?php

namespace App\Model;

use Illuminate\Support\Collection;

class Warehouse
{
    private $name;
    private $address;
    private $capacity;
    private $stock;

    public function __construct($name, $address, $capacity, $stock = [])
    {


        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
        $this->stock = new Collection();
        $this->addStock($stock);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return Collection
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    /**
     * @param Collection $stock
     */
    public function setStock(Collection $stock)
    {
        $this->stock = $stock;
    }


    public function addStock($stocks)
    {

        foreach ($stocks as $stock) {

            if ($this->getEmptySpace() >= $stock->getQuantity()) {

                $stockItem = $this->stock->filter(function ($item) use ($stock) {
                    return $item->getProduct()->getArticleNumber() == $stock->getProduct()->getArticleNumber();
                })->first();

                if ($stockItem) {
                    $stockItem->addQuantity($stock->getQuantity());
                } else {
                    $this->stock->push($stock);
                }


            } else {
                throw new \Exception('Out of space');
            }

        }

    }

    public function getQuantityForProduct($stock)
    {

        $currentStock = $this->stock->filter(function ($item) use ($stock) {
            return $item->getProduct()->getArticleNumber() == $stock->getProduct()->getArticleNumber();
        })->first();

        return $currentStock ? $currentStock->getQuantity() : 0;

    }


    public function removeStock($stock)
    {

        $currentStock = $this->stock->filter(function ($item) use ($stock) {
            return $item->getProduct()->getArticleNumber() == $stock->getProduct()->getArticleNumber() && $item->getQuantity() >= $stock->getQuantity();
        })->first();

        if ($currentStock) {
            $currentStock->removeQuantity($stock->getQuantity());
        } else {
            throw new \Exception('There is no enough product in this warehouse');
        }

    }

    public function getEmptySpace(): int
    {

        $usedSpace = 0;

        foreach ($this->stock as $stock) {

            $usedSpace += $stock->getQuantity();

        }

        return $this->capacity - $usedSpace;

    }

}