<?php
/**
 * User: Marcel Pochert
 * Date: 06/10/2018
 * Time: 21:51
 */

namespace App\Scraping;

class Post
{
    private $caption;
    private $amountComments;
    private $isCommentsDisabled;
    private $amountLikes;
    private $uploadDate;
    private $postDetails;
    private $isAd;
    private $has_ranked_comments;
    private $caption_is_edited;
    private $locationName;

    /**
     * Post constructor.
     * @param $caption
     * @param $amountComments
     * @param $isCommentsDisabled
     * @param $amountLikes
     * @param $uploadDate
     * @param $postDetails
     * @param $isAd
     * @param $has_ranked_comments
     * @param $caption_is_edited
     * @param $locationName
     */
    public function __construct($caption, $amountComments, $isCommentsDisabled, $amountLikes, $uploadDate, $postDetails, $isAd, $has_ranked_comments, $caption_is_edited, $locationName)
    {
        $this->caption = $caption;
        $this->amountComments = $amountComments;
        $this->isCommentsDisabled = $isCommentsDisabled;
        $this->amountLikes = $amountLikes;
        $this->uploadDate = $uploadDate;
        $this->postDetails = $postDetails;
        $this->isAd = $isAd;
        $this->has_ranked_comments = $has_ranked_comments;
        $this->caption_is_edited = $caption_is_edited;
        $this->locationName = $locationName;
    }


    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return mixed
     */
    public function getAmountComments()
    {
        return $this->amountComments;
    }

    /**
     * @return mixed
     */
    public function getisCommentsDisabled()
    {
        return $this->isCommentsDisabled;
    }

    /**
     * @return mixed
     */
    public function getAmountLikes()
    {
        return $this->amountLikes;
    }

    /**
     * @return mixed
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * @param mixed $isVideo
     */
    public function setIsVideo($isVideo): void
    {
        $this->isVideo = $isVideo;
    }

    /**
     * @return mixed
     */
    public function getPostDetails()
    {
        return $this->postDetails;
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
    public function getisAd()
    {
        return $this->isAd;
    }

    /**
     * @param mixed $isAd
     */
    public function setIsAd($isAd): void
    {
        $this->isAd = $isAd;
    }

    /**
     * @return mixed
     */
    public function getHasRankedComments()
    {
        return $this->has_ranked_comments;
    }

    /**
     * @param mixed $has_ranked_comments
     */
    public function setHasRankedComments($has_ranked_comments): void
    {
        $this->has_ranked_comments = $has_ranked_comments;
    }

    /**
     * @return mixed
     */
    public function getCaptionIsEdited()
    {
        return $this->caption_is_edited;
    }

    /**
     * @param mixed $caption_is_edited
     */
    public function setCaptionIsEdited($caption_is_edited): void
    {
        $this->caption_is_edited = $caption_is_edited;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @param mixed $locationName
     */
    public function setLocationName($locationName): void
    {
        $this->locationName = $locationName;
    }

}
