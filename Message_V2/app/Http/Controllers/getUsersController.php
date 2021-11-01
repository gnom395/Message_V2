<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class getUsersController extends Controller
{
     public function getUsers(Request $request) {


        //$from = $request->id;
        if(!$request->myid) {
          return 'error myid';
          exit;
        }
        $fromid = $request->myid;

        $Users_online = DB::select('SELECT messages_news.FromUser,count(messages_news.id) as mescount, users.name as nameuser, users.dateOnline as online FROM `messages_news` left join users on messages_news.fromUser=users.id WHERE toUser = ? group by FromUser,users.name,users.dateOnline', [$fromid]);

        $Users = DB::select('SELECT users.*,groups.name as groups, groups.id as groups_id FROM `users` left join groups on users.id_office=groups.id ORDER BY `groups` ASC');

        /// обновляем пользователя что он в сети
      //  DB::select('UPDATE `users` SET `dateOnline` = NOW() WHERE `users`.`id` = ?', [$from]);
       //// ставим что в сети
        User::where('id', $fromid)
          ->update(['dateOnline' => NOW()]);

        $grcount = "";
        $successAr['success'] = array();
        $dateminus = date('Y-m-d H:i:s', strtotime('-1 minutes'));


        foreach($Users_online as $rowMes) {

          if($rowMes->online < $dateminus) {
            $online = 0;
          } else{
          $online = 1;
          }

            $successAr[] = [
              'id' => $rowMes->FromUser,
              'name' => $rowMes->nameuser,
              'new_mes' => $rowMes->mescount,
              'online' => $online
            ];
        }

        foreach($Users as $row) {

          if($row->dateOnline < $dateminus) {
            $online = 0;
          } else{
            $online = 1;
          }

          if($grcount != $row->groups_id) {
            $successAr[] = [
              'id' => $row->id,
              'name' => $row->groups,
              'groups_id' => $row->groups_id,
              'is_group' => 1
            ];
          }

          if($fromid != $row->id) {
            $successAr[] = [
              'id' => $row->id,
              'name' => $row->name,
              'about' => $row->about,
              'is_group' => 0,
              'onlinedat' => $row->dateOnline,
              'online' => $online
            ];
          }

          $grcount = $row->groups_id;
        }

        return $successAr;
      }
}
