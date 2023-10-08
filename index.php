<?php

error_reporting(0);
ob_start();
define('API_KEY','');//توکن ربات
//-----------------------------------------------------------------------------------------
//فانکشن jijibot :
function jijibot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//-----------------------------------------------------------------------------------------
//متغیر ها :
// msg
$Dev = array("000000000","0000000","00000000","000000000"); // ایدی عددی ادمین ها
$usernamebot = "test_fwbot";//ایدی ربات بدون @
$channel = "";//ایدی کانال بدون @
$channel2=""//ایدی کانال دوم بدون @
$botid = "00000000";//ایدی عددی ربات
$namebot="نام ربات";
//-----------------------------------------------------------------------------------------------
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$first_name = $message->from->first_name;
$username = $message->from->username;
$textmassage = $message->text;
$tc = $update->message->chat->type;
$messageid = $update->callback_query->message->message_id;
$tc = $update->message->chat->type;
$chatid = $update->callback_query->message->chat->id;
$fromid = $update->callback_query->from->id;
$data = $update->callback_query->data;
$membercall = $update->callback_query->id;
$firstname = $update->callback_query->from->first_name;
$usernameca = $update->callback_query->from->username;
//=================================================================================================
@$juser = json_decode(file_get_contents("data/user/$from_id.json"),true);
@$cuser = json_decode(file_get_contents("data/user/$fromid.json"),true);
@$getgp = json_decode(file_get_contents("data/gp/$chat_id.json"),true);
@$getgpc = json_decode(file_get_contents("data/gp/$chatid.json"),true);
@$database = json_decode(file_get_contents("data/database.json"),true);
@$rival = json_decode(file_get_contents("data/rival.json"),true);
//==================================================================
if($textmassage=="/start" or $textmassage=="▫️ برگشت به منوی اصلی"){	
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"سلام $first_name عزیز😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
برای شروع بازی کافیه از دکمه های زیر استفاده کنی تا جرات و حقیقت بازی کنیم

🏵 در صورت نیاز به پشتیبانی از دکمه 'پشتیبانی' استفاده کنید.

🆔 کانال اسپانسری ما: @$channel

",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
    		]);
}
else
{
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>" $first_name عزیز😊
	
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !
🎈 به ربات جرات و حقیقت خوش آمدید !
برای شروع بازی کافیه از دکمه های زیر استفاده کنی تا جرات و حقیقت بازی کنیم

🏵 در صورت نیاز به پشتیبانی از دکمه 'پشتیبانی' استفاده کنید.

🆔 کانال اسپانسری ما: @$channel
🆔 کانال اسپانسری ما: @$channel2
",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
if(!file_exists("data/user/$from_id.json")){
$juser = json_decode(file_get_contents("data/user/$from_id.json"),true);	
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);
}
}
elseif(strpos($textmassage , '/start ') !== false  ) {
$start = str_replace("/start ","",$textmassage);
if($start != $from_id){
if($juser["userfild"]["ingame"] == "on"){
jijibot('sendmessage',[
                'chat_id'=>$chat_id,
	'text'=>"🌟 شما یک بازی در حال انجام دارید ابتدا ان را پایان دهید",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
	  	]);
}
else
{
jijibot('sendmessage',[
                'chat_id'=>$chat_id,
	'text'=>"🔄 در حال پردازش بازی ...
	
در حال انداختن قرعه برای شروع بازی ✅",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
	  	]);
$name = str_replace(["`","*","_","[","]"],["","","","",""],$first_name);
jijibot('sendmessage',[
	'chat_id'=>$start,
	'text'=>"🌟 کاربر [$name](tg://user?id=$from_id) با استفاده از لینک دعوت شما وارد ربات شده
	
🔄 در حال پردازش بازی ...
	
در حال انداختن قرعه برای شروع بازی ✅",
'parse_mode'=>'MarkDown',
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
    		]);
$array = array("$from_id",$start);
$random = array_rand($array);
jijibot('sendmessage',[
	'chat_id'=>$array[$random],
	'text'=>"❓ نوبت شماست که سوال بپرسید

🎈 منتظربمانید تا حریف شما جرئت یا حقیقت رو انتخاب کند",
    		]);
$result = array_diff($array , array($array[$random]));
jijibot('sendmessage',[
	'chat_id'=>$result[0],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
jijibot('sendmessage',[
	'chat_id'=>$result[1],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
$juser["userfild"]["rival"]="$start";
$juser["userfild"]["ingame"]="on";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);
$userrival = $start;
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["rival"]="$from_id";
$getrival["userfild"]["ingame"]="on";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
}
else
{
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🎈 خودت که نمیتونی با خودت بازی کنی !
	
ℹ️ لینک رو برای دوستات ارسال کن و اونارو به بازی دعوت کن",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
    		]);	
}
}

elseif($textmassage=="/game" or $textmassage=="/game@$usernamebot"){
if($tc == "group" or $tc == "supergroup"){
if(count($getgp["gamer"]) < 2){
unset($getgp["gamer"]);

$getgp["gamer"][]="$from_id";
$getgamer = $getgp["gamer"];
for($z = 0;$z <= count($getgamer) - 1;$z++){
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$z]",'user_id'=>"$getgamer[$z]"]);
$name = $stat->result->user->first_name;
$zplus = $z + 1 ;
$ingamer = $ingamer."$zplus - $name"."\n";
}
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"🎮 بیاین جرات حقیقت بازی کنیم

🙃 بازیکنان پایه  : 

$ingamer
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ شروع بازی",'callback_data'=>"startgame"],['text'=>"✌🏻 من پایه ام",'callback_data'=>"togame"]
	],
			[
	['text'=>"📢 کانال ما",'url'=>"https://t.me/$channel"],['text'=>"ورود به ربات",'url'=>"https://t.me/$usernamebot"]
	],
              ]
        ])
		]);
