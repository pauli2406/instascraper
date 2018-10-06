<?php
/**
 * User: Marcel Pochert
 * Date: 06/10/2018
 * Time: 22:50
 */

namespace App\Scraping;

use Goutte\Client as Goutte;
use Symfony\Component\DomCrawler\Crawler;

class InstaCrawler
{
    private $crawledData;
    private $businessAddress;
    private $user;
    private $posts;
    private $isPrivate;
    private $isBusiness;

    /**
     * Crawler constructor.
     */
    public function __construct($username)
    {
        $this->crawlData($username);
    }

    private function crawlData($username)
    {
        $crawler = (new Goutte)->request('GET', 'https://www.instagram.com/' . $username . '/');
        $crawler->filter('body > script:first-of-type')->each(function (Crawler $node) {
            $jsonData = $node->text();
            //Remove "window._sharedData =" in front of the JSON String
            $jsonData = substr($jsonData, 21);
            //Remove the ; at the end, otherwise it is no correct JSON
            $jsonData = substr($jsonData, 0, -1);
            //Return decoded data as JSON Array
            $this->setCrawledData(json_decode($jsonData));

            $this->setIsPrivate(filter_var(
                $this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user->is_private,
                FILTER_VALIDATE_BOOLEAN
            ));
            $this->setIsBusiness(filter_var(
                $this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user->is_business_account,
                FILTER_VALIDATE_BOOLEAN
            ));
        });
    }

    function filterBusinessAddress()
    {
        if (!$this->getisPrivate() and $this->getisBusiness()) {
            $businessAddressData = json_decode($this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user->business_address_json);
            $businessAddress = new Address(
                $businessAddressData->street_address,
                $businessAddressData->zip_code,
                $businessAddressData->city_name,
                $businessAddressData->region_name,
                $businessAddressData->country_code
            );
            $this->setBusinessAddress($businessAddress);
        }
    }

    function filterUserData()
    {
        $userData = $this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user;
        $user = new User(
            $userData->biography,
            $userData->external_url,
            $userData->edge_followed_by->count,
            $userData->edge_follow->count,
            $userData->full_name,
            $userData->highlight_reel_count,
            $userData->is_business_account,
            $userData->business_category_name,
            $userData->business_email,
            $userData->business_phone_number,
            $this->getBusinessAddress(),
            $userData->is_private,
            $userData->is_verified,
            $userData->username,
            $userData->connected_fb_page
        );
        $this->setUser($user);
    }

    function filterPosts()
    {
        if (!$this->getisPrivate()) {
            $postDataArray = $this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
            $posts = array();
            foreach ($postDataArray as $data) {
                $post = new Post(
                    $data->node->edge_media_to_caption->edges[0]->node->text,
                    $data->node->edge_media_to_comment->count,
                    $data->node->comments_disabled,
                    $data->node->edge_liked_by->count,
                    $data->node->taken_at_timestamp,
                    $data->node->is_video,
                    $data->node->display_url
                );
                array_push($posts, $post);
            }
            $this->setPosts($posts);
        }
    }

    /**
     * @return mixed
     */
    public function getCrawledData()
    {
        return $this->crawledData;
    }

    /**
     * @param mixed $crawledData
     */
    public function setCrawledData($crawledData): void
    {
        $this->crawledData = $crawledData;
    }

    /**
     * @return mixed
     */
    public function getBusinessAddress()
    {
        return $this->businessAddress;
    }

    /**
     * @param mixed $businessAddress
     */
    public function setBusinessAddress($businessAddress): void
    {
        $this->businessAddress = $businessAddress;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function getisPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * @param mixed $isPrivate
     */
    public function setIsPrivate($isPrivate): void
    {
        $this->isPrivate = $isPrivate;
    }

    /**
     * @return mixed
     */
    public function getisBusiness()
    {
        return $this->isBusiness;
    }

    /**
     * @param mixed $isBusiness
     */
    public function setIsBusiness($isBusiness): void
    {
        $this->isBusiness = $isBusiness;
    }

}
