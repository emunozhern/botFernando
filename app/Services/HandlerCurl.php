<?php

namespace App\Services;

class HandlerCurl
{
    protected $ch;

    public function __construct()
    {
        $this->ch = curl_init();
        $this->cookiePath = dirname(__FILE__) . '/cookie.txt';
    }

    public function get(string $url): string
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookiePath);
        return curl_exec($this->ch);
        // curl_close($this->ch);
    }

    public function post(string $url, array $postField, $isAjax = false): string
    {
        $httpHeader = array("Content-Type: application/x-www-form-urlencoded", "Upgrade-Insecure-Requests: 1");

        if ($isAjax) {
            $httpHeader = array("Content-Type: application/x-www-form-urlencoded", "X-MicrosoftAjax: Delta=true", "X-Requested-With: XMLHttpRequest");
        }

        // $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($postField));
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookiePath);
        return curl_exec($this->ch);
    }

}