$getgp["creator"]="$from_id";
$getgp = json_encode($getgp,true);
file_put_contents("data/gp/$chat_id.json",$getgp);
}
else
{
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"🎮 بازی قبلی هنوز تموم نشده ! امکان ساخت بازی جدید وجود ندارد 
		
📍 ابتدا بازی قبلی را حذف کنید یا ادامه دهید
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"🗑 حذف بازی",'callback_data'=>"removegame"]
	],
              ]
        ])
		]);
}
}
else
{
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🎈 اجرای این دستور تنها در گروه امکان پذیر است",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"]
	],
              ]
        ])
    		]);
}
}
elseif($textmassage=="❌ پایان بازی"){
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"🎈 ایا با پایان دادن به بازی موافق هستی ؟",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"✅ بله",'callback_data'=>"yes"],['text'=>"❌ خیر",'callback_data'=>"no"]
	],
              ]
        ])
		]);
}
elseif($update->message->new_chat_member->id == $botid){
unset($getgp["gamer"]);
$getgp["gamer"][]="$from_id";
$getgamer = $getgp["gamer"];
for($z = 0;$z <= count($getgamer) - 1;$z++){
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$z]",'user_id'=>"$getgamer[$z]"]);
$name = $stat->result->user->first_name;
$zplus = $z + 1 ;
$ingamer = $ingamer."$zplus - $name"."\n";
}
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"🎮 بیاین جرات حقیقت بازی کنیم
		
🙃 بازیکنان پایه  : 

$ingamer
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ شروع بازی",'callback_data'=>"startgame"],['text'=>"✌🏻 من پایه ام",'callback_data'=>"togame"]
	],
			[
	['text'=>"📢 کانال ما",'url'=>"https://t.me/$channel"],['text'=>"ورود به ربات",'url'=>"https://t.me/$usernamebot"]
	],
              ]
        ])
		]);
$getgp["creator"]="$from_id";
$getgp = json_encode($getgp,true);
file_put_contents("data/gp/$chat_id.json",$getgp);
}
elseif($update->message->reply_to_message && $from_id == $Dev[0] && $tc == "private"){
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"پیام شما برای فرد ارسال شد ✔️"
		]);
	jijibot('sendmessage',[
        "chat_id"=>$update->message->reply_to_message->forward_from->id,
        "text"=>"👤 پاسخ پشتیبان برای شما :

`$textmassage`",
'parse_mode'=>'MarkDown'
		]);
}
elseif($data=="togame"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
$key = array_search($fromid,$getgpc["gamer"]);
if(!is_numeric($key)){
$getgpc["gamer"][]="$fromid";
$getgamer = $getgpc["gamer"];
for($z = 0;$z <= count($getgamer) - 1;$z++){
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$z]",'user_id'=>"$getgamer[$z]"]);
$name = $stat->result->user->first_name;
$zplus = $z + 1 ;
$ingamer = $ingamer."$zplus - $name"."\n";
}
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎮 بیاین جرات حقیقت بازی کنیم 
🙃 بازیکنان پایه  : 

$ingamer
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ شروع بازی",'callback_data'=>"startgame"],['text'=>"✌🏻 من پایه ام",'callback_data'=>"togame"]
	],
		[
	['text'=>"📢 کانال ما",'url'=>"https://t.me/$channel"],['text'=>"ورود به ربات",'url'=>"https://t.me/$usernamebot"]
	],
              ]
        ])
	  	]);	
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
    jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما قبلا در این بازی حضور داشتید",
            'show_alert' =>true
        ]);
}
}
else
{
     jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 برای استفاده از ربات باید در کانال @$channel و @$channel2 عضو باشید",
            'show_alert' =>true
        ]);
}
}
elseif($data=="startgame"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
$getstats = jijibot('getChatMember',['chat_id'=>"$chatid",'user_id'=>"$fromid"]);
$stats = $getstats->result->status;
if ($stats == 'creator' or $fromid == $getgpc["creator"]) {
if(count($getgpc["gamer"]) >= 2){
$getgamer = $getgpc["gamer"];
$random = array_rand($getgamer);
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$random]",'user_id'=>"$getgamer[$random]"]);
$name = $stat->result->user->first_name;
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"📍 نوبت $name شد ! انتخاب کن ! 
	
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jo"],['text'=>"🗣 حقیقت",'callback_data'=>"ha"]
	],
			[
	['text'=>"🤞🏻 شانسی",'callback_data'=>"random"]
	],
					[
	['text'=>"⏩ نفر بعدی",'callback_data'=>"othergamer"]
	],
              ]
        ])
	  	]);
      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
$getgpc["turn"]="$getgamer[$random]";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
		     jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 تعداد بازی کنان بازی باید دو نفر یا بیش تر باشد",
            'show_alert' =>true
        ]);
}
}
else
{
   jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما دست رسی به اغاز بازی را ندارید [تنها برای سازنده گروه یا بازی]",
            'show_alert' =>true
        ]);
}
}
else
{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
           'text' => "📍 برای استفاده از ربات باید در کانال @$channel و @$channel2 عضو باشید",
            'show_alert' =>true
        ]);

}
}
elseif(in_array($data,array("jo","ha","random"))){
if($getgpc["turn"] == $fromid){
if($data == "random"){
$array = array("ha","jo");
$random = array_rand($array);
$data = "$array[$random]";
}
$replace = str_replace(["jo","ha"],["جرات رو انتخاب کرد","حقیقت رو انتخاب کرد"],$data);
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🌟 خب $firstname $replace

📍 نوع سوال رو مشخص کن

➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"😊 عادی",'callback_data'=>"normal"],['text'=>"🔞 + 18",'callback_data'=>"plus"]
	],
              ]
        ])
	  	]);
$getgpc["stats"]="$data";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
 jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 نوبت شما برای انتخاب نیست",
            'show_alert' =>true
        ]);
}
}
elseif(in_array($data,array("normal","plus"))){
if($getgpc["turn"] == $fromid){
if($data == "normal"){
$stats = $getgpc["stats"];
$randomchalange = array_rand($database["$stats"]["$data"]);
$randomch = $database["$stats"]["$data"]["$randomchalange"];
$replace = str_replace(["jo","ha"],["انجام بده","حقیقت رو بگو"],$stats);
$replaces = str_replace(["jo","ha"],["انجام بدی","حقیقت رو بگی"],$stats);
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🌟 خب $firstname $replace

📍 $randomch

➖➖➖➖➖➖➖➖

📍 5 دقیقه فرصت داری $replaces",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ عمل کرد",'callback_data'=>"okkard"],['text'=>"❌ عمل نکرد",'callback_data'=>"oknakard"]
	],
              ]
        ])
	  	]);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🌟 خب $firstname

📍 جنسیت خودت رو انتخاب کن

➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"🤴🏻 پسر",'callback_data'=>"boy"],['text'=>"👸🏻 دختر",'callback_data'=>"girl"]
	],
              ]
        ])
	  	]);
}
}
else
{
 jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 نوبت شما برای انتخاب نیست",
            'show_alert' =>true
        ]);
}
}


