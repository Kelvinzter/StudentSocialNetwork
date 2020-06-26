<?php

class Login
{
    public static function isLoggedIn()
    {
        if (isset($_COOKIE['SNID'])) {
            if (DB::query('SELECT UID FROM login_token WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))) {
                $UID = DB::query('SELECT UID FROM login_token WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))[0]['UID'];

                if (isset($_COOKIE['SNID_1'])) {
                    return $UID;
                } else {
                    $cstrong = TRUE;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    DB::query('INSERT INTO login_token VALUES(\'\', :token, :UID)', array(':token' => sha1($token), ':UID' => $UID));
                    DB::query('DELETE FROM login_token WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])));

                    setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                    setcookie("SNID_1", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                    return $UID;
                }
            }
        }

        return false;
    }
}
