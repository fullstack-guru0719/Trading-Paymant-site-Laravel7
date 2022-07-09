<?php

use App\Lib\SendSms;
use App\Models\EmailLog;
use App\Models\GeneralSetting;
use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


function systemDetails()
{
    $system['name'] = 'hyiplab';
    $system['version'] = '2.1';
    return $system;
}

function getLatestVersion()
{
    $result = '{"version":"2.1"}';
    if ($result) {
        return $result;
    } else {
        return null;
    }
}

function getTemplates()
{
	
        return null;
}


function get_image($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset('assets/images/default.png');
}


function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}


function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}


function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }


    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();


    $image = Image::make($file);


    if (!empty($size)) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1]);
    }
    $image->save($location . '/' . $filename);

    if (!empty($thumb)) {

        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }

    return $filename;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}


function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function activeTemplate($asset = false)
{
    $gs = GeneralSetting::first(['active_template']);

    $template = $gs->active_template;

    $sess = session()->get('templates');
    if (trim($sess) != null) {
        $template = $sess;
    }
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}


function activeTemplateName()
{
    $gs = GeneralSetting::first(['active_template']);
    $template = $gs->active_template;
    $sess = session()->get('template');
    if (trim($sess) != null) {
        $template = $sess;
    }
    return $template;
}


function reCaptcha()
{
    $reCaptcha = \App\Models\Plugin::where('act', 'google-recaptcha2')->where('status', 1)->first();
    return $reCaptcha ? $reCaptcha->generateScript() : '';
}

function analytics()
{
    $reCaptcha = \App\Models\Plugin::where('act', 'google-analytics')->where('status', 1)->first();
    return $reCaptcha ? $reCaptcha->generateScript() : '';
}

function fbComment()
{
    $fbComment = \App\Models\Plugin::where('act', 'fb-comment')->where('status', 1)->first();
    return $fbComment ? $fbComment->generateScript() : '';
}

function tawkto()
{
    $reCaptcha = \App\Models\Plugin::where('act', 'tawk-chat')->where('status', 1)->first();
    return $reCaptcha ? $reCaptcha->generateScript() : '';
}


function getCustomCaptcha($height = 46, $width = '100%', $bgcolor = '#003', $textcolor = '#abc')
{
    $captcha = \App\Models\Plugin::where('act', 'custom-captcha')->where('status', 1)->first();
    $gnl = \App\Models\GeneralSetting::first();
    $textcolor = '#'.$gnl->base_color;

    $code = rand(100000, 999999);
    $char = str_split($code);
    $ret = '<link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">';
    $ret .= '<div style="height: ' . $height . 'px; line-height: ' . $height . 'px; width:' . $width . '; text-align: center; background-color: ' . $bgcolor . '; color: ' . $textcolor . '!important; font-size: ' . ($height - 20) . 'px; font-weight: bold; letter-spacing: 20px; font-family: \'Henny Penny\', cursive;  -webkit-user-select: none; -moz-user-select: none;-ms-user-select: none;user-select: none;  display: flex; justify-content: center;" class="captcha">';
    foreach ($char as $value) {
        $ret .= '<span style="    float:left;     -webkit-transform: rotate(' . rand(-60, 60) . 'deg);">' . $value . '</span>';
    }
    $ret .= '</div>';
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    $ret .= '<input type="hidden" name="captcha_secret" value="' . $captchaSecret . '">';
    return $ret;
}


function captchaVerify($code, $secret)
{
    $captcha = \App\Models\Plugin::where('act', 'custom-captcha')->where('status', 1)->first();
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    if ($captchaSecret == $secret) {
        return true;
    }
    return false;
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function currency()
{
    $data['crypto'] = 8;
    $data['fiat'] = 2;
    return $data;
}


function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return number_format($amount + 0, $length);
    }
    return $amount + 0;
}

function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet, $amount, $crypto = null)
{

    $varb = $wallet . "?amount=" . $amount;
    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
}

function curlContent($url)
{
    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
}


