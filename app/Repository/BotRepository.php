<?php

namespace App\Repository;

use App\Repository\CurlRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use KubAT\PhpSimple\HtmlDomParser;

class BotRepository
{
    protected $curlRepo;

    protected $IS_AUTH = 'Cerrar la sesión';
    protected $IS_VOTE = 'Rating';
    protected $IS_BLOG_CREATED = 'Your blog entry has been created';
    protected $IS_BLOG_DESTROY = 'Entry has been deleted';

    protected $START_RATE = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    public function __construct(CurlRepository $curlRepository)
    {
        $this->curlRepo = $curlRepository;
    }

    public function getFormInputs($cookieName, $url)
    {
        $html = $this->curlRepo->get($cookieName, $url);

        $htmlDomParser = HtmlDomParser::str_get_html($html);
        $postField = [];

        foreach ($htmlDomParser->find('form[name="aspnetForm"] input') as $key => $value) {
            $postField = array_merge($postField, [$value->name => $value->value]);
        }

        return $postField;
    }

    public function login($user, $passwd)
    {
        $url = 'http://www.aztecasecreto.com/Login.aspx';

        $credentials = [
            'ctl00$oCPH1$txtEmail' => $user,
            'ctl00$oCPH1$txtPassword' => $passwd,
            'ctl00$oCPH1$btnLogin.x' => '55',
            'ctl00$oCPH1$btnLogin.y' => '17',
        ];

        $postField = $this->getFormInputs($user, $url);

        $postField = array_merge($postField, $credentials);

        $content = $this->curlRepo->post($user, $url, $postField, true);

        return $this->getUser($user, $content);
    }

    public function getUser($user, $content = false)
    {
        if (!$content) {
            $url = 'http://www.aztecasecreto.com/net/home.aspx';

            $content = $this->curlRepo->get($user, $url);
        }

        $message = [
            'point' => 0,
            'is_auth' => false,
        ];

        if (preg_match("/<span.*&reg;(.*?)<\/span><br.*>/im", $content)) {

            $match = preg_match_all("/<span.*&reg;(.*?)<\/span><br.*>/im", $content, $matches);

            $message['point'] = $matches[1][0];
        }

        $message['is_auth'] = $this->confirmWords($content, $this->IS_AUTH);

        return $message;
    }

    public function getAccountFile()
    {
        if (Storage::disk('local')->exists('accounts.txt')) {
            $accounts = Storage::disk('local')->get('accounts.txt');

            $accounts = explode("\n", $accounts);
            return $accounts;

        }

        return [];
    }

    public function confirmWords($content, $q)
    {
        return Str::contains(strtolower($content), strtolower($q));
    }

    public function getStartRate()
    {
        return Arr::random($this->START_RATE);
    }

    public function voteBlog($user, $url)
    {
        $message = [
            'url' => $url,
            'is_success' => false,
        ];

        $extraField = [
            'ctl00$sciptManagerMaster' => 'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$pnlUpdateRating|ctl00$oCPH1$tabControl$ctl00$CTRL_rating$btnRating',
            '__ASYNCPOST' => true,
            'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$hdnStarRate' => $this->getStartRate(),
        ];

        $postField = $this->getFormInputs($user, $url);

        $postField = array_merge($postField, $extraField);

        $content = $this->curlRepo->post($user, $url, $postField, false, true);

        $message['is_success'] = $this->confirmWords($content, $this->IS_VOTE);

        return $message['is_success'];
    }

    public function voteProfile($user, $url)
    {
        $message = [
            'url' => $url,
            'is_success' => false,
        ];

        $extraField = [
            'ctl00$sciptManagerMaster' => 'ctl00$oCPH1$CTRL_rating$pnlUpdateRating|ctl00$oCPH1$CTRL_rating$btnRating',
            '__ASYNCPOST' => true,
            'ctl00$oCPH1$CTRL_rating$hdnStarRate' => $this->getStartRate(),
        ];

        $postField = $this->getFormInputs($user, $url);

        $postField = array_merge($postField, $extraField);

        $content = $this->curlRepo->post($user, $url, $postField, false, true);

        $message['is_success'] = $this->confirmWords($content, $this->IS_VOTE);

        return $message['is_success'];
    }

    public function voteImage($user, $url)
    {
        $message = [
            'url' => $url,
            'is_success' => false,
        ];

        $extraField = [
            'ctl00$sciptManagerMaster' => 'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$pnlUpdateRating|ctl00$oCPH1$tabControl$ctl00$CTRL_rating$btnRating',
            '__ASYNCPOST' => true,
            'ctl00$oCPH1$tabControl$ctl00$CTRL_rating$hdnStarRate' => $this->getStartRate(),
        ];

        $postField = $this->getFormInputs($user, $url);

        $postField = array_merge($postField, $extraField);

        $content = $this->curlRepo->post($user, $url, $postField, false, true);

        $message['is_success'] = $this->confirmWords($content, $this->IS_VOTE);

        return $message['is_success'];
    }

    public function createBlog($user)
    {
        $url = 'http://www.aztecasecreto.com/net/blog/blog.aspx';

        $message = [
            'is_success' => false,
        ];

        $extraField = [
            'ctl00$oCPH1$tabControl$ctl00$txtTitle' => 'holaaaa este es mi primer post',
            'ctl00$oCPH1$tabControl$ctl00$txtBody' => 'holaaaa este es mi primer post',
        ];

        $postField = $this->getFormInputs($user, $url);

        $postField = array_merge($postField, $extraField);

        $content = $this->curlRepo->post($user, $url, $postField);

        $message['is_success'] = $this->confirmWords($content, $this->IS_BLOG_CREATED);

        return $message['is_success'];
    }

    public function destroyBlog($user)
    {
        $url = 'http://www.aztecasecreto.com/net/blog/view_blog.aspx';

        $message = [
            'is_success' => false,
        ];

        $content = $this->curlRepo->get($user, $url);

        $htmlDomParser = HtmlDomParser::str_get_html($content);

        foreach ($htmlDomParser->find('td[class="SCBlogLinks"] a') as $key => $value) {
            if (strpos($value->href, 'deleteBlog') !== false) {
                $this->curlRepo->get($user, "http://www.aztecasecreto.com/net/blog/{$value->href}");
            }
        }

        $message['is_success'] = $this->confirmWords($content, $this->IS_BLOG_DESTROY);

        return $message['is_success'];
    }
}
