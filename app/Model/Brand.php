<?php

namespace App\Model;

class Brand
{


    private $name;
    private $quality;

    public function __construct($name, $quality)
    {

        $this->name = $name;
        $this->setQuality($quality);

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
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {

        if ($quality > 5 || $quality < 0) {
            throw new \Exception(sprintf('Invalid quality for brand %s', $this->name));
        }

        $this->quality = $quality;
    }

}