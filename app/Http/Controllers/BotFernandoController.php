<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repository\BotRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BotFernandoController extends Controller
{
    protected $botRepo;

    protected $message = [
        'status' => 0,
        'message' => "",
    ];

    public function __construct(BotRepository $botRepository)
    {
        $this->botRepo = $botRepository;
    }

    public function index(Request $request)
    {
        return view('index');
    }

    public function uploadAccountFile(Request $request)
    {
        if ($request->hasFile('account_files')) {
            $file = $request->file('account_files');
            Storage::disk('local')->put('accounts.txt', File::get($file));
            $this->message['status'] = 1;
        }

        return response()->json($this->message);
    }

    public function loginAccount(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {

                $this->message['accounts'][$account[0]] = $this->botRepo->login($account[0], $account[1]);

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function voteInBlogs(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {
                $user = $this->botRepo->getUser($account[0]);
                $this->message['accounts'][$account[0]] = $user;

                if ($user['is_auth']) {
                    $voteResponse = $this->botRepo->voteBlog($account[0], $request->url);
                    if ($voteResponse) {
                        $this->message['message'] = "<tr><td><span class='badge badge-success'>Voto Blog</span> <strong> {$account[0]} </strong> voto en el blog <a href='{$request->url}' target='_blank'>{$request->url}</a></td></tr>";
                    }
                }

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function voteInProfile(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {
                $user = $this->botRepo->getUser($account[0]);
                $this->message['accounts'][$account[0]] = $user;

                if ($user['is_auth']) {
                    $voteResponse = $this->botRepo->voteProfile($account[0], $request->url);
                    if ($voteResponse) {
                        $this->message['message'] = "<tr><td><span class='badge badge-success'>Voto Perfil</span> <strong> {$account[0]} </strong> voto en el perfil <a href='{$request->url}' target='_blank'>{$request->url}</a></td></tr>";
                    }
                }

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function voteInImage(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {
                $user = $this->botRepo->getUser($account[0]);
                $this->message['accounts'][$account[0]] = $user;

                if ($user['is_auth']) {
                    $voteResponse = $this->botRepo->voteImage($account[0], $request->url);
                    if ($voteResponse) {
                        $this->message['message'][] = "<tr><td><span class='badge badge-success'>Voto Imagen</span> <strong> {$account[0]} </strong> voto en la imagen <a href='{$request->url}' target='_blank'>{$request->url}</a></td></tr>";
                    }
                }

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function createBlog(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {
                $user = $this->botRepo->getUser($account[0]);
                $this->message['accounts'][$account[0]] = $user;

                if ($user['is_auth']) {
                    $voteResponse = $this->botRepo->createBlog($account[0]);
                    if ($voteResponse) {
                        $this->message['message'] = "<tr><td><span class='badge badge-success'>Crear Blog</span> <strong> {$account[0]} </strong> creo un blog</td></tr>";
                    }
                }

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function destroyBlog(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {
                $user = $this->botRepo->getUser($account[0]);
                $this->message['accounts'][$account[0]] = $user;

                if ($user['is_auth']) {
                    $voteResponse = $this->botRepo->destroyBlog($account[0]);
                    if ($voteResponse) {
                        $this->message['message'] = "<tr><td><span class='badge badge-success'>Eliminar Blog</span> <strong> {$account[0]} </strong> elimino todos los blog</td></tr>";
                    }
                }

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }

    public function getUser(Request $request)
    {
        foreach ($this->botRepo->getAccountFile() as $key => $account) {

            $account = explode(":", $account);

            if (!empty($account[0])) {

                $s = $this->botRepo->getUser($account[0]);
                dd($s);

            }
        }

        $this->message['status'] = 1;

        return response()->json($this->message);
    }
}
