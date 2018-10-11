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
    private $postDetailsJson;
    private $postDetails;
    private $hashtags;

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
        if (!$this->isPrivate() and $this->isBusiness()) {
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
        if (!$this->isPrivate()) {
            $posts = array();
            $postsDataArray = $this->getCrawledData()->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
            //Das iterieren durch die 12 gefunden Posts um mehr Details zu erhalten
            foreach ($postsDataArray as $postData) {
                //Anhand diesen Shortcode, kommt man auf die direkte Seite des Posts.
                $imageShortcode = $postData->node->shortcode;
                //Daten abrufen und das JSON erneut auswerten.
                $postCrawler = (new Goutte)->request('GET', 'https://www.instagram.com/p/' . $imageShortcode . '/');
                $postCrawler->filter('body > script:first-of-type')->each(function (Crawler $node) {
                    $postDetailsJson = $node->text();
                    //Remove "window._sharedData =" in front of the JSON String
                    $postDetailsJson = substr($postDetailsJson, 21);
                    //Remove the ; at the end, otherwise it is no correct JSON
                    $postDetailsJson = substr($postDetailsJson, 0, -1);
                    $postDetailsJson = json_decode($postDetailsJson);
                    $this->setPostDetailsJson($postDetailsJson->entry_data->PostPage[0]->graphql->shortcode_media);

                    $postDetails = array();
                    //Wenn es eine Diashow mit mehren Bildern ist. Dann werden die Daten aus dem Array
                    //edge_sidecar_to_children ausgelesen. Ansonsten direkt aus der Node
                    if (isset($this->getPostDetailsJson()->edge_sidecar_to_children)) {
                        foreach ($this->getPostDetailsJson()->edge_sidecar_to_children->edges as $edge) {
                            $postDetail = new PostDetails(
                                filter_var(
                                    $edge->node->is_video,
                                    FILTER_VALIDATE_BOOLEAN
                                ),
                                $edge->node->display_url,
                                $edge->node->shortcode
                            );
                            if ($postDetail->isVideo()) {
                                $postDetail->setVideoUrl($edge->node->video_url);
                                $postDetail->setVideoDuration($edge->node->video_duration);
                                $postDetail->setVideoViewCount($edge->node->video_view_count);
                            }
                            array_push($postDetails, $postDetail);
                        }
                    } else {
                        $postDetail = new PostDetails(
                            filter_var(
                                $this->getPostDetailsJson()->is_video,
                                FILTER_VALIDATE_BOOLEAN
                            ),
                            $this->getPostDetailsJson()->display_url,
                            $this->getPostDetailsJson()->shortcode
                        );
                        if ($postDetail->isVideo()) {
                            $postDetail->setVideoUrl($this->getPostDetailsJson()->video_url);
                            $postDetail->setVideoDuration($this->getPostDetailsJson()->video_duration);
                            $postDetail->setVideoViewCount($this->getPostDetailsJson()->video_view_count);
                        }
                        array_push($postDetails, $postDetail);
                    }
                    $this->setPostDetails($postDetails);
                });
                $location = '';
                if (isset($this->getPostDetailsJson()->location)) {
                    $location = $this->getPostDetailsJson()->location->name;
                }
                $post = new Post(
                    $postData->node->edge_media_to_caption->edges[0]->node->text,
                    $postData->node->edge_media_to_comment->count,
                    $postData->node->comments_disabled,
                    $postData->node->edge_liked_by->count,
                    $postData->node->taken_at_timestamp,
                    $this->getPostDetails(),
                    $this->getPostDetailsJson()->is_ad,
                    $this->getPostDetailsJson()->has_ranked_comments,
                    $this->getPostDetailsJson()->caption_is_edited,
                    $location
                );
                array_push($posts, $post);
            }
            $this->setPosts($posts);
        }
    }

    function filterHashtags(){
        $this->hashtags = array();
        $list = array();
        if (!$this->isPrivate()) {
            foreach ($this->getPosts() as $post){
                preg_match_all('/(#[\pL_0-9]+)/', $post->getCaption(), $hashtaglist);
                foreach ($hashtaglist[0] as $hashtag){
                    $tag = strtolower($hashtag);
                    if(in_array($tag, $list)){
                        foreach ($this->getHashtags() as $object){
                           if(strcmp($object->getName() , $tag) == 0) {
                                $object->setCount(($object->getCount()+1));
                           }
                        }
                    } else{
                        array_push($list,$tag);
                        $object = new Hashtag($tag,1);
                        array_push($this->hashtags,$object);
                    }
                }
            }
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
    public function isPrivate()
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
    public function isBusiness()
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

    /**
     * @return mixed
     */
    public function getPostDetailsJson()
    {
        return $this->postDetailsJson;
    }

    /**
     * @param mixed $postDetailsJson
     */
    public function setPostDetailsJson($postDetailsJson): void
    {
        $this->postDetailsJson = $postDetailsJson;
    }

    /**
     * @param mixed $postDetails
     */
    public function setPostDetails($postDetails): void
    {
        $this->postDetails = $postDetails;
    }

    /**
     * @return mixed
     */
    public function getPostDetails()
    {
        return $this->postDetails;
    }

    /**
     * @return mixed
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param mixed $hashtags
     */
    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

}
