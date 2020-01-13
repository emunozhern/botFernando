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

    public function voteBlog($url, $starRate)
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

    public function createBlog()
    {
        $url = 'http://www.aztecasecreto.com/net/blog/blog.aspx';

        $extraField = [
            'ctl00$oCPH1$tabControl$ctl00$txtTitle' => 'holaaaa este es mi primer post',
            'ctl00$oCPH1$tabControl$ctl00$txtBody' => 'holaaaa este es mi primer post',
        ];

        $postField = $this->showPageAndParserForm($url);

        $postField = array_merge($postField, $extraField);
        return $this->handlerCurl->post($url, $postField);
    }

    public function deleteBlog()
    {
        $url = 'http://www.aztecasecreto.com/net/blog/view_blog.aspx';

        $response = $this->handlerCurl->get($url);

        $htmlDomParser = HtmlDomParser::str_get_html($response);
        $linksDelete = "";

        foreach ($htmlDomParser->find('td[class="SCBlogLinks"] a') as $key => $value) {
            if (strpos($value->href, 'deleteBlog') !== false) {
                $linksDelete = $this->handlerCurl->get("http://www.aztecasecreto.com/net/blog/{$value->href}");
            }
        }

        return $linksDelete;
    }

}
