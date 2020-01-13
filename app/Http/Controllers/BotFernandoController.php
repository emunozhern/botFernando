<?php

namespace App\Http\Controllers;

use App\Services\Scraping;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BotFernandoController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $message = "";
            $scp = new Scraping();

            $flagUserConnect = false;
            $flagVoteProfile = false;
            $flagVoteView = false;
            $flagVoteBlog = false;

            $c = $scp->authenticateLogin($request->username, $request->passwd);
            if (Str::contains($c, 'Cerrar la sesión')) {
                $flagUserConnect = true;
            }

            if (strpos($request->url, 'view_profile') !== false && $flagUserConnect) {
                $t = $scp->voteProfile($request->url, 10);
                if (strpos($t, 'Rating') !== false) {
                    $flagVoteProfile = true;
                }

            }

            if (strpos($request->url, 'MIView') !== false && $flagUserConnect) {
                $t = $scp->votePicture($request->url, 10);
                if (strpos($t, 'Rating') !== false) {
                    $flagVoteView = true;
                }
            }

            if (strpos($request->url, 'view_blogDetail') !== false && $flagUserConnect) {
                $t = $scp->voteBlog($request->url, 10);
                if (strpos($t, 'Rating') !== false) {
                    $flagVoteBlog = true;
                }
            }

            $message = [
                'username' => $request->username,
                'url' => $request->url,
                'isUserAuth' => $flagUserConnect,
                'isVoteProfile' => $flagVoteProfile,
                'isVoteView' => $flagVoteView,
                'isVoteBlog' => $flagVoteBlog,
            ];

            return $message;

        }

        return view('index');

    }
}