function curlPostContent($url, $arr = null)
{
    if ($arr) {
        $params = http_build_query($arr);
    } else {
        $params = '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function str_slug($title = null)
{
    return \Illuminate\Support\Str::slug($title);
}

function str_limit($title = null, $length = 10)
{
    return \Illuminate\Support\Str::limit($title, $length);
}


function getIpInfo()
{
    $ip = Null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}


function site_name()
{
    $general = GeneralSetting::first();
    $sitname = str_word_count($general->sitename);
    $sitnameArr = explode(' ', $general->sitename);
    if ($sitname > 1) {
        $title = "<span>$sitnameArr[0] </span> " . str_replace($sitnameArr[0], '', $general->sitename);
    } else {
        $title = "<span>$general->sitename</span>";
    }

    return $title;
}


function getPageSections($arr = false)
{
    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}


function getImage($image,$size = null)
{
    $clean = '';
    $size = $size ? $size : 'undefined';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }else{
        return route('placeholderImage',$size);
    }
}


function notify($user, $type, $shortCodes = null)
{
    send_email($user, $type, $shortCodes);
    send_sms($user, $type, $shortCodes);
}

function send_sms($user, $type, $shortCodes = [])
{
    $general = GeneralSetting::first();
    $smsTemplate = SmsTemplate::where('act', $type)->where('sms_status', 1)->first();
    $gateway = $general->sms_config->name;
    $sendSms = new SendSms;
    if ($general->sn == 1 && $smsTemplate) {
        $template = $smsTemplate->sms_body;
        foreach ($shortCodes as $code => $value) {
            $template = shortCodeReplacer('{{' . $code . '}}', $value, $template);
        }
        $message = shortCodeReplacer("{{message}}", $template, $general->sms_api);
        $message = shortCodeReplacer("{{name}}", $user->username, $message);
        $sendSms->$gateway($user->mobile,$general->sitename,$message,$general->sms_config);
    }
}

function send_email($user, $type = null, $shortCodes = [])
{
    $general = GeneralSetting::first();

    $email_template = \App\Models\EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    if ($general->en != 1 || !$email_template) {
        return;
    }

    $message = shortCodeReplacer("{{name}}", $user->username, $general->email_template);
    $message = shortCodeReplacer("{{message}}", $email_template->email_body, $message);

    if (empty($message)) {
        $message = $email_template->email_body;
    }

    foreach ($shortCodes as $code => $value) {
        $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    }

    $config = $general->mail_config;

    $emailLog = new EmailLog();
    $emailLog->user_id = $user->id;
    $emailLog->mail_sender = $config->name;
    $emailLog->from = $general->sitename.' '.$general->email_from;
    $emailLog->to = $user->email;
    $emailLog->subject = $email_template->subj;
    $emailLog->message = $message;
    $emailLog->save();


    if ($config->name == 'php') {
        send_php_mail($user->email, $user->username, $general->email_from, $email_template->subj, $message, $general);
    } else if ($config->name == 'smtp') {
        send_smtp_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    } else if ($config->name == 'sendgrid') {
        send_sendGrid_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    } else if ($config->name == 'mailjet') {
        send_mailjet_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    }
}


function send_php_mail($receiver_email, $receiver_name, $sender_email, $subject, $message, $general)
{
    $headers = "From: $general->sitename <$general->email_from> \r\n";
    $headers .= "Reply-To: $general->sitename <$general->email_from> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail($receiver_email, $subject, $message, $headers);
}


function send_smtp_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{

    $general = GeneralSetting::first();
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->enc == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($general->email_from, $general->sitetitle);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($general->email_from, $general->sitename);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e); 
    }
}


function send_sendGrid_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $sendgridMail = new \SendGrid\Mail\Mail();
    $sendgridMail->setFrom($sender_email, $sender_name);
    $sendgridMail->setSubject($subject);
    $sendgridMail->addTo($receiver_email, $receiver_name);
    $sendgridMail->addContent("text/html", $message);
    $sendgrid = new \SendGrid($config->appkey);
    try {
        $response = $sendgrid->send($sendgridMail);
    } catch (Exception $e) {
        // echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}


function send_mailjet_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $mj = new \Mailjet\Client($config->public_key, $config->secret_key, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $sender_email,
                    'Name' => $sender_name,
                ],
                'To' => [
                    [
                        'Email' => $receiver_email,
                        'Name' => $receiver_name,
                    ]
                ],
                'Subject' => $subject,
                'TextPart' => "",
                'HTMLPart' => $message,
            ]
        ]
    ];
    $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
}


function getPaginate($paginate = 20)
{
    return $paginate;
}


function menuActive($routeName, $type = null)
{
    if ($type == 3) {
        $class = 'side-menu--open';
    } elseif ($type == 2) {
        $class = 'sidebar-submenu__open';
    } else {
        $class = 'active';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function imagePath()
{
    $data['promotions'] = [
        'path' => 'assets/images/promotions',
    ];
    $data['gateway'] = [
        'path' => 'assets/images/gateway',
        'size' => '800x800',
    ];
    $data['verify'] = [
        'withdraw' => [
            'path' => 'assets/images/verify/withdraw'
        ],
        'deposit' => [
            'path' => 'assets/images/verify/deposit'
        ]
    ];
    $data['image'] = [
        'default' => 'assets/images/default.png',
    ];
    $data['withdraw'] = [
        'method' => [
            'path' => 'assets/images/withdraw/method',
            'size' => '800x800',
        ]
    ];

    $data['ticket'] = [
        'path' => 'assets/images/support',
    ];
    $data['language'] = [
        'path' => 'assets/images/lang',
        'size' => '64x64'
    ];
    $data['logoIcon'] = [
        'path' => 'assets/images/logoIcon',
    ];
    $data['favicon'] = [
        'size' => '128x128',
    ];
    $data['plugin'] = [
        'path' => 'assets/images/plugin',
    ];

    $data['profile'] = [
        'user'=> [
            'path'=>'assets/images/user/profile',
            'size'=>'350x300'
        ],
        'path' => 'assets/images/user/profile',
    ];
    $data['seo'] = [
        'path' => 'assets/images/seo',
        'size' => '600x315'
    ];
    return $data;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'd M, Y h:i A')
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->translatedFormat($format);
}


function send_general_email($email, $subject, $message, $receiver_name = '')
{

    $general = GeneralSetting::first();


    if ($general->en != 1 || !$general->email_from) {
        return;
    }


    $message = shortCodeReplacer("{{message}}", $message, $general->email_template);
    $message = shortCodeReplacer("{{name}}", $receiver_name, $message);

    $config = $general->mail_config;


    if ($config->name == 'php') {
        send_php_mail($email, $receiver_name, $general->email_from, $subject, $message, $general);
    } else if ($config->name == 'smtp') {
        send_smtp_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    } else if ($config->name == 'sendgrid') {
        send_sendgrid_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    } else if ($config->name == 'mailjet') {
        send_mailjet_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    }
}

if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();
        $escaped = preg_quote('=' . env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function getContent($data_keys, $singleQuery = false, $limit = null,$orderById = false)
{
    if ($singleQuery) {
        $content = \App\Models\Frontend::where('data_keys', $data_keys)->latest()->first();
    } else {
        $article = \App\Models\Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if($orderById){
        $content = $article->where('data_keys', $data_keys)->orderBy('id')->get();
    }else{
        $content = $article->where('data_keys', $data_keys)->latest()->get();
    }
    }
    return $content;
}


function levelCommission($id, $amount, $commissionType = '')
{
    $usr = $id;
    $user = \App\Models\User::find($id);
    $i = 1;
    $gnl = GeneralSetting::first();

    $level = \App\Models\Referral::where('commission_type',$commissionType)->count();

    while ($usr != "" || $usr != "0" || $i < $level) {
        $me = \App\Models\User::find($usr);
        $refer = \App\Models\User::find($me->ref_by);

        if ($refer == "") {
            break;
        }
        $commission = \App\Models\Referral::where('commission_type',$commissionType)->where('level', $i)->first();
        if (!$commission) {
            break;
        }
        $com = ($amount * $commission->percent) / 100;


        $referWallet = $refer;
        $new_bal = getAmount($referWallet->interest_wallet + $com);
        $referWallet->interest_wallet = $new_bal;
        $referWallet->save();

        $trx = getTrx();


        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $refer->id;
        $transaction->amount = getAmount($com);
        $transaction->post_balance = $new_bal;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details =' level '.$i.' Referral Commission From ' . $user->username;
        $transaction->trx = $trx;
        $transaction->wallet_type =  'interest_wallet';
        $transaction->save();


        $commissionLog = new \App\Models\CommissionLog();
        $commissionLog->to_id = $refer->id;
        $commissionLog->from_id = $id;
        $commissionLog->level = $i;
        $commissionLog->commission_amount = getAmount($com);
        $commissionLog->main_amo = $new_bal;
        $commissionLog->trx_amo = $amount;
        $commissionLog->title ='level '.$i.' Referral Commission From ' . $user->username;
        $commissionLog->type = $commissionType;
        $commissionLog->percent = $commission->percent;
        $commissionLog->trx = $trx;
        $commissionLog->save();

        notify($refer, $type = 'REFERRAL_COMMISSION', [
            'amount' => getAmount($com),
            'main_balance' => $new_bal,
            'trx' => $trx,
            'level' => $i . ' level Referral Commission',
            'currency' => $gnl->cur_text
        ]);

        $usr = $refer->id;
        $i++;
    }
    return 0;
}


function showBelowUser($id)
{
    $under_ref = \App\Models\User::where('ref_by', $id)->get();
    $print = array();
    $i = 2;
    foreach ($under_ref as $data) {
        $cc = \App\Models\User::where('ref_by', $data->id)->count();
        echo "<li class=\"container\">";
        echo '<p>' . $print[] = $data->username . '</p>';
        if ($cc > 0) {
            echo '<ul>';
            echo '<li class="container">';
            echo '<p>' . $print[] = showBelowUser($data->id) . '</p>';
            echo '</li>';
            echo '</ul>';
        }
        echo "</li>";
        $i++;
    }
}


function adminShowBelowUser($id)
{
    $under_ref = \App\Models\User::where('ref_by', $id)->get();
    $print = array();
    $i = 2;
    foreach ($under_ref as $data) {
        $cc = \App\Models\User::where('ref_by', $data->id)->count();
        echo "<li class=\"container\">";
        echo '<a href="' . route('admin.users.detail', $data->id) . '">' . $print[] = $data->username . '</a>';
        if ($cc > 0) {
            echo '<ul>';
            echo '<li class="container">';
            echo '<a href="' . route('admin.users.detail', $data->id) . '">' . $print[] = adminShowBelowUser($data->id) . '</a>';
            echo '</li>';
            echo '</ul>';
        }
        echo "</li>";
        $i++;
    }
}


function gatewayRedirectUrl()
{
    
        return 'user.deposit';
}

/*
 * last Time $date1
 * next time  $date2
 * $last_time, $next_time
 */
function diffDatePercent($start , $end)
{
    $start = strtotime($start);
    $end = strtotime($end);


    $diff = $end - $start;

    $current = time();
    $cdiff = $current - $start;

    if ($cdiff > $diff) {
        $percentage = 1.0;
    }
    else if ($current < $start) {
        $percentage = 0.0;
    }
    else {
        $percentage = $cdiff / $diff;
    }

    return sprintf('%.2f%%', $percentage * 100);

    /*
    if($last_time == null){
        $last_time = time();
    }
    $date1 = strtotime($last_time);
    $date2 = strtotime($next_time);
    $today = time();
    if ($today < $date1){
        $percentage = 0;
    }else if ($today > $date2){
        $percentage = 100;
    }else{
        $percentage = ($date2 - $today) * 100 / ($date2 - $date1);
    }
    return round($percentage,2);
    */
}


function showUserLevel($id, $level)
{

    $myref = showBelow($id);
    $nxt = $myref;
    for ($i = 1; $i < $level; $i++) {
        $nxt = array();
        foreach ($myref as $uu) {
            $n = showBelow($uu);
            $nxt = array_merge($nxt, $n);
        }
        $myref = $nxt;
    }
    foreach ($nxt as $key => $uu) {
        $key += 1;
        $general = GeneralSetting::first(['cur_text']);
        $data = \App\Models\User::where('id', $uu)->first();
        echo " <tr>";
        echo ' <td data-label="S.L">'.$key.'</td>';
        echo ' <td data-label="Fullname">'.$data->fullname.'</td>';
        echo ' <td data-label="Joined At">'.showDateTime($data->created_at).'</td>';
        echo "</tr>";
    }
}

function showBelow($id)
{
    $arr = array();
    $under_ref = \App\Models\User::where('ref_by', $id)->get();
    foreach ($under_ref as $u) {
        array_push($arr, $u->id);
    }
    return $arr;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function uploadFile($file, $location, $size = null, $old = null){
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if ($old) {
        removeFile($location . '/' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $file->move($location,$filename);
    return $filename;
}

function urlPath($routeName,$routeParam=null){
    if($routeParam == null){
        $url = route($routeName);
    } else {
        $url = route($routeName,$routeParam);
    }
    $basePath = route('home');
    $path = str_replace($basePath,'',$url);
    return $path;
}