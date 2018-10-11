<?php
/**
 * Created by PhpStorm.
 * User: Pochert
 * Date: 12.10.2018
 * Time: 00:19
 */

namespace App\Scraping;


class Hashtag
{
    private $name;
    private $count;

    /**
     * Hashtag constructor.
     * @param $name
     */
    public function __construct($name, $count)
    {
        $this->name = $name;
        $this->count = $count;
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->count = $count;
    }

}