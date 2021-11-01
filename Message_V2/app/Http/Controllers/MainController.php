<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Message;
use App\Models\MessagesNew;
use App\Models\Group;
use App\Models\UsersInGroup;
use Illuminate\Support\Facades\Validator;
use Config;

class MainController extends Controller
{

  //// вход на сайт
  public function EnterOk(Request $request) {

    //$token = Config::get('myconfig.my.token');
    //$url_api = Config::get('myconfig.my.url_api');

    //$ip =  $request->ip();
    $ip = "192.168.88.16";

    $User = User::where('ip', $ip)->first();

    if(is_null($User)) {
      return 'error ip '.$ip;
    } else {
      $response['success'] = $User;
      //  $response['success'] = array(
      //    'success' => '1',
      //    'id' => ''
      //  );
      //return (response(json_encode($response, JSON_UNESCAPED_UNICODE), 200)
      //              ->header('Content-Type', 'application/json; charset=utf-8'));

      session(['id' => $User->id]);
      session(['name' => $User->name]);
      session(['about' => $User->about]);

      return view('index', ['id' => $request->session()->get('id') ,'name' => $request->session()->get('name') ,'ip' => $ip]);
    }
  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function getUserInfo(Request $request) {

    if(is_null($request->id)) {
      return 'error 6';
      exit;
    }

    $User = User::where('id', $request->id)->first();

    //$successAr['success'] = array();
    $dateminus = date('Y-m-d H:i:s', strtotime('-1 minutes'));

    if($User->dateOnline < $dateminus) {
      $online = 0;
    } else{
      $online = 1;
    }
    $successAr = array();

    $successAr['success'] = [
      'id' => $User->id,
      'name' => $User->name,
      'about' => $User->about,
      'online' => $online
    ];

    return json_encode($successAr);
  }

}
