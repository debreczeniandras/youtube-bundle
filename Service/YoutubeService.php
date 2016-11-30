<?php

namespace Dga\YoutubeBundle\Service;

use Dga\Youtube;
use Dga\Youtube\Resource\Video;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Andras Debreczeni <dev@debreczeniandras.hu>
 */
class YoutubeService
{
    /**
     * @var Youtube\Client
     */
    private $client;

    /**
     * @param Youtube\Client $client
     */
    public function __construct(Youtube\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $id
     *
     * @return Video
     */
    public function getVideoById($id)
    {
        $parameters['id']         = (string)$id;
        $parameters['maxResults'] = 1;
        $parameters['part']       = 'id,snippet,statistics,suggestions,status,localizations,contentDetails';

        $videoList = $this->client->Videos($parameters);

        return $videoList->getItems()->first();
    }

    /**
     * @param $videoId
     *
     * @return ArrayCollection|Video[]
     */
    public function getRelatedVideos($videoId)
    {
        $params['relatedToVideoId'] = $videoId;

        $searchResponse = $this->client->Search($params);

        return $searchResponse->getVideos();
    }

    /**
     * Youtube expects tags like this:
     * ##"foo" ##"bar" ##"en"
     *
     * @param      $tags
     *
     * @return Video[]|ArrayCollection
     */
    public function getVideosByTags($tags)
    {
        $quoted = array_map(function ($value) {
            return "##$value";
        }, $tags);

        $searchListResponse = $this->client->Search([
            'type' => 'video',
            'q'    => implode(' ', $quoted),
        ]);

        return $searchListResponse->getVideos();
    }

    /**
     * @param string $languageIso
     * @param string $countryIso
     *
     * @return ArrayCollection|Video[]
     */
    public function getMostRelevantVideos($languageIso, $countryIso = null)
    {
        $params = [
            'type'              => 'video',
            'maxResults'        => 8,
            'relevanceLanguage' => $languageIso
        ];

        if ($countryIso) {
            $params['regionCode'] = $countryIso;
        }

        $videoList = $this->client->Search($params);

        return $videoList->getVideos();
    }

    /**
     * @param string $languageIso
     *
     * @return ArrayCollection|Video[]
     */
    public function getPlayLists($languageIso)
    {
        $params = [
            'type'       => 'video',
            'maxResults' => 8,
            'hl'         => $languageIso
        ];

        $playList = $this->client->Playlists($params);

        return $playList->getItems();
    }

    public function getLatestVideo()
    {
        // TODO: Implement findLatestVideo() method.
    }

    public function getMostViewedVideo()
    {
        // TODO: Implement findMostViewedVideo() method.
    }

    public function searchVideos()
    {
        // TODO: Implement searchVideos() method.
    }
}
