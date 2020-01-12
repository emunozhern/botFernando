<?php

namespace App\Http\Controllers;

use App\Services\Scraping;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BotFernandoController extends Controller
{
    public function index(Request $request)
    {
        $message = "";
        $scp = new Scraping();

        if ($request->ajax()) {
            $flagUserConnect = false;
            $flagVoteProfile = false;
            $flagVoteView = false;

            $c = $scp->authenticateLogin($request->username, $request->passwd);
            if (Str::contains($c, 'Cerrar la sesión')) {
                $flagUserConnect = true;

            }

            if (Str::contains($request->url, 'view_profile.aspx') && $flagUserConnect) {
                $t = $scp->voteProfile($request->url, 10);

                if (Str::contains($t, 'Profile Rating')) {

                    $flagVoteProfile = true;
                }

            }

            if (Str::contains($request->url, 'MIView.aspx') && $flagUserConnect) {
                $t = $scp->votePicture($request->url, 10);
                $flagVoteView = true;
            }

            $message = [
                'username' => $request->username,
                'url' => $request->url,
                'isUserAuth' => $flagUserConnect,
                'isVoteProfile' => $flagVoteProfile,
                'isVoteView' => $flagVoteView,
            ];

            return $message;

        }

        return view('index');

    }
}
