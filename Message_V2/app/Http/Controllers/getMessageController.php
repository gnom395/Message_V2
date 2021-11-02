<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\MessagesNew;


class getMessageController extends Controller
{
  public function getMessage(Request $request) {

    if(is_null($request->to)) {
      echo "error no to";
      exit;
    }
    $to = $request->to;

    if(is_null($request->from)) {
      $from = $request->session()->get('id');
      //$to = $request->to;
    } else {
      $from = $request->from;
    }

    ///  получаем сообщения
    $messages = DB::select('SELECT * FROM messages WHERE (fromUser = :from1 and toUser = :to1) or (toUser = :from2 and :to2=(case when fromUser <>0 then  fromUser else toGroup end)) ORDER BY id DESC LIMIT 30', ['from1' => $from, 'to1' => $to, 'from2' => $from, 'to2' => $to]);


   /// удаляем новые сообщения с временной
    MessagesNew::where('toUser', $from)
      ->where('fromUser', $to)
      ->delete();

   /// обновляем в главной таблице сообщения
    Message::where('toUser', $from)
      ->where('fromUser', $to)
      ->where('readMes', 0)
      ->update(['readMes' => 1]);

          //  "UPDATE `Message` SET `readMes` = '1' WHERE `toUser` = '".$from."' and fromUser = '".$to."' and readMes = '0'"

  //  $successAr['success'] = $messages;
    //$successAr[''] = [
    //  'myid' => $request->session()->get('id')
    //];

    foreach ($messages as $message) {
  //dd($request->to);

    if($request->to == $message->fromUser){
      $mymes = 0;
    } else {
      $mymes = 1;
    }


      $dat = date("H:i d.m.Y", strtotime($message->dateIn));



      $response[] = array(

              'id' => $message->id,
              'to' => $message->toUser,
              'from' => $message->fromUser,
              'message' => $message->message,
              'attach' => $message->attachFile,
              'read' => $message->readMes,
              'mymes' => $mymes,
              'datesend' => $dat
              //'read' => $eraParamGet['readMes']
      );
    }
    //$response['success'] = $response;
    sort($response);
    return json_encode($response);
  }
}
