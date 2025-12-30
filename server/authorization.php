<?php

include 'database.php';

function secureInput($input)
{
    $input = trim($input);
    $input = strip_tags($input);
    $input = addslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function passwordHash($password)
{
    $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
    $output = hash_hmac('md5', $password, $salt);
    return $output;
}

$action = secureInput($_POST['action']);

if ($action === "register") {
    $username = secureInput($_POST['username']);
    $email = secureInput($_POST['email']);
    $secretAnswer = secureInput($_POST['secretAnswer']);
    $password = secureInput($_POST['password']);
    $question = secureInput($_POST['question']);

    $register_date = date('d.m.y H:i');

    if (empty($username) || empty($email) || empty($secretAnswer) || empty($password)) {
        $response = array(
            'status' => 'error',
            'message' => 'Lütfen tüm alanları doldurun.'
        );
        echo json_encode($response);
        exit();
    }
    $stmt = $db->prepare("SELECT COUNT(*) FROM accounts WHERE username = :username");
    $stmt->bindParam(':username', base64_encode($secretAnswer));
    $stmt->execute();
    if ($secretAnswer != "adilemre2024" && $secretAnswer != "adilemre" && $stmt->fetchColumn() == 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Referans numarası eşleşmiyor veya böyle bir kullanıcı bulunmuyor.'
        );
        echo json_encode($response);
        exit();
    }

    if (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED'])) $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED'])) $ip = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = 'Bilinmiyor';

    $stmt = $db->prepare("SELECT COUNT(*) FROM accounts WHERE ip = :username");
    $stmt->bindParam(':username', $ip);
    $stmt->execute();
    if ($stmt->fetchColumn() > 500) {
        $response = array(
            'status' => 'error',
            'message' => 'Bu IP ile zaten fazlasıyla hesap açılmış, lütfen farklı bir IP adresi ile deneyin.'
        );
        echo json_encode($response);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'status' => 'error',
            'message' => 'Geçerli bir e-posta adresi girin.'
        );
        echo json_encode($response);
        exit();
    }

    $stmt = $db->prepare("SELECT COUNT(*) FROM accounts WHERE username = :username");
    $stmt->bindParam(':username', base64_encode($username));
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Bu kullanıcı adı zaten kullanılıyor. Lütfen farklı bir kullanıcı adı seçin.'
        );
        echo json_encode($response);
        exit();
    }

    $stmt = $db->prepare("SELECT COUNT(*) FROM accounts WHERE email = :email");
    $stmt->bindParam(':email', base64_encode($email));
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Bu e-posta adresi zaten kullanılıyor. Lütfen farklı bir e-posta adresi seçin.'
        );
        echo json_encode($response);
        exit();
    }

    $systemquery = $db->query("SELECT * FROM `systems`");
    while ($systemdata = $systemquery->fetch()) {
        $confirmationSystem = $systemdata['confirmationSystem'];
    }

    $hashedPassword = passwordHash($password);
    $generateHash = strtoupper(sha1($password) . md5(rand(11111, 99999)));
    $confirmed = $confirmationSystem == "yes" ? "false" : "true";
    $hide_username = "false";
    $access_level = $confirmationSystem == "yes" ? "0" : "1";
    $exp = 0;
    $cookie = "";

    // Get user IP
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ip = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = 'Bilinmiyor';

    $DateTimeNow = date('Y-m-d H:i:s');

    // Insert user into the database
    $stmt = $db->prepare("INSERT INTO accounts (username, email, secret_answer, password, hash, confirmed, access_level, secret_question, ip, hide_username, exp, cookie, register_date, last_login_time) 
    VALUES (:username, :email, :secretAnswer, :password, :hash, :confirmed, :access_level, :secret_question, :ip, :hide_username, :exp, :cookie, :register_date, :last_login_time)");
    $stmt->bindParam(':username', base64_encode($username));
    $stmt->bindParam(':email', base64_encode($email));
    $stmt->bindParam(':secretAnswer', $secretAnswer);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':hash', $generateHash);
    $stmt->bindParam(':confirmed', $confirmed);
    $stmt->bindParam(':access_level', $access_level);
    $stmt->bindParam(':secret_question', $question);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':hide_username', $hide_username);
    $stmt->bindParam(':exp', $exp);
    $stmt->bindParam(':cookie', $cookie);
    $stmt->bindParam(':register_date', $register_date);
    $stmt->bindParam(':last_login_time', $DateTimeNow);
    $stmt->execute();

    $response = array(
        'status' => 'success',
        'message' => 'Kayıt başarıyla tamamlandı.'
    );
    echo json_encode($response);
    exit();
}

if ($action === "password") {
    $email = secureInput($_POST['email']);
    $secretAnswer = secureInput($_POST['secretAnswer']);
    $newPassword = secureInput($_POST['newPassword']);
    $get_new_password = passwordHash($newPassword);

    if (empty($email) || empty($secretAnswer) || empty($newPassword)) {
        $response = array(
            'status' => 'error',
            'message' => 'Lütfen tüm alanları doldurun.'
        );
        echo json_encode($response);
        exit();
    }

    $stmt = $db->prepare("SELECT * FROM accounts WHERE email = :email");
    $stmt->bindParam(':email', base64_encode($email));
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response = array(
            'status' => 'error',
            'message' => 'Bu e-posta adresine ait bir kullanıcı bulunamadı.'
        );
        echo json_encode($response);
        exit();
    }

    $email2 = base64_encode($email);
    $query = $db->query("SELECT * FROM `accounts` WHERE email = '$email2'");
    while ($data = $query->fetch()) {
    $usernamecheck = base64_decode($data['username']);
    }

    if ($secretAnswer != $usernamecheck) {
        $response = array(
            'status' => 'error',
            'message' => 'Kullanıcı adı ile mail adresi birbirine uyuşmuyor.'
        );
        echo json_encode($response);
        exit();
    }



    $stmt = $db->prepare("UPDATE accounts SET password = :get_new_password WHERE email = :email");
    $stmt->bindParam(':get_new_password', $get_new_password);
    $stmt->bindParam(':email', base64_encode($email));

    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Şifreniz başarıyla değiştirilmiştir.'
        );
        echo json_encode($response);
        exit();
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Şifre güncelleme hatası oluştu.'
        );
        echo json_encode($response);
        exit();
    }
}

if ($action === "login") {
    $email = secureInput($_POST['email']);
    $password = secureInput($_POST['password']);

    $hashedPassword = passwordHash($password);

    $sql = $db->query("SELECT * FROM systems");
    while ($data = $sql->fetch()) {
        $multi = $data['multiSystem'];
    }

    if (empty($email) || empty($password)) {
        $response = array(
            'status' => 'error',
            'message' => 'Lütfen tüm alanları doldurun.'
        );
        echo json_encode($response);
        exit();
    }

    $stmt = $db->prepare("SELECT * FROM accounts WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', base64_encode($email));
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {

        $b64_email = base64_encode($email);

        $checkEmail = $db->query("SELECT * FROM `accounts` WHERE email = '$b64_email'");
        $emailCount = $checkEmail->rowCount();

        while ($emailData = $checkEmail->fetch()) {
            $failed_login_count = $emailData['failed_login_count'];
        }
        if ($emailCount == 1) {
            $new_count = $failed_login_count + 1;
            $update = $db->prepare("UPDATE `accounts` SET failed_login_count = :failed_login_count WHERE email = :email");
            $update->bindParam(':failed_login_count', $new_count);
            $update->bindParam(':email', $b64_email);
            $update->execute();
        }

        $response = array(
            'status' => 'error',
            'message' => 'Geçersiz e-posta veya şifre.'
        );
        echo json_encode($response);
        exit();
    } else if ($user['access_level'] == "-1") {
        $response = array(
            'status' => 'error',
            'message' => 'Hesabınız süresiz olarak yasaklanmıştır.'
        );
        echo json_encode($response);
        exit();
    } else {
        if ($user['confirmed'] == "false") {
            $suspect_login_count = $user['suspect_login_count'] + 1;
            $update = $db->prepare("UPDATE `accounts` SET suspect_login_count = :suspect_login_count WHERE hash = :hash");
            $update->bindParam(':suspect_login_count', $suspect_login_count);
            $update->bindParam(':hash', $user['hash']);
            $update->execute();

            $response = array(
                'status' => 'error',
                'message' => 'Giriş yapabilmek için hesabınızın yönetici tarafından onaylanması gerekmektedir.'
            );
            echo json_encode($response);
            exit();
        } else {

            if ($multi == "yes" && $user['access_level'] < 6) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Sistem şu anda bakım modundadır. Lütfen daha sonra tekrar deneyin.'
                );
                echo json_encode($response);
                exit();
            }

            $response = array(
                'status' => 'success',
                'message' => 'Giriş işlemi başarıyla tamamlandı!'
            );
            echo json_encode($response);

            $GenerateCookie = strtoupper(md5(sha1(rand(111111, 999999))));

            $GetCookie = base64_decode($_COOKIE['cf_rtdsid']);

            if ($user['cookie'] == "") {
                $Token = $user['hash'];
                $update2 = $db->exec("UPDATE accounts SET cookie = '$GenerateCookie' WHERE hash = '$Token'");
                setcookie("cf_rtdsid", base64_encode($GenerateCookie), time() + (31556926 * 30), "/");
            }

            function getUserBrowser()
            {
                $userAgent = $_SERVER['HTTP_USER_AGENT'];
                $browsers = array(
                    'Google Chrome' => 'Chrome',
                    'Firefox' => 'Firefox',
                    'Safari' => 'Safari',
                    'Microsoft Edge' => 'Edge',
                    'Opera' => 'Opera',
                    'Internet Explorer' => 'MSIE|Trident',
                );
                foreach ($browsers as $browser => $pattern) {
                    if (preg_match('/\b(' . $pattern . ')\b/i', $userAgent)) {
                        return $browser;
                    }
                }
                return 'Bilinmeyen Tarayıcı';
            }

            $login_time = date('d.m.Y H:i');

            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ip = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ip = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ip = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ip = $_SERVER['REMOTE_ADDR'];
            else
                $ip = 'Bilinmiyor';

            function getrealsystem()
            {
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
                    '/android/i' => 'Android Device',
                    '/blackberry/i' => 'BlackBerry',
                    '/webos/i' => 'Mobile Device'
                );

                foreach ($os_array as $regex => $value)
                    if (preg_match($regex, $user_agent))
                        $os_platform = $value;

                return $os_platform;
            }

            $record_username = base64_decode($user['username']);

            function rastgeleMesaj()
            {
                $mesajlar = array(
                    "giriş yaptı. hoşgeldin kirve, safalar getirdin.",
                    "giriş yaptı. parası biten geliyor.",
                    "giriş yaptı. geldi yine tipine sıçtığım. götüme kaş göz çizsem senden yakışıklı olur.",
                    "giriş yaptı. kahreden haber ramazan evinde canlı bulundu.",
                    "giriş yaptı. kahreden haber musab evinde canlı bulundu.",
                    "giriş yaptı. YİNE KİMLE FLÖRT OLDUN CANKURTARAN",
                    "giriş yaptı. yarrakım kadar özlemişim seni.",
                    "giriş yaptı. pezevenk de geldi, şimdi tam kadroyuz.",
                    "giriş yaptı. ulan sen daha ölmedin mi?",
                    "giriş yaptı. fakirler online oldu beyler!",
                );
                $rastgeleIndex = array_rand($mesajlar);
                return $mesajlar[$rastgeleIndex];
            }

            $rasgeleMesaj = rastgeleMesaj();

            $recordsql = "INSERT INTO records (message, icon, user_hash, hour) VALUES (:message, :icon, :user_hash, :hour)";
            $record = $db->prepare($recordsql);

            // $record_username ve $rasgeleMesaj arasına bir boşluk ekleyin ve bindValue kullanın
            $record_message = $record_username . ' ' . $rasgeleMesaj;

            $record->bindValue(':message', $record_message);
            $record->bindValue(':icon', "fa fa-sign-in");
            $record->bindValue(':user_hash', $user['hash']);
            $record->bindValue(':hour', date('H:i'));
            $record->execute();


            $sql = "INSERT INTO login_sessions (hash, device, ip_class, login_time, operating_system) VALUES (:hash, :device, :ip_class, :login_time, :operating_system)";
            $statement = $db->prepare($sql);
            $statement->bindParam(':hash', $user['hash']);
            $statement->bindParam(':device', getUserBrowser());
            $statement->bindParam(':ip_class', substr($ip, 0, 2));
            $statement->bindParam(':login_time', $login_time);
            $statement->bindParam(':operating_system', getrealsystem());
            $statement->execute();

            $success_login_count = $user['success_login_count'] + 1;
            $update = $db->prepare("UPDATE `accounts` SET success_login_count = :success_login_count WHERE hash = :hash");
            $update->bindParam(':success_login_count', $success_login_count);
            $update->bindParam(':hash', $user['hash']);
            $update->execute();

            $_SESSION['GET_USER_SSID'] = $user['hash'];
            session_write_close();

            exit();
        }
    }
}
