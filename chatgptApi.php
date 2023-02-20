<?php

 /**
  * 本插件作者为吃猫的鱼
  * 为开源插件，未经许可，不允许任何个体/企业对其进行二次开发/售卖！
  */
// 判断调用来路
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');

$num = strpos(str_replace('https://','',str_replace('http://','',$_SERVER['HTTP_REFERER'])),'/admin/write-post.php');
$get_url = substr(str_replace('https://','',str_replace('http://','',$_SERVER['HTTP_REFERER'])),0,$num);
if(!isset($_SERVER['HTTP_REFERER'])|| strcmp($get_url,$_SERVER['HTTP_HOST'])!=0) {
        echo '不支持外部调用！'.$_SERVER['HTTP_REFERER'];
        exit();
}
$text=$_GET['text'];
$id=$_GET['id'];
$key=$_GET['apikey'];
if($_GET['apikey']==""){
  $result = array(
      'code'=> 200,
      'msg'=>"0",
  );
  echo json_encode($result,320);
  exit();
}
function str_re($str){
  $str = str_replace(' ', "", $str);
  $str = str_replace("\n", "", $str);
  $str = str_replace("\t", "", $str);
  $str = str_replace("\r", "", $str);
  return $str;
}
if($id==1){
session_start();
if (!$_SESSION['chatgptSessionPrompt']) {
        $_SESSION['chatgptSessionPrompt'] = '';
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$prompt=$_SESSION['chatgptSessionPrompt'] .'\n提问:' . $text . '\n Ai:';
$chatgptaray=array('\n提问:','\nAI:');
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{
  "model": "text-davinci-003",
  "prompt": "'.$prompt.'",
  "max_tokens": 2048
}');
curl_setopt($ch, CURLOPT_POST, 1);
// Set the API key as an HTTP header
$headers = array();
$headers[] = "Content-Type: application/json";
$headers[] = "Authorization: Bearer ".$key;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Send the request and parse the response
$response = curl_exec($ch);
$response_data = json_decode($response, true);
$_SESSION['chatgptSessionPrompt'] = $prompt . $response_data['data'];
// echo($response);
if (curl_errno($ch)) {
  // If there was an error executing the cURL request, print it out
  echo 'Error: ' . curl_error($ch);
} else {

  $result = array(
      'code'=> 200,
      'msg'=>"获取成功",
      'data'=>array(
          'html'=> $response_data['choices'][0]['text'],
          'title'=>$text
      ),
  );
  echo json_encode($result,320);
  exit();
  
}
curl_close($ch);
}
if($id==2){
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/images/generations");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{
  "n": 1,
  "prompt": "'.$text.'",
  "size": "256x256"
}');
curl_setopt($ch, CURLOPT_POST, 1);
 
// Set the API key as an HTTP header
$headers = array();
$headers[] = "Content-Type: application/json";
$headers[] = "Authorization: Bearer ".$key;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Send the request and parse the response
$response = curl_exec($ch);
$response_data = json_decode($response, true);

if (curl_errno($ch)) {
  // If there was an error executing the cURL request, print it out
  echo 'Error: ' . curl_error($ch);
} else {

  $result = array(
      'code'=> 200,
      'msg'=>"获取成功",
      'data'=>array(
          'url'=> $response_data['data'][0]['url'],
          'title'=>$text
      ),
  );
  echo json_encode($result,320);
  exit();
  
}
curl_close($ch);
}
if($id==3){
session_start();
if (!$_SESSION['chatgptSessionPrompt']) {
        $_SESSION['chatgptSessionPrompt'] = '';
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/dashboard/billing/credit_grants");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 
// Set the API key as an HTTP header
$headers = array();
$headers[] = "Content-Type: application/json";
$headers[] = "Authorization: Bearer ".$key;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Send the request and parse the response
$response = curl_exec($ch);
$response_data = json_decode($response, true);
$_SESSION['chatgptSessionPrompt'] = $prompt . $response_data['id'];
// echo($response);
if (curl_errno($ch)) {
  // If there was an error executing the cURL request, print it out
  echo 'Error: ' . curl_error($ch);
} else {

  $result = array(
      'code'=> 200,
      'msg'=>"获取成功",
      'data'=>array(
          'html'=> $response_data['total_available'],
      ),
  );
  echo json_encode($result,320);
  exit();
  
}
curl_close($ch);   
}
?>