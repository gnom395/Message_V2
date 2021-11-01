<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\User;

class postFileController extends Controller
{
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function UploadFile(Request $request)
    {


      if(is_null($request->fromid)){
        return 'error no fromid';
        exit;
      }
      $fromid = $request->fromid;


        $user = User::where('id', $fromid)->first();

        if(is_null($user)) {
          return 'error file 1';
          exit;
        }

      //$validator = Validator::make($request->all(), [
      //    'file' => 'required|max:1024', //5MB
      //]);

      //if($validator->fails() == true) {
      //    return 'error file 2';
      //    exit;
      //}

      $pathfile = 'public/message/'.$fromid;
      $path = $request->file('file')->store($pathfile);
      $filename = $request->file('file')->getClientOriginalName();

      $Attachment = new Attachment;
      $Attachment->from_id = $fromid;
      $Attachment->filename = $filename;
      $Attachment->url = $path;
      $Attachment->date = NOW();

      $Attachment->save();

        $successAr = array(
            'success' => '1',
            'id' => $Attachment->id,
            'from' => $fromid,
            'url' => $path,
            'filename' => $filename
          );
    return json_encode($successAr);

      //  foreach ($request->attach as $attach) {
      //    echo $attach;
      //  }
    }
}
