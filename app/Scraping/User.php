<?php
/**
 * User: Marcel Pochert
 * Date: 06/10/2018
 * Time: 21:51
 */

namespace App\Scraping;


class User
{
    private $biography;
    private $externalUrl;
    private $countFollower;
    private $countFollowing;
    private $fullName;
    private $countHighlight;
    private $isBusinessAccount;
    private $businessCategory;
    private $businessEmail;
    private $businessPhoneNumber;
    private $businessAddress;
    private $isPrivate;
    private $isVerified;
    private $username;
    private $connectedFacebookPage;

    /**
     * User constructor.
     * @param $biography
     * @param $externalUrl
     * @param $countFollower
     * @param $countFollowing
     * @param $fullName
     * @param $countHighlight
     * @param $isBusinessAccount
     * @param $businessCategory
     * @param $businessEmail
     * @param $businessPhoneNumber
     * @param $businessAddress
     * @param $isPrivate
     * @param $isVerified
     * @param $username
     * @param $connectedFacebookPage
     */
    public function __construct($biography, $externalUrl, $countFollower, $countFollowing, $fullName, $countHighlight, $isBusinessAccount, $businessCategory, $businessEmail, $businessPhoneNumber, $businessAddress, $isPrivate, $isVerified, $username, $connectedFacebookPage)
    {
        $this->biography = $biography;
        $this->externalUrl = $externalUrl;
        $this->countFollower = $countFollower;
        $this->countFollowing = $countFollowing;
        $this->fullName = $fullName;
        $this->countHighlight = $countHighlight;
        $this->isBusinessAccount = $isBusinessAccount;
        $this->businessCategory = $businessCategory;
        $this->businessEmail = $businessEmail;
        $this->businessPhoneNumber = $businessPhoneNumber;
        $this->businessAddress = $businessAddress;
        $this->isPrivate = $isPrivate;
        $this->isVerified = $isVerified;
        $this->username = $username;
        $this->connectedFacebookPage = $connectedFacebookPage;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @return mixed
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * @return mixed
     */
    public function getCountFollower()
    {
        return $this->countFollower;
    }

    /**
     * @return mixed
     */
    public function getCountFollowing()
    {
        return $this->countFollowing;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return mixed
     */
    public function getCountHighlight()
    {
        return $this->countHighlight;
    }

    /**
     * @return mixed
     */
    public function getisBusinessAccount()
    {
        return $this->isBusinessAccount;
    }

    /**
     * @return mixed
     */
    public function getBusinessCategory()
    {
        return $this->businessCategory;
    }

    /**
     * @return mixed
     */
    public function getBusinessEmail()
    {
        return $this->businessEmail;
    }

    /**
     * @return mixed
     */
    public function getBusinessPhoneNumber()
    {
        return $this->businessPhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getBusinessAddress()
    {
        return $this->businessAddress;
    }

    /**
     * @return mixed
     */
    public function getisPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * @return mixed
     */
    public function getisVerified()
    {
        return $this->isVerified;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getConnectedFacebookPage()
    {
        return $this->connectedFacebookPage;
    }
}