//---------------------------------
elseif(in_array($data,array("boy","girl"))){
if($getgpc["turn"] == $fromid){
$stats = $getgpc["stats"];
$randomchalange = array_rand($database["$stats"]["plus"]["$data"]);
$randomch = $database["$stats"]["plus"]["$data"]["$randomchalange"];
$replace = str_replace(["jo","ha"],["انجام بده","حقیقت رو بگو"],$stats);
$replaces = str_replace(["jo","ha"],["انجام بدی","حقیقت رو بگی"],$stats);
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🌟 خب $firstname $replace

📍 $randomch

➖➖➖➖➖➖➖➖

📍 5 دقیقه فرصت داری $replaces",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ عمل کرد",'callback_data'=>"okkard"],['text'=>"❌ عمل نکرد",'callback_data'=>"oknakard"]
	],
              ]
        ])
	  	]);
}
else
{
 jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 نوبت شما برای انتخاب نیست",
            'show_alert' =>true
        ]);
}
}
elseif($data=="okkard"){
$getstats = jijibot('getChatMember',['chat_id'=>"$chatid",'user_id'=>"$fromid"]);
$stats = $getstats->result->status;
if ($stats == 'creator' or $fromid == $getgpc["creator"]) {
$replace = str_replace(["jo","ha"],["انجام داد","حقیقت رو گفت"],$getgpc["stats"]);
$turn = $getgpc["turn"];
$statturn = jijibot('getChatMember',['chat_id'=>"$turn",'user_id'=>"$turn"]);
$nameturn = $statturn->result->user->first_name;
$getgamer = $getgpc["gamer"];
$random = array_rand($getgamer);
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$random]",'user_id'=>"$getgamer[$random]"]);
$name = $stat->result->user->first_name;
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"📍 خوب خوب ! $nameturn $replace
	
📍 نوبت $name شد ! انتخاب کن ! 
	
➖➖➖➖➖➖➖➖
👮🏻 داور بازی : @$usernameca",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jo"],['text'=>"🗣 حقیقت",'callback_data'=>"ha"]
	],
			[
	['text'=>"🤞🏻 شانسی",'callback_data'=>"random"]
	],
					[
	['text'=>"⏩ نفر بعدی",'callback_data'=>"othergamer"]
	],
              ]
        ])
	  	]);
		      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
$getgpc["turn"]="$getgamer[$random]";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما دست رسی به داوری بازی را ندارید [تنها برای سازنده گروه یا بازی]",
            'show_alert' =>true
        ]);
}
}
elseif($data=="oknakard"){
$getstats = jijibot('getChatMember',['chat_id'=>"$chatid",'user_id'=>"$fromid"]);
$stats = $getstats->result->status;
if ($stats == 'creator' or $fromid == $getgpc["creator"]) {
$turn = $getgpc["turn"];
$key = array_search($turn,$getgpc["gamer"]);
unset($getgpc["gamer"][$key]);
$getgpc["gamer"] = array_values($getgpc["gamer"]); 
$replace = str_replace(["jo","ha"],["انجام نداد","حقیقت رو نگفت"],$getgpc["stats"]);
if(count($getgpc["gamer"]) >= 2){
$statturn = jijibot('getChatMember',['chat_id'=>"$turn",'user_id'=>"$turn"]);
$nameturn = $statturn->result->user->first_name;
$getgamer = $getgpc["gamer"];
$random = array_rand($getgamer);
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$random]",'user_id'=>"$getgamer[$random]"]);
$name = $stat->result->user->first_name;
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"📍 خوب خوب ! $nameturn $replace 
🎈 از بازی حذف شد
	
📍 نوبت $name شد ! انتخاب کن ! 
	
➖➖➖➖➖➖➖➖
👮🏻 داور بازی : @$usernameca",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jo"],['text'=>"🗣 حقیقت",'callback_data'=>"ha"]
	],
			[
	['text'=>"🤞🏻 شانسی",'callback_data'=>"random"]
	],
				[
	['text'=>"⏩ نفر بعدی",'callback_data'=>"othergamer"]
	],
              ]
        ])
	  	]);
		      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
$getgpc["turn"]="$getgamer[$random]";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
$gamer = $getgpc["gamer"][0];
$statgamer = jijibot('getChatMember',['chat_id'=>"$gamer",'user_id'=>"$gamer"]);
$namegamer = $statgamer->result->user->first_name;
$statturn = jijibot('getChatMember',['chat_id'=>"$turn",'user_id'=>"$turn"]);
$nameturn = $statturn->result->user->first_name;
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"❄️ خوب خوب ! $nameturn $replace 
🎈 از بازی حذف شد
	
📍 تعداد بازیکنان باقی مانده این بازی به حداقل رسیده 
	
🌟 برنده بازی : $namegamer
🎈 برای شروع دوباره بازی /game را ارسال کنید",
	  	]);
		      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
unset($getgpc["gamer"]);
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
}
else
{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما دست رسی به داوری بازی را ندارید [تنها برای سازنده گروه یا بازی]",
            'show_alert' =>true
        ]);
}
}
elseif($data=="othergamer"){
$getstats = jijibot('getChatMember',['chat_id'=>"$chatid",'user_id'=>"$fromid"]);
$stats = $getstats->result->status;
if ($stats == 'creator' or $fromid == $getgpc["creator"]) {
$getgamer = $getgpc["gamer"];
$random = array_rand($getgamer);
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$random]",'user_id'=>"$getgamer[$random]"]);
$name = $stat->result->user->first_name;
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"📍 نوبت $name شد ! انتخاب کن ! 
	
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jo"],['text'=>"🗣 حقیقت",'callback_data'=>"ha"]
	],
			[
	['text'=>"🤞🏻 شانسی",'callback_data'=>"random"]
	],
					[
	['text'=>"⏩ نفر بعدی",'callback_data'=>"othergamer"]
	],
              ]
        ])
	  	]);
      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
$getgpc["turn"]="$getgamer[$random]";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما دست رسی به تعویض بازیکن را ندارید [تنها برای سازنده گروه یا بازی]",
            'show_alert' =>true
        ]);
}
}
elseif($data=="removegame"){
$getstats = jijibot('getChatMember',['chat_id'=>"$chatid",'user_id'=>"$fromid"]);
$stats = $getstats->result->status;
if ($stats == 'creator' or $stats == 'administrator' or $fromid == $getgpc["creator"]) {
unset($getgpc["gamer"]);
$getgpc["gamer"][]="$fromid";
$getgamer = $getgpc["gamer"];
for($z = 0;$z <= count($getgamer) - 1;$z++){
$stat = jijibot('getChatMember',['chat_id'=>"$getgamer[$z]",'user_id'=>"$getgamer[$z]"]);
$name = $stat->result->user->first_name;
$zplus = $z + 1 ;
$ingamer = $ingamer."$zplus - $name"."\n";
}
	jijibot('sendmessage',[
        "chat_id"=>$chatid,
        "text"=>"🎮 بیاین جرات حقیقت بازی کنیم
		
🙃 بازیکنان پایه  : 

$ingamer
➖➖➖➖➖➖➖➖➖",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"☑️ شروع بازی",'callback_data'=>"startgame"],['text'=>"✌🏻 من پایه ام",'callback_data'=>"togame"]
	],
			[
	['text'=>"📢 کانال ما",'url'=>"https://t.me/$channel"],['text'=>"ورود به ربات",'url'=>"https://t.me/$usernamebot"]
	],
              ]
        ])
		]);
      jijibot('deletemessage',[
                'chat_id'=>$chatid,
            'message_id'=>$messageid
            ]);
$getgpc["creator"]="$fromid";
$getgpc = json_encode($getgpc,true);
file_put_contents("data/gp/$chatid.json",$getgpc);
}
else
{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
            'text' => "📍 شما دست رسی به حذف بازی را ندارید [تنها برای ادمین ها و سازنده گروه یا بازی]",
            'show_alert' =>true
        ]);
}
}
elseif($data=="join"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
       jijibot('answercallbackquery', [
            'callback_query_id' =>$membercall,
          'text' => "📍 برای استفاده از ربات باید در کانال @$channel و @$channel2 عضو باشید",
            'show_alert' =>true
        ]);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"کاربر $firstname 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🎮 برای شروع بازی کافیه از دکمه شروع بازی استفاده کنی تا وارد گروه بشیم و جرات و حقیقت بازی کنیم",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
	  	]);
}
}
elseif($data=="gamebylink"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
jijibot('sendphoto',[
                'chat_id'=>$chatid,
	'photo'=>"https://t.me/justfortestjiji/171",
	'caption'=>"🎮 بیا باهم جرئت حقیقت بازی کنیم
	
🌟 از  طریق این لینک وارد شو تا بازی شروع بشه !

telegram.me/$usernamebot?start=$fromid",
	  	]);
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"لینک مخصوص شما برای بازی با دوستت ساخته شد ✅
	
💎 میتونی با ارسال لینک برای دوستت اونو به بازی دعوت کنی و باهم جرئت حقیقت بازی کنید",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🔙 برگشت",'callback_data'=>"back"]
	],
              ]
        ])
	  	]);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
}
elseif($data=="gamerandom"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
$rival = json_decode(file_get_contents("data/rival.json"),true);
if($rival["user"] != false and $rival["user"] != $fromid){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"❌ جست جو به پایان رسید",
	  	]);
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"حریف شما با موفقیت پیدا شد ✅
	
🔄 در حال پردازش بازی ...",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
	  	]);
jijibot('sendmessage',[
	'chat_id'=>$rival["user"],
	'text'=>"حریف شما با موفقیت پیدا شد ✅
	
🔄 در حال پردازش بازی ...",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
    		]);
$array = array("$fromid",$rival["user"]);
$random = array_rand($array);
jijibot('sendmessage',[
	'chat_id'=>$array[$random],
	'text'=>"❓ نوبت شماست که سوال بپرسید

🎈 منتظربمانید تا حریف شما جرئت یا حقیقت رو انتخاب کند",
    		]);
$result = array_diff($array , array($array[$random]));
jijibot('sendmessage',[
	'chat_id'=>$result[0],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
jijibot('sendmessage',[
	'chat_id'=>$result[1],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
$cuser["userfild"]["rival"]=$rival["user"];
$cuser = json_encode($cuser,true);
file_put_contents("data/user/$fromid.json",$cuser);
$userrival = $rival["user"];
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["rival"]=$fromid;
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
unset($rival["user"]);
$rival = json_encode($rival,true);
file_put_contents("data/rival.json",$rival);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎮 برای شروع بازی کسی پیدا نشد !
	
⌛️ شما در لیست انتظار قرار دارید به زودی به یک نفر برای شروع بازی متصل میشوید",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
				[
	['text'=>"❌ لغو جستجو",'callback_data'=>"cancel"]
	],
              ]
        ])
	  	]);	
$rival["user"]="$fromid";
$rival = json_encode($rival,true);
file_put_contents("data/rival.json",$rival);
}
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
}
elseif($data=="no"){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎮 خوب پس ! به بازیت ادامه بده",
	  	]);
}
elseif($data=="yes"){
	jijibot('sendmessage',[
        "chat_id"=>$chatid,
        "text"=>"🎮 بازی به درخواست طرف مقابل به پایان رسید !",
'reply_markup'=>json_encode(['KeyboardRemove'=>[
],'remove_keyboard'=>true
])
		]);
			jijibot('sendmessage',[
        "chat_id"=>$cuser["userfild"]["rival"],
        "text"=>"🎮 بازی به درخواست طرف مقابل به پایان رسید !",
'reply_markup'=>json_encode(['KeyboardRemove'=>[
],'remove_keyboard'=>true
])
		]);
jijibot('sendmessage',[
                'chat_id'=>$chatid,
	'text'=>"🎈 به ربات جرات و حقیقت خوش آمدید !
🎮 برای شروع بازی کافیه از دکمه شروع بازی استفاده کنی تا وارد گروه بشیم و جرات و حقیقت بازی کنیم",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
	  	]);
jijibot('sendmessage',[
	'chat_id'=>$cuser["userfild"]["rival"],
	'text'=>"🎈 به ربات جرات و حقیقت خوش آمدید !
🎮 برای شروع بازی کافیه از دکمه شروع بازی استفاده کنی تا وارد گروه بشیم و جرات و حقیقت بازی کنیم",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
    		]);
$cuser["userfild"]["step"]="none";
$cuser["userfild"]["ingame"]="off";
$cuser = json_encode($cuser,true);
file_put_contents("data/user/$fromid.json",$cuser);
$userrival = $cuser["userfild"]["rival"];
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["step"]="none";
$getrival["userfild"]["ingame"]="off";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
elseif($data=="jorats"){
jijibot('sendmessage',[
	'chat_id'=>$cuser["userfild"]["rival"],
	'text'=>"🎈 حریف شما جرئت را انتخاب کرد
	
🌟 لطفا درخواستت رو ارسال کن
📍 فقط به صورت متن !",
	  	]);
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎈 منتظر ارسال سوال باش ...",
	  	]);
$userrival = $cuser["userfild"]["rival"];
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["step"]="game";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
elseif($data=="haghights"){
jijibot('sendmessage',[
	'chat_id'=>$cuser["userfild"]["rival"],
	'text'=>"🎈 حریف شما حقیقت را انتخاب کرد
	
🌟 لطفا درخواستت رو ارسال کن
📍 فقط به صورت متن !",
	  	]);
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎈 منتظر ارسال سوال باش ...",
	  	]);
$userrival = $cuser["userfild"]["rival"];
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["step"]="game";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
elseif($data=="back"){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"خب $firstname بریم بازیو شروع کنیم ! من رو از طریق دکمه شروع بازی داخل گروه اضافه کن تا بازیو شروع کنیم ! 😄",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
	  	]);
$cuser["userfild"]["step"]="none";
$cuser = json_encode($cuser,true);
file_put_contents("data/user/$fromid.json",$cuser);
unset($rival["user"]);
$rival = json_encode($rival,true);
file_put_contents("data/rival.json",$rival);
}
elseif($data=="cancel"){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"خب $firstname بریم بازیو شروع کنیم ! من رو از طریق دکمه شروع بازی داخل گروه اضافه کن تا بازیو شروع کنیم ! 😄",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
	  	]);
unset($rival["user"]);
$rival = json_encode($rival,true);
file_put_contents("data/rival.json",$rival);
}
elseif($data=="help"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"🎮 راهنما بازی کردن و نحوه بازی جرات حقیقت 
	
	
📍 راهنمای اجرای بازی :
1️⃣  ابتدا ربات را به گروه خود اضافه کنید
2️⃣ پس از اضافه کردن ربات یک پیام به صورت خودکار برای اجرای بازی ارسال میشود 
3️⃣ در هر زمان در گروه خود میتوانید با دستور /game بازی جدید بسازید
	
📍 راهنمای نحوه بازی :
🌟 روش بازی به این شکل هست که بازیکن‌ها به شکل دایره وار بر روی زمین می‌نشینند و ۲ تا ظرف که روی یکی نوشته شده حقیقت و روی دیگری نوشته شده جرأت وجود دارد.در ظرف حقیقت سوالهایی نوشته شده که بازیکن‌ها باید به درستی به آنها جواب بدهند و در ظرف جرأت هم درخواستهایی هست که باز باید جسارت انجام آنها را داشته باشند.",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🔙 برگشت",'callback_data'=>"back"]
	],
              ]
        ])
	  	]);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
}
elseif($data=="sup"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"به بخش ثبت ج ح خوش امدید ❤️ 
	
جرات یا حقیقت خود را ارسال کنید",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🔙 برگشت",'callback_data'=>"back"]
	],
              ]
        ])
    		]);
$cuser["userfild"]["step"]="sup";
$cuser = json_encode($cuser,true);
file_put_contents("data/user/$fromid.json",$cuser);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
}
elseif ($juser["userfild"]["step"] == "game") {
if($textmassage == true){
         jijibot('sendmessage',[
        	'chat_id'=>$juser["userfild"]["rival"],
        	'text'=>"🌟 درخواست دوستت از شما :			
`$textmassage`

🎈 لطفا پاسخ رو به صورت متن , عکس یا هرچیزی ارسال کن !",
'parse_mode'=>'Markdown',
 ]);
			         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"ارسال شد ✅ 
			
🎈 لطفا منتظر دریافت پاسخ باشید",
 ]);
$userrival = $juser["userfild"]["rival"];
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["step"]="answergame";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
else
{
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"🎈 تنها ارسال متن ممکن است !",
'parse_mode'=>'Markdown',
 ]);
}
}
elseif ($juser["userfild"]["step"] == "answergame") {
$photo = $message->photo;
$filephoto = $photo[count($photo)-1]->file_id;
$voice = $message->voice;
$filevoice = $voice->file_id;
$document = $update->message->document;
$filedocument = $document->file_id;
$sticker = $update->message->sticker;
$filesticker = $sticker->file_id;
$caption = $update->message->caption;
$userrival = $juser["userfild"]["rival"];
         jijibot('sendmessage',[
        	'chat_id'=>$userrival,
        	'text'=>"$textmassage",
 ]);
 jijibot('sendphoto',[
	'chat_id'=>"$userrival",
	'photo'=>$filephoto,
	'caption'=>$caption,
    		]);
			jijibot('senddocument',[
	'chat_id'=>"$userrival",
	'document'=>$filedocument,
	'caption'=>$caption,
    		]);
			jijibot('sendsticker',[
	'chat_id'=>"$userrival",
		'sticker'=>"$filesticker",
    		]);
	jijibot('sendvoice',[
	'chat_id'=>$userrival,
	'voice'=>$filevoice,
		'caption'=>$caption,
    		]);
			         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"ارسال شد ✅",
 ]);
         jijibot('sendmessage',[
        	'chat_id'=>$userrival,
        	'text'=>"👆🏻 پاسخ درخواست شما 👆🏻",
 ]);
			         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
	'text'=>"🎈 منتظر بمانید ربات در حال قرعه انداختن دوباره است ...
	
🔄 در حال پردازش بازی ...",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
	  	]);
jijibot('sendmessage',[
	'chat_id'=>$userrival,
	'text'=>"🎈 منتظر بمانید ربات در حال قرعه انداختن دوباره است ...
	
🔄 در حال پردازش بازی ...",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
		 	  	  	 [
					 ['text'=>"❌ پایان بازی"]                            
		 ],
   ],
      'resize_keyboard'=>true
   ])
    		]);
$array = array("$from_id","$userrival");
$random = array_rand($array);
jijibot('sendmessage',[
	'chat_id'=>$array[$random],
	'text'=>"❓ نوبت شماست که سوال بپرسید

🎈 منتظربمانید تا حریف شما جرئت یا حقیقت رو انتخاب کند",
    		]);
$result = array_diff($array , array($array[$random]));
jijibot('sendmessage',[
	'chat_id'=>$result[0],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
			jijibot('sendmessage',[
	'chat_id'=>$result[1],
	'text'=>"❓ کدام رو انتخاب میکنید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[
	['text'=>"💪🏻 جرات",'callback_data'=>"jorats"],['text'=>"🗣 حقیقت",'callback_data'=>"haghights"]
	],
              ]
        ])
    		]);
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);
$getrival = json_decode(file_get_contents("data/user/$userrival.json"),true);
$getrival["userfild"]["step"]="none";
$getrival = json_encode($getrival,true);
file_put_contents("data/user/$userrival.json",$getrival);
}
elseif ($juser["userfild"]["step"] == 'sup') {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 پیام شما ارسال شد منتظر پاسخ باشید",
               'reply_markup'=>json_encode([
                   'inline_keyboard'=>[
				   [
['text'=>"🔙 برگشت",'callback_data'=>'back']
				   ],
                     ]
               ])
 ]);
jijibot('ForwardMessage',[
'chat_id'=>$Dev[0],
'from_chat_id'=>$chat_id,
'message_id'=>$message_id
]);
}
elseif($data=="startrules"){
 jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
		'text'=>"🔻 قوانین ربات

1️⃣ بعد از عضویت ربات در گروه ، دسترسی ادمین را به ربات بدهید.

2️⃣ ربات $namebot هیچگونه مسئولیتی در قبال استفاده نادرست کاربران از ربات ندارد.

3️⃣ ارسال کلمات نامناسب و غیرمجاز برای بخش 'ثبت جرات و حقیقت' توسط کاربران باعث حذف ربات از گروه شما خواهد شد.

4️⃣ از ارسال درخواست های پی در پی در گروه خودداری کنید.

🆔 کانال اسپانسری ما: @$channel
🆔 کانال اسپانسری ما: @$channel2
",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			  	  		[
	['text'=>"🍾 بازی در گپ",'url'=>"https://telegram.me/$usernamebot?startgroup=playgame"]
	],
			[
	['text'=>"❌ موافق نیستم",'callback_data'=>"cancell"]
	],
              ]
        ])
	  	]);	   
}
elseif($data=="cancell"){
    jijibot('editmessagetext',[
	   'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"سلام $first_name عزیز😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
برای شروع بازی کافیه از دکمه های زیر استفاده کنی تا جرات و حقیقت بازی کنیم

🏵 در صورت نیاز به پشتیبانی از دکمه 'پشتیبانی' استفاده کنید.

🆔 کانال اسپانسری ما: @$channel
🆔 کانال اسپانسری ما: @$channel2
",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
		[
	['text'=>"🍾 بازی در گپ",'callback_data'=>"startrules"]
	,	['text'=>"🎲 بازی با ناشناس",'callback_data'=>"gamerandom"]],
	[
	['text'=>"🎮 بازی دوستانه",'callback_data'=>"gamebylink"],
	],
			[
	['text'=>"🎗 ثبت جرات و حقیقت",'callback_data'=>"sup"],['text'=>"🚦 راهنما",'callback_data'=>"help"]
	],
				[
	['text'=>"🧑🏻‍💻 پشتیبانی",'callback_data'=>"support"],['text'=>"⚔️ بازی های دیگه",'callback_data'=>"othergame"]
	],
              ]
        ])
    		]);
}

elseif($data=="support"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>"لطفا نظر،پیشنهاد و مشکل خود را اِرسال کنید 👇🏻",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
		[
	['text'=>"🔙 برگشت",'callback_data'=>"back"]
	],
              ]
        ])
    		]);
$cuser["userfild"]["step"]="supp";
$cuser = json_encode($cuser,true);
file_put_contents("data/user/$fromid.json",$cuser);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🎈 به ربات جرات و حقیقت خوش آمدید !
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
} 
elseif ($juser["userfild"]["step"] == 'supp') {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 پیام شما ارسال شد منتظر پاسخ باشید",
               'reply_markup'=>json_encode([
                   'inline_keyboard'=>[
				   [
['text'=>"🔙 برگشت",'callback_data'=>'back']
				   ],
                     ]
               ])
 ]);
       jijibot('sendmessage',[
        	'chat_id'=>$Dev[0],
        	'text'=>"💡مدیر  یک پیام با اطلاعات زیر داری:
➖➖➖➖➖
🗣 نام کاربر : $first_name
🔹ایدی کاربر: @$username
▫️ایدی عددی کاربر : $chat_id
➖➖➖➖➖
⚠️ توجه : برای پاسخ روی پیام کاربر ریپلای کنید

📨 متن پیام: 👇🏻👇🏻👇🏻
   ",
'reply_markup'=>json_encode([
                   'inline_keyboard'=>[
				   [
['text'=>"🔙 برگشت",'callback_data'=>'back']
				   ],
                     ]
               ])
 ]);
jijibot('ForwardMessage',[
'chat_id'=>$Dev[0],
'from_chat_id'=>$chat_id,
'message_id'=>$message_id,
               ]);
}
elseif($update->message->reply_to_message && $from_id == $Dev[0] && $tc == "private"){
	jijibot('sendmessage',[
        "chat_id"=>$chat_id,
        "text"=>"پیام شما برای فرد ارسال شد ✔️"
		]);
	jijibot('sendmessage',[
        "chat_id"=>$update->message->reply_to_message->forward_from->id,
        "text"=>"👤 پاسخ پشتیبان برای شما :

`$textmassage`",
'parse_mode'=>'MarkDown'
		]);
}  
elseif($data=="othergame"){
$forchannel = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$from_id"]);
$tch = $forchannel->result->status;
$forchannel2 = jijibot('getChatMember',['chat_id'=>"@$channel2",'user_id'=>"$from_id"]);
$tch2 = $forchannel2->result->status;
if(($tch == 'member' or $tch == 'creator' or $tch == 'administrator')and ($tch2 == 'member' or $tch2 == 'creator' or $tch2 == 'administrator')){
    jijibot('sendmessage',[
	   'chat_id'=>$chatid,
     'message_id'=>$messageid,
'text'=>"
🧨 به بخش بازی های دیگه ربات خوش اومدید؛

✅ تو این ربات میتونی دارت بازی کنی!
✅ تاس بندازی!
✅ پنالتی بزنی!
✅ بسکتبال بازی کنی!

👇 یکی از گزینه های زیر رو انتخاب کن :
",
  'reply_markup'=>json_encode([
       'keyboard'=>[
	 [['text'=>"🎲 تاس بنداز"],['text'=>"⚽️ پنالتی بزن"]],
		  [['text'=>"🏀 بسکتبال بازی کن"],['text'=>"🎯 دارت بازی کن"]],
	[	  ['text'=>"▫️ برگشت به منوی اصلی"]],
              ]
              
        ])
        ,'resize_keyboard'=>true
    		]);
}
else
{
jijibot('editmessagetext',[
                'chat_id'=>$chatid,
     'message_id'=>$messageid,
	'text'=>" کاربر $first_name 😊
	
🌺 لطفا جهت حمایت از ربات و سازنده ابتدا در کانال ما عضو شوید سپس از طریق دکمه عضو شدم ادامه دهید !",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"📍 عضویت در کانال اول",'url'=>"https://t.me/$channel"]
	],
		[
	['text'=>"📍 عضویت در کانال دوم",'url'=>"https://t.me/$channel2"]
	],
		[
	['text'=>"🌟 عضو شدم",'callback_data'=>"join"]
	],
              ]
        ])
    		]);
}
}
//----------------------------------
elseif($textmassage=="🎯 دارت بازی کن"){

$dice = jijibot('sendDice',[
'chat_id' => $chat_id,
'emoji'=> '🎯',
   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "♻️ در حال بازی ...", 'callback_data' => "none"]],                       
                    ]
                ])
]); 
$value = $dice->result->dice->value;
$messageid = $dice->result->message_id;
sleep(2.5);
if($value == 1 or $value == 2 or $value == 3){
$om = "❌ بازیو باختی،امتیاز نگرفتی";
}else{
$om = "🎊 امتیاز بازی : $value";
}
jijibot('editMessageReplyMarkup',[
    'chat_id'=> $chat_id,
    'message_id'=>$messageid,
	   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "$om", 'callback_data' => "none"]],                       
                    ]
                ])
    		]);
}
   elseif($textmassage=="🏀 بسکتبال بازی کن"){
$dice = jijibot('sendDice',[
'chat_id' => $chat_id,
'emoji'=> '🏀',
   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "♻️ در حال بازی ...", 'callback_data' => "none"]],                       
                    ]
                ]) 
]); 
$value = $dice->result->dice->value;
$messageid = $dice->result->message_id;
sleep(7);
if($value == 1 or $value == 2 or $value == 3){
$om = "❌ بازیو باختی،امتیاز نگرفتی";
}else{
$om = "🎊 امتیاز بازی : $value";
}
jijibot('editMessageReplyMarkup',[
    'chat_id'=> $chat_id,
    'message_id'=>$messageid,
	   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "$om", 'callback_data' => "none"]],                       
                    ]
                ])
    		]);
}

          elseif($textmassage=="⚽️ پنالتی بزن"){
$dice = jijibot('sendDice',[
'chat_id' => $chat_id,
'emoji'=> '⚽️',
   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "♻️ در حال پنالتی زدن ...", 'callback_data' => "none"]],                       
                    ]
                ])
]); 
$value = $dice->result->dice->value;
$messageid = $dice->result->message_id;
sleep(7);
if($value == 1 or $value == 2){
$om = "❌ پنالتی باختی،امتیازی نگرفتی";
}else{
$om = "🎊 امتیاز پنالتی : $value";
}
jijibot('editMessageReplyMarkup',[
    'chat_id'=> $chat_id,
    'message_id'=>$messageid,
	   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "$om", 'callback_data' => "none"]],                       
                    ]
                ])
    		]);
}
       elseif($textmassage=="🎲 تاس بنداز"){
$dice = jijibot('sendDice',[
'chat_id' => $chat_id,
'emoji'=> '🎲',
   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "♻️ در حال انداختن تاس ...", 'callback_data' => "none"]],                       
                    ]
                ]) // 
]); // 
$value = $dice->result->dice->value;
$messageid = $dice->result->message_id;
sleep(4);
jijibot('editMessageReplyMarkup',[
    'chat_id'=> $chat_id,
    'message_id'=>$messageid,
	   'reply_markup' => json_encode([
                    'inline_keyboard' => [
    [['text' => "🎲 نتیجه تاس : $value", 'callback_data' => "none"]],                       
                    ]
                ])
    		]);
}
//==============================================================
//panel admin
elseif($textmassage=="/panel" or $textmassage=="panel" or $textmassage=="مدیریت"){
if ($tc == "private") {
if (in_array($from_id,$Dev)){
jijibot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"🚦 ادمین عزیز به پنل مدیریت ربات خوش امدید",
	  'reply_markup'=>json_encode([
       'keyboard'=>[
	  	  	 [
		['text'=>"📍 امار ربات"]             
		 ],
		 		  	[
	  	['text'=>"📍 افزودن حقیقت"],['text'=>"📍 افزودن جرات"]
	  ],
	  [
	  	['text'=>"📍 ارسال به گروه ها"],['text'=>"📍 فوروارد به گروه ها"]
	  ],
 	[
	  	['text'=>"📍 ارسال به کاربران"],['text'=>"📍 فوروارد به کاربران"]
	  ],
   ],
      'resize_keyboard'=>true
   ])
 ]);
}
}
}
elseif($textmassage=="برگشت 🔙"){
if ($tc == "private") {
if (in_array($from_id,$Dev)){
jijibot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"🚦 به منوی مدیریت بازگشتید",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
	  	  	 [
		['text'=>"📍 امار ربات"]             
		 ],
		 		  	[
	  	['text'=>"📍 افزودن حقیقت"],['text'=>"📍 افزودن جرات"]
	  ],
	  [
	  	['text'=>"📍 ارسال به گروه ها"],['text'=>"📍 فوروارد به گروه ها"]
	  ],
 	[
	  	['text'=>"📍 ارسال به کاربران"],['text'=>"📍 فوروارد به کاربران"]
	  ],
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
}
elseif ($textmassage == '📍 ارسال به کاربران' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا متن خود را ارسال کنید 🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="sendtoall";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'sendtoall') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"پیام شما با موفقیت برای ارسال همگانی تنظیم شد  ✔️",
	  'reply_to_message_id'=>$message_id,
 ]);
$inuser = json_decode(file_get_contents("user.json"),true);
$inuser["text"]="$textmassage";
$inuser["sendtoall"]="true";
$inuser = json_encode($inuser,true);
file_put_contents("user.json",$inuser);	
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
elseif ($textmassage == '📍 ارسال به گروه ها' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا متن خود را ارسال کنید 🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="sendtoallgp";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'sendtoallgp') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"پیام شما با موفقیت برای ارسال همگانی تنظیم شد  ✔️",
	  'reply_to_message_id'=>$message_id,
 ]);
$inuser = json_decode(file_get_contents("user.json"),true);
$inuser["text"]="$textmassage";
$inuser["sendtoallgp"]="true";
$inuser = json_encode($inuser,true);
file_put_contents("user.json",$inuser);	
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/$from_id.json",$juser);	
}
}
elseif ($textmassage == '📍 فوروارد به کاربران' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا متن خود را فوروارد کنید  🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="fortoall";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'fortoall') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"پیام شما با موفقیت به عنوان فوروارد همگانی تنظیم شد ✔️",
	  'reply_to_message_id'=>$message_id,
 ]);
$inuser = json_decode(file_get_contents("user.json"),true);
$inuser["msg"]="$message_id";
$inuser["chat"]="$chat_id";
$inuser["fortoall"]="true";
$inuser = json_encode($inuser,true);
file_put_contents("user.json",$inuser);	
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($textmassage == '📍 فوروارد به گروه ها' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا متن خود را فوروارد کنید  🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="fortoallgp";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'fortoallgp') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"پیام شما با موفقیت به عنوان فوروارد همگانی تنظیم شد ✔️",
	  'reply_to_message_id'=>$message_id,
 ]);
$inuser = json_decode(file_get_contents("user.json"),true);
$inuser["msg"]="$message_id";
$inuser["chat"]="$chat_id";
$inuser["fortoallgp"]="true";
$inuser = json_encode($inuser,true);
file_put_contents("user.json",$inuser);	
$juser["userfild"]["step"]="none";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif($textmassage=="📍 امار ربات"){
if (in_array($from_id,$Dev)){
$getuser = scandir("data/user/");
$alluser = count($getuser) - 1;
$getgp = scandir("data/gp/");
$allgp = count($getgp) - 1;
$allhagh1 = count($database["ha"]["normal"]);
$allhagh2 = count($database["ha"]["normal"]["boy"]);
$allhagh3 = count($database["ha"]["normal"]["girl"]);
$alljorat1 = count($database["jo"]["normal"]);
$alljorat2 = count($database["jo"]["plus"]["boy"]);
$alljorat3 = count($database["jo"]["plus"]["girl"]);
				jijibot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"🤖 امار ربات شما : 
		
📍تعداد عضو ها : $alluser
📍تعداد گروه ها : $allgp
📍تعداد جرات ها : $alljorat1 | $alljorat2 | $alljorat3
📍تعداد حقیقت ها : $allhagh1 | $allhagh2 | $allhagh3",
		]);
		}
}
elseif ($textmassage == '📍 افزودن جرات' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا سوال مربوط به جرات را ارسال کنید 🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setju";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'setju') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"ذخیر شد  ✅
			
📍 سوال اضافه شده مربوط ب کدام بخش است ؟
normal  = عادی 
plus = +18",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"normal"],['text'=>"plus"]
	],
			[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setju2";
$juser["userfild"]["qu"]="$textmassage";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
elseif ($juser["userfild"]["step"] == 'setju2') {
$qu = $juser["userfild"]["qu"];
if ($textmassage != "برگشت 🔙") {
if ($textmassage == "normal") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"با موفقیت اضافه شد  ✅
			
📍 در صورتی که میخواهید سوال جرات دیگری رو اضافه کنید ان را ارسال کنید",
 ]);
$database["jo"]["normal"][]="$qu";
$database = json_encode($database,true);
file_put_contents("data/database.json",$database);
$juser["userfild"]["step"]="setju";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
if ($textmassage == "plus") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 مربوط ب کدام جنسیت ؟ 
boy  = دختر 
girl = پسر",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"boy"],['text'=>"girl"]
	],
		[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setju3";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
}
elseif ($juser["userfild"]["step"] == 'setju3') {
$qu = $juser["userfild"]["qu"];
if ($textmassage != "برگشت 🔙") {
if ($textmassage == "boy" or $textmassage == "girl") {
$stats = $juser["userfild"]["stats"];
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"با موفقیت اضافه شد  ✅
			
📍 در صورتی که میخواهید سوال جرات دیگری رو اضافه کنید ان را ارسال کنید",
 ]);
$database["jo"]["plus"]["$textmassage"][]="$qu";
$database = json_encode($database,true);
file_put_contents("data/database.json",$database);
$juser["userfild"]["step"]="setju";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
}
elseif ($textmassage == '📍 افزودن حقیقت' ) {
if (in_array($from_id,$Dev)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"لطفا سوال مربوط به حقیقت رو ارسال کنید 🚀",
	  'reply_to_message_id'=>$message_id,
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setha";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
}
elseif ($juser["userfild"]["step"] == 'setha') {
if ($textmassage != "برگشت 🔙") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"ذخیر شد  ✅
			
📍 سوال اضافه شده مربوط ب کدام بخش است ؟
normal  = عادی 
plus = +18",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"normal"],['text'=>"plus"]
	],
			[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setha2";
$juser["userfild"]["qu"]="$textmassage";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
elseif ($juser["userfild"]["step"] == 'setha2') {
$qu = $juser["userfild"]["qu"];
if ($textmassage != "برگشت 🔙") {
if ($textmassage == "normal") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"با موفقیت اضافه شد  ✅
			
📍 در صورتی که میخواهید سوال جرات دیگری رو اضافه کنید ان را ارسال کنید",
 ]);
$database["ha"]["normal"][]="$qu";
$database = json_encode($database,true);
file_put_contents("data/database.json",$database);
$juser["userfild"]["step"]="setha";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);		
}
if ($textmassage == "plus") {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 مربوط ب کدام جنسیت ؟ 
boy  = دختر 
girl = پسر",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[
	['text'=>"boy"],['text'=>"girl"]
	],
		[
	['text'=>"برگشت 🔙"] 
	]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$juser["userfild"]["step"]="setha3";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}
}

elseif ($juser["userfild"]["step"] == 'setha3') {
$qu = $juser["userfild"]["qu"];
if ($textmassage != "برگشت 🔙") {
if ($textmassage == "boy" or $textmassage == "girl") {
$stats = $juser["userfild"]["stats"];
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"با موفقیت اضافه شد  ✅
			
📍 در صورتی که میخواهید سوال جرات دیگری رو اضافه کنید ان را ارسال کنید",
 ]);
$database["ha"]["plus"]["$textmassage"][]="$qu";
$database = json_encode($database,true);
file_put_contents("data/database.json",$database);
$juser["userfild"]["step"]="setha";
$juser = json_encode($juser,true);
file_put_contents("data/user/$from_id.json",$juser);	
}
}

}
?>
