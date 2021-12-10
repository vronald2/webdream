<?php

namespace App\Model;

class Product
{
    private $articleNumber;
    private $name;
    private $price;
    private $brand;

    public function __construct($articleNumber, $name, $price, $brand)
    {

        $this->articleNumber = $articleNumber;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;

    }


    /**
     * @return mixed
     */
    public function getArticleNumber()
    {
        return $this->articleNumber;
    }

    /**
     * @param mixed $articleNumber
     */
    public function setArticleNumber($articleNumber)
    {
        $this->articleNumber = $articleNumber;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

}