 <?php
include "index.php";
//===================================================================
$send = json_decode(file_get_contents("user.json"),true);
if($send["sendtoall"] == "true"){
$text = $send["text"];
$get = $send["array"];
$files = scandir('data/user/');
for($z = $get;$z <= count($files)-1;$z++){
$file = pathinfo($files[$z]);
$mmd = $file['filename'];
     jijibot('sendmessage',[
          'chat_id'=>$mmd,        
		  'text'=>"$text",
        ]);
$inuser = json_decode(file_get_contents("sendall.json"),true);
$get = $inuser["send"];
$getplus = $get + 1 ;
$inuser["send"]="$getplus";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);
if($getplus >= 500){
$inuser = json_decode(file_get_contents("sendall.json"),true);
$inuser["send"]="0";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);	
$send = json_decode(file_get_contents("user.json"),true);
$array = $send["array"];
$plusarray = $array + $getplus;
$send["array"]="$plusarray";
$send = json_encode($send,true);
file_put_contents("user.json",$send);	
break;
}
}
jijibot('sendmessage',[
      'chat_id'=>$Dev[0],
      'text'=>"📍پیام همگانی شما ارسال شد",
 ]);

}
//==============================================================================
$send = json_decode(file_get_contents("user.json"),true);
if($send["fortoall"] == "true"){
$chat = $send["chat"];
$msg = $send["msg"];
$get = $send["array"];
$files = scandir('data/user/');
for($z = $get;$z <= count($files)-1;$z++){
$file = pathinfo($files[$z]);
$mmd = $file['filename'];
jijibot('ForwardMessage',[
'chat_id'=>$mmd,
'from_chat_id'=>$chat,
'message_id'=>$msg
]);
$inuser = json_decode(file_get_contents("sendall.json"),true);
$get = $inuser["send"];
$getplus = $get + 1 ;
$inuser["send"]="$getplus";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);
if($getplus >= 500){
$inuser = json_decode(file_get_contents("sendall.json"),true);
$inuser["send"]="0";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);	
$send = json_decode(file_get_contents("user.json"),true);
$array = $send["array"];
$plusarray = $array + $getplus;
$send["array"]="$plusarray";
$send = json_encode($send,true);
file_put_contents("user.json",$send);
break;
}
}
  jijibot('sendmessage',[
      'chat_id'=>$Dev[0],
      'text'=>" پیام برای همه کاربران  فوروارد شد !",
 ]);
}
//=====================================================
$send = json_decode(file_get_contents("user.json"),true);
if($send["sendtoallgp"] == "true"){
$text = $send["text"];
$get = $send["array"];
$files = scandir('data/gp/');
for($z = $get;$z <= count($files)-1;$z++){
$file = pathinfo($files[$z]);
$mmd = $file['filename'];
     jijibot('sendmessage',[
          'chat_id'=>$mmd,        
		  'text'=>"$text",
        ]);
$inuser = json_decode(file_get_contents("sendall.json"),true);
$get = $inuser["send"];
$getplus = $get + 1 ;
$inuser["send"]="$getplus";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);
if($getplus >= 500){
$inuser = json_decode(file_get_contents("sendall.json"),true);
$inuser["send"]="0";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);	
$send = json_decode(file_get_contents("user.json"),true);
$array = $send["array"];
$plusarray = $array + $getplus;
$send["array"]="$plusarray";
$send = json_encode($send,true);
file_put_contents("user.json",$send);	
break;
}
}
jijibot('sendmessage',[
      'chat_id'=>$Dev[0],
      'text'=>"📍 پیام برای همه گروه ها ارسال شد !",
 ]);

}
//==================================================
$send = json_decode(file_get_contents("user.json"),true);
if($send["fortoall"] == "true"){
$chat = $send["chat"];
$msg = $send["msg"];
$get = $send["array"];
$files = scandir('data/gp/');
for($z = $get;$z <= count($files)-1;$z++){
$file = pathinfo($files[$z]);
$mmd = $file['filename'];
jijibot('ForwardMessage',[
'chat_id'=>$mmd,
'from_chat_id'=>$chat,
'message_id'=>$msg
]);
$inuser = json_decode(file_get_contents("sendall.json"),true);
$get = $inuser["send"];
$getplus = $get + 1 ;
$inuser["send"]="$getplus";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);
if($getplus >= 500){
$inuser = json_decode(file_get_contents("sendall.json"),true);
$inuser["send"]="0";
$inuser = json_encode($inuser,true);
file_put_contents("sendall.json",$inuser);	
$send = json_decode(file_get_contents("user.json"),true);
$array = $send["array"];
$plusarray = $array + $getplus;
$send["array"]="$plusarray";
$send = json_encode($send,true);
file_put_contents("user.json",$send);
break;
}
}
  jijibot('sendmessage',[
      'chat_id'=>$Dev[0],
      'text'=>" پیام برای همه گروه ها فوروارد شد !",
 ]);
}
?> 
