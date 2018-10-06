<?php
/**
 * User: Marcel Pochert
 * Date: 06/10/2018
 * Time: 21:58
 */

namespace App\Scraping;


class Address
{
    private $street;
    private $zipCode;
    private $city;
    private $region;
    private $country_code;

    /**
     * Address constructor.
     * @param $street
     * @param $zipCode
     * @param $city
     * @param $region
     * @param $country_code
     */
    public function __construct($street, $zipCode, $city, $region, $country_code)
    {
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->region = $region;
        $this->country_code = $country_code;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }
}
