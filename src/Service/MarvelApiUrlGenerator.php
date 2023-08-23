<?php

namespace App\Service;

class MarvelApiUrlGenerator
{
    private $publicKey;
    private $privateKey;

    public function __construct(string $publicKey, string $privateKey)
    {
        // Store the provided public and private keys for authentication
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function generateCharacterUrl(string $characterName): string
    {
        // Create a timestamp for the current time
        $ts = time();
        
        // Generate a hash using the timestamp, private key, and public key
        $hash = md5($ts . $this->privateKey . $this->publicKey);

        // Construct the character URL with the provided name, public key, timestamp, and hash
        return sprintf(
            'https://gateway.marvel.com:443/v1/public/characters?name=%s&apikey=%s&ts=%s&hash=%s',
            $characterName,
            $this->publicKey,
            $ts,
            $hash
        );
    }

    public function generateComicsUrl($limit = 20, $offset = 0)
    {
        // Base URL for comics endpoint
        $baseUrl = 'https://gateway.marvel.com:443/v1/public/comics';
        
        // Create a timestamp for the current time
        $timestamp = time();
        
        // Generate a hash using the timestamp, private key, and public key
        $hash = md5($timestamp . $this->privateKey . $this->publicKey);

        // Construct the comics URL with timestamp, public key, hash, limit, and offset
        $url = "$baseUrl?ts=$timestamp&apikey=$this->publicKey&hash=$hash&limit=$limit&offset=$offset";
        
        return $url;
    }

    public function generateCharactersUrl($limit = 10, $offset = 0)
{
    // Base URL for characters endpoint
    $baseUrl = 'https://gateway.marvel.com:443/v1/public/characters';
    
    // Create a timestamp for the current time
    $timestamp = time();
    
    // Generate a hash using the timestamp, private key, and public key
    $hash = md5($timestamp . $this->privateKey . $this->publicKey);

    // Construct the characters URL with timestamp, public key, hash, limit, and offset
    $url = "$baseUrl?ts=$timestamp&apikey=$this->publicKey&hash=$hash&limit=$limit&offset=$offset";
    
    return $url;
}

}
