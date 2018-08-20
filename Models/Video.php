<?php
namespace Tsk\OneDrive\Models;


class Video
{
    private $bitrate;
    private $duration;
    private $height;
    private $width;
    private $audioBitsPerSample;
    private $audioChannels;
    private $audioFormat;
    private $audioSamplesPerSecond;
    private $fourCC;
    private $frameRate;

    /**
     * @return mixed
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * @param mixed $bitrate
     */
    public function setBitrate($bitrate)
    {
        $this->bitrate = $bitrate;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getAudioBitsPerSample()
    {
        return $this->audioBitsPerSample;
    }

    /**
     * @param mixed $audioBitsPerSample
     */
    public function setAudioBitsPerSample($audioBitsPerSample)
    {
        $this->audioBitsPerSample = $audioBitsPerSample;
    }

    /**
     * @return mixed
     */
    public function getAudioChannels()
    {
        return $this->audioChannels;
    }

    /**
     * @param mixed $audioChannels
     */
    public function setAudioChannels($audioChannels)
    {
        $this->audioChannels = $audioChannels;
    }

    /**
     * @return mixed
     */
    public function getAudioFormat()
    {
        return $this->audioFormat;
    }

    /**
     * @param mixed $audioFormat
     */
    public function setAudioFormat($audioFormat)
    {
        $this->audioFormat = $audioFormat;
    }

    /**
     * @return mixed
     */
    public function getAudioSamplesPerSecond()
    {
        return $this->audioSamplesPerSecond;
    }

    /**
     * @param mixed $audioSamplesPerSecond
     */
    public function setAudioSamplesPerSecond($audioSamplesPerSecond)
    {
        $this->audioSamplesPerSecond = $audioSamplesPerSecond;
    }

    /**
     * @return mixed
     */
    public function getFourCC()
    {
        return $this->fourCC;
    }

    /**
     * @param mixed $fourCC
     */
    public function setFourCC($fourCC)
    {
        $this->fourCC = $fourCC;
    }

    /**
     * @return mixed
     */
    public function getFrameRate()
    {
        return $this->frameRate;
    }

    /**
     * @param mixed $frameRate
     */
    public function setFrameRate($frameRate)
    {
        $this->frameRate = $frameRate;
    }
}