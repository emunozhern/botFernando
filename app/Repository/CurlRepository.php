<?php

namespace App\Repository;

class CurlRepository
{
    protected $ch;

    public function get(string $cookieName, string $url): string
    {
        $cookieName = strtolower($cookieName);

        $cookiePath = dirname(__FILE__) . "/{$cookieName}.txt";

        // $httpHeader = array("Content-Type: application/x-www-form-urlencoded", "Upgrade-Insecure-Requests: 1");
        $httpHeader = array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Language: en,es;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'DNT: 1',
            'Host: www.aztecasecreto.com',
            'Pragma: no-cache',
            'Referer: http://www.aztecasecreto.com/',
            'Upgrade-Insecure-Requests: 1',
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);

        $html = curl_exec($ch);

        curl_close($ch);

        return $html;
    }

    public function post(string $cookieName, string $url, array $postField, $saveCookie = false, $isAjax = false): string
    {
        $cookieName = strtolower($cookieName);

        $cookiePath = dirname(__FILE__) . "/{$cookieName}.txt";

        // $httpHeader = array(Content-Type: application/x-www-form-urlencoded", "Upgrade-Insecure-Requests: 1");

        $httpHeader = array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Language: en,es;q=0.9',
            'Content-Type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'DNT: 1',
            'Host: www.aztecasecreto.com',
            'Pragma: no-cache',
            'Referer: http://www.aztecasecreto.com/',
            'Upgrade-Insecure-Requests: 1',
        );

        if ($isAjax) {
            // $httpHeader = array("Content-Type: application/x-www-form-urlencoded", "X-MicrosoftAjax: Delta=true", "X-Requested-With: XMLHttpRequest");
            $httpHeader = array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Accept-Language: en,es;q=0.9',
                'Content-Type: application/x-www-form-urlencoded',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
                'DNT: 1',
                'Host: www.aztecasecreto.com',
                'Pragma: no-cache',
                'Referer: http://www.aztecasecreto.com/',
                'Upgrade-Insecure-Requests: 1',
                'X-MicrosoftAjax: Delta=true',
                'X-Requested-With: XMLHttpRequest',
            );

        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postField));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);

        if ($saveCookie) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiePath);
        }

        $html = curl_exec($ch);

        return $html;
    }
}
