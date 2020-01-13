<?php

namespace App\Http\Controllers;

use App\Services\Scraping;
use Illuminate\Http\Request;

class BotFernandoController extends Controller
{

    public function inString($value, $match)
    {
        return strpos($value, $match) !== false;
    }

    public function index(Request $request)
    {

        // if (true) {
        if ($request->ajax()) {
            $message = "";
            $scp = new Scraping();

            $flagUserConnect = false;
            $flagVoteProfile = false;
            $flagVoteView = false;
            $flagVoteBlog = false;
            $flagCreatedBlog = false;
            $flagDeletedBlog = false;

            $c = $scp->authenticateLogin('FernandoNR', 'FernandoNR');
            if ($this->inString($c, 'Cerrar la sesión')) {
                $flagUserConnect = true;
            }

            if ($this->inString($request->url, 'view_profile') && $flagUserConnect) {
                $t = $scp->voteProfile($request->url, 10);
                if ($this->inString($t, 'Rating')) {
                    $flagVoteProfile = true;
                }

            }

            if ($this->inString($request->url, 'MIView') && $flagUserConnect) {
                $t = $scp->votePicture($request->url, 10);
                if ($this->inString($t, 'Rating')) {
                    $flagVoteView = true;
                }
            }

            if ($this->inString($request->url, 'view_blog') && $flagUserConnect) {
                $t = $scp->voteBlog($request->url, 10);
                if ($this->inString($t, 'Rating')) {
                    $flagVoteBlog = true;
                }
            }

            if ($flagUserConnect) {
                $t = $scp->createBlog();
                if ($this->inString($t, 'Your blog entry has been created')) {
                    $flagCreatedBlog = true;
                }
            }

            if ($flagUserConnect) {
                $t = $scp->deleteBlog();
                if ($this->inString($t, 'Entry has been deleted')) {
                    $flagDeletedBlog = true;
                }
            }

            $message = [
                'username' => $request->username,
                'url' => $request->url,
                'isUserAuth' => $flagUserConnect,
                'isVoteProfile' => $flagVoteProfile,
                'isVoteView' => $flagVoteView,
                'isVoteBlog' => $flagVoteBlog,
                'isCreatedBlog' => $flagCreatedBlog,
                'isDeletedBlog' => $flagDeletedBlog,
            ];

            return $message;

        }

        return view('index');

    }
}
