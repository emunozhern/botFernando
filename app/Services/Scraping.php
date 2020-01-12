<?php

namespace App\Services;

use App\Services\HandlerCurl;
use KubAT\PhpSimple\HtmlDomParser;

class Scraping
{
    protected $url;

    public function __construct()
    {
        $this->handlerCurl = new HandlerCurl();
    }

    public function showPageAndParserForm($url)
    {
        $response = $this->handlerCurl->get($url);

        $htmlDomParser = HtmlDomParser::str_get_html($response);
        $postField = [];

        foreach ($htmlDomParser->find('form[name="aspnetForm"] input') as $key => $value) {
            $postField = array_merge($postField, [$value->name => $value->value]);
        }

        return $postField;
    }

    public function authenticateLogin($user, $passwd)
    {
        $url = 'http://www.aztecasecreto.com/Login.aspx';

        $credentials = [
            'ctl00$oCPH1$txtEmail' => $user,
            'ctl00$oCPH1$txtPassword' => $passwd,
            'ctl00$oCPH1$btnLogin.x' => '55',
            'ctl00$oCPH1$btnLogin.y' => '17',
        ];

        $postField = $this->showPageAndParserForm($url);

        $postField = array_merge($postField, $credentials);
        return $this->handlerCurl->post($url, $postField);
    }

    public function voteProfile($url, $starRate)
    {
        $extraField = [
            'ctl00$sciptManagerMaster' => 'ctl00$oCPH1$CTRL_rating$pnlUpdateRating|ctl00$oCPH1$CTRL_rating$btnRating',
            '__ASYNCPOST' => true,
            'ctl00$oCPH1$CTRL_rating$hdnStarRate' => $starRate,
        ];

        $postField = $this->showPageAndParserForm($url);

        $postField = array_merge($postField, $extraField);

        return $this->handlerCurl->post($url, $postField, true);
    }

    public function votePicture($url, $starRate)
    {
        $extraField = [
            'ctl00$sciptManagerMaster' => 'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$pnlUpdateRating|ctl00$oCPH1$tabControl$ctl00$CTRL_rating$btnRating',
            '__ASYNCPOST' => true,
            'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$hdnStarRate' => $starRate,
        ];

        $postField = $this->showPageAndParserForm($url);

        $postField = array_merge($postField, $extraField);

        return $this->handlerCurl->post($url, $postField, true);
    }

}
