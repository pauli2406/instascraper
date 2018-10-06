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
    private $isVideo;
    private $displayUrl;

    /**
     * Image constructor.
     * @param $caption
     * @param $amountComments
     * @param $isCommentsDisabled
     * @param $amountLikes
     * @param $uploadDate
     * @param $isVideo
     * @param $displayUrl
     */
    public function __construct($caption, $amountComments, $isCommentsDisabled, $amountLikes, $uploadDate, $isVideo, $displayUrl)
    {
        $this->caption = $caption;
        $this->amountComments = $amountComments;
        $this->isCommentsDisabled = $isCommentsDisabled;
        $this->amountLikes = $amountLikes;
        $this->uploadDate = $uploadDate;
        $this->isVideo = $isVideo;
        $this->displayUrl = $displayUrl;
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
     * @return mixed
     */
    public function getisVideo()
    {
        return $this->isVideo;
    }

    /**
     * @return mixed
     */
    public function getDisplayUrl()
    {
        return $this->displayUrl;
    }
}
