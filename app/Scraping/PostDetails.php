<?php
/**
 * Created by PhpStorm.
 * User: Marcel
 * Date: 07/10/2018
 * Time: 00:13
 */

namespace App\Scraping;


class PostDetails
{
    private $isVideo;
    private $displayUrls;
    private $shortcode;
    private $video_view_count;
    private $video_url;
    private $video_duration;

    /**
     * PostDetails constructor.
     * @param $isVideo
     * @param $displayUrls
     * @param $shortcode
     * @param $video_view_count
     * @param $video_url
     * @param $video_duration
     */
    public function __construct($isVideo, $displayUrls, $shortcode)
    {
        $this->isVideo = $isVideo;
        $this->displayUrls = $displayUrls;
        $this->shortcode = $shortcode;
    }


    /**
     * @return mixed
     */
    public function isVideo()
    {
        return $this->isVideo;
    }

    /**
     * @return mixed
     */
    public function getDisplayUrls()
    {
        return $this->displayUrls;
    }

    /**
     * @return mixed
     */
    public function getShortcode()
    {
        return $this->shortcode;
    }

    /**
     * @return mixed
     */
    public function getVideoViewCount()
    {
        return $this->video_view_count;
    }

    /**
     * @return mixed
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * @return mixed
     */
    public function getVideoDuration()
    {
        return $this->video_duration;
    }

    /**
     * @param mixed $video_view_count
     */
    public function setVideoViewCount($video_view_count): void
    {
        $this->video_view_count = $video_view_count;
    }

    /**
     * @param mixed $video_url
     */
    public function setVideoUrl($video_url): void
    {
        $this->video_url = $video_url;
    }

    /**
     * @param mixed $video_duration
     */
    public function setVideoDuration($video_duration): void
    {
        $this->video_duration = $video_duration;
    }
}
