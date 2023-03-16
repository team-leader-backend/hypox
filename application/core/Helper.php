<?php

class Helper
{
    public function __construct()
    {
        //https://maps.googleapis.com/maps/api/geocode/json?address=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%20%D1%83%D0%BB.%20%D0%9F%D0%BE%D0%BB%D1%82%D0%B0%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%2018&key=AIzaSyBgVIObHG9w4w-ZsGeA2aHsiCheZRVA7m4
        //https://maps.googleapis.com/maps/api/directions/json?origin=55.573721,%2037.566561&destination=55.574037,%2037.590637&key=AIzaSyBe23DtCnNlwWxEvl1K1Z_DF8DL2jy48Pg
    }

    static public function convertCSVtoArray(string $filename)
    {
        $fp = @fopen($filename, "r");
        if ($fp) {
            while (($buffer = fgets($fp, 4096)) !== false) {
                $arr[] = explode(';', $buffer);
            }
            if (!feof($fp)) {
                echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
            }
            fclose($fp);
        }
        return $arr ?? [];
    }

    public function analysTime($str)
    {
        $akkN = '';
        foreach (str_split($str) as $numS) {
            if (is_numeric($numS)) {
                $akkN .= $numS;
            } else {
                $akkN .= '-';
            }
        }
        $res = explode('-', $akkN);
        if (count($res) > 3) {
            $len = mb_strlen($res[0]) + mb_strlen($res[1]) + mb_strlen($res[2]);
            $all = mb_strlen($str);
            $ost = mb_substr($str, $len + 2, $all - $len + 2);
            if (mb_substr($str, $len + 2, 1) == '_') {
            } elseif (mb_substr($str, $len + 2, 1) == '.') {
                $ost = '_0' . $ost;
            } else $ost = '_' . $ost;
            if (strtotime($res[0] . '-' . $res[1] . '-' . $res[2])) {
                return date('Y-m-d', strtotime($res[0] . '-' . $res[1] . '-' . $res[2])) . $ost;
            }
            if (mb_strlen($res[0]) == 4) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime($res[0] . '-' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime($res[0] . '-0' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime($res[0] . '-' . mb_substr($res[1], 0, 2) . '-01')) . $ost;
                }
            } elseif (mb_strlen($res[0]) == 3) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-0' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-' . mb_substr($res[1], 0, 2) . '-01')) . $ost;
                }
            } elseif ((mb_strlen($res[0]) == 2) && ($res[0] > 31)) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-0' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-' . mb_substr($res[1], 0, 2) . '-01')) . $ost;
                }
            } elseif (mb_strlen($res[0]) > 4) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-0' . $res[1] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-' . mb_substr($res[1], 0, 2) . '-01')) . $ost;
                }
            } elseif ((mb_strlen($res[0]) == 2) && ($res[0] <= 31)) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('20-' . $res[1] . '-' . $res[0] . '-01')) . $ost;
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('200-' . $res[1] . '-' . $res[0] . '-01')) . $ost;
                }
            } else {
                return date('Y-m-d') . '_0' . $ost;
            }
        } elseif (count($res) == 2) {
            if (mb_strlen($res[0]) == 4) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime($res[0] . '-' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime($res[0] . '-0' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime($res[0] . '-' . mb_substr($res[1], 0, 2) . '-01'));
                }
            } elseif ((mb_strlen($res[0]) == 2) && ($res[0] > 31)) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-0' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime('20-' . $res[0] . '-' . mb_substr($res[1], 0, 2) . '-01'));
                }
            } elseif (mb_strlen($res[0]) == 3) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-0' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime('2-' . $res[0] . '-' . mb_substr($res[1], 0, 2) . '-01'));
                }
            } elseif (mb_strlen($res[0]) > 4) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-0' . $res[1] . '-01'));
                } elseif (mb_strlen($res[1]) > 2) {
                    return date('Y-m-d', strtotime(mb_substr($res[0], 0, 4) . '-' . mb_substr($res[1], 0, 2) . '-01'));
                }
            } elseif ((mb_strlen($res[0]) == 2) && ($res[0] <= 31)) {
                if (mb_strlen($res[1]) == 2) {
                    return date('Y-m-d', strtotime('20-' . $res[1] . '-' . $res[0] . '-01'));
                } elseif (mb_strlen($res[1]) == 1) {
                    return date('Y-m-d', strtotime('200-' . $res[1] . '-' . $res[0] . '-01'));
                }
            }
        } else {
            return false;
        }
    }

    public function normalizedTime($str)
    {
        if (strtotime($str) != false) {
            return strtotime($str);
        } else {
            if ((mb_strlen($str) >= 8) && (mb_strlen($str) <= 10)) {
                $akkN = '';
                foreach (str_split($str) as $numS) {
                    if (is_numeric($numS)) {
                        $akkN .= $numS;
                    } else {
                        $akkN .= '-';
                    }
                }
                return date('Y-m-d', strtotime($akkN));
            } elseif ((mb_strlen($str) >= 5) && (mb_strlen($str) < 8)) {
                $akkN = '';
                foreach (str_split($str) as $numS) {
                    if (is_numeric($numS)) {
                        $akkN .= $numS;
                    } else {
                        $akkN .= '-';
                    }
                }
                $resDA = explode('-', $akkN);
                if (mb_strlen($resDA[0]) < 2) $d1 = '0' . $resDA[0];
                else $d1 = $resDA[0];
                if (mb_strlen($resDA[1]) < 2) $d2 = '0' . $resDA[1];
                else $d2 = $resDA[1];
                if (mb_strlen($resDA[2]) < 2) $d3 = '200' . $resDA[2];
                elseif (mb_strlen($resDA[2]) == 2) $d3 = '20' . $resDA[2];
                else $d3 = $resDA[2];
                return date('Y-m-d', strtotime($d3 . '-' . $d2 . '-' . $d1));
            } elseif ((mb_strlen($str) > 10)) {
                $str = mb_substr($str, 0, 10);
                if (strtotime($str)) {
                    return date('Y-m-d', strtotime($str));
                } else {
                    $akkN = '';
                    foreach (str_split($str) as $numS) {
                        if (is_numeric($numS)) {
                            $akkN .= $numS;
                        } else {
                            $akkN .= '-';
                        }
                    }
                    $res = explode('-', $akkN);
                    self::out_d($res);
                    if (mb_strlen($res[0]) < 2) $d1 = '0' . $res[0];
                    else $d1 = $res[0];
                    if (mb_strlen($res[1]) < 2) $d2 = '0' . $res[1];
                    else $d2 = $res[1];
                    if (mb_strlen($res[2]) < 2) $d3 = '200' . $res[2];
                    elseif (mb_strlen($res[2]) < 4) $d3 = '20' . $res[2];
                    return date('Y-m-d', strtotime($d1 . '-' . $d2 . '-' . $d3));
                }
            } else {
                $akkN = '';
                foreach (str_split($str) as $numS) {
                    if (is_numeric($numS)) {
                        $akkN .= $numS;
                    } else {
                        $akkN .= '-';
                    }
                }
                return date('Y-m-d', strtotime($akkN . '-2023'));
            }
        }
    }

    public function generateTransaction()
    {
        $sym = '';
        for ($i = 0; $i < 20; $i++) {
            $sym .= rand(0, 9);
        }
        return $sym;
    }

    public function timeInterval($start, $stop)
    {
        // Дата начала интервала
        $start = new DateTime($start);
// Дата окончания интервала
        $end = new DateTime($stop);
// Интервал в один день
        $step = new DateInterval('P1D');
// Итератор по дням
        $period = new DatePeriod($start, $step, $end);

// Вывод дней
        foreach ($period as $datetime) {
            $array_date[] = $datetime->format("d.m.Y");
        }
        return $array_date;
    }

    public function generatePassword()
    {
        $token = '';
        for ($i = 0; $i < 10; $i++) {
            //48-57 ; 65-90
            do {
                $char = rand(40, 100);
            } while (($char < 49) || ($char > 90));
            if (($char > 57) && ($char < 65)) {
                $token .= (string)$char;
            } else {
                if ($char == 79) {
                    $token .= 'A';
                } else {
                    $token .= chr($char);
                }
            }
        }
        $pass = '';
        foreach (str_split($token) as $sym) {
            if (rand(1, 100) < 50) {
                $pass .= mb_strtolower($sym);
            } else {
                $pass .= $sym;
            }
        }
        return $pass;
    }

    public static function get_ip()
    {
        $value = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $value = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $value = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $value = $_SERVER['REMOTE_ADDR'];
        }

        return $value;
    }

    public function ipuser()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
        $session_id = $_SERVER['HTTP_COOKIE'] ?? null;
        session_start();
        $user_id = $_COOKIE['user_id'] ?? null;
        session_write_close();
        return ['ip' => $ip, 'port' => $_SERVER['REMOTE_PORT'], 'user_id' => $user_id];
    }

    public function generateToken($range = 20)
    {
        $token = '';
        for ($i = 0; $i < $range; $i++) {
            //48-57 ; 65-90
            do {
                $char = rand(40, 100);
            } while (($char < 48) || ($char > 90));
            if (($char > 57) && ($char < 65)) {
                $token .= (string)$char;
            } else {
                if ($char == 79) {
                    $token .= (string)$char;
                } else $token .= chr($char);
            }
        }
        return $token;
    }

    public static function out_d($val)
    {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
    }

    //========================================================================
    public static function dump($val)
    {
        echo '<pre>';
        var_dump($val);
        echo '</pre>';
    }

    //========================================================================

    public function send_json($data)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1728000');
        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type:application/json;');
        header('Content-Type:multipart/form-data;');
        echo $data;
        return null;
    }

//===============================================================================
    public function send_array2()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        header('Content-Type:application/json;');
    }

    //===========================================================================
    public function send_array($data)
    {
        $result = json_encode($data);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 60');
        //header("Access-Control-Allow-Headers: AccountKey,X-Requested-With, Content-Type, origin, Authorization, accept, client-security-token, host, date, cookie, cookie2");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, X-Custom-Header, X-Requested-With, Client-Security-Token');
        header('Content-Type:application/json;');
        //header('Content-Type:multipart/form-data;');
        echo $result;
    }

    //===========================================================================
    public function send_array404($data = null)
    {
        //$result = json_encode($data);
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1728000');
        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type:application/json;');
        //echo $result;
        return null;
    }

    //===========================================================================
    public function send_array400($description)
    {
        $result = json_encode(['error_description' => $description, 'error_code' => 400]);
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request", true, 400);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1728000');
        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type:application/json;');
        echo $result;
        return null;
    }

    //===========================================================================
    public function send_array401($description = 'Unauthorized')
    {
        $result = json_encode(['error_description' => $description, 'error_code' => 401]);
        header($_SERVER["SERVER_PROTOCOL"] . " 401 Unauthorized", true, 401);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1728000');
        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type:application/json;');
        echo $result;
        return null;
    }

    //===========================================================================
    public function send_array403($description = 'Forbidden')
    {
        $result = json_encode(['error_description' => $description, 'error_code' => 403]);
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden", true, 403);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1728000');
        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type:application/json;');
        echo $result;
        return null;
    }

    //===========================================================================
    public function getRequest($address)
    {
        $host = $address;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, 'yandex.ru');
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //===========================================================================
    public function postRequest($host, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    public function getRequestToken($host = "http://10.0.1.126/1c/hs/exchange/TypesOfPrices", $auth_string = 'Web:pzt58dgw543')
    {
        $token = base64_encode($auth_string);
        $ch = curl_init();
        $authorization = "Authorization: Basic " . $token;
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_REFERER, "https://yandex.ru");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $html = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return json_decode($html);
    }

    //===========================================================================
    public function postRequestToken($host, $token, $data)
    {
        $ch = curl_init();
        $post = json_encode($data);
        $authorization = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }

    //=========================================================================
    public function capcha()
    {
        $img = '';
        $capcha_array = '';
        for ($i = 1; $i < 5; $i++) {
            $rand = rand(0, 31);
            $img = $img . '<img src="' . '/capcha/' . CAPCHA[$rand][1] . '" style="max-height: 50px;">';
            $capcha_array = $capcha_array . CAPCHA[$rand][0];
        }
        session_start();
        $_SESSION['capcha'] = $capcha_array;
        session_write_close();
        return $img;
    }

    //=========================================================================
    public function get_capcha()
    {
        $img = '';
        $capcha_array = '';
        for ($i = 1; $i < 5; $i++) {
            $rand = rand(0, 31);
            $img = $img . '<img src="' . '/capcha/' . CAPCHA[$rand][1] . '" style="max-height: 50px;">';
            $capcha_array = $capcha_array . CAPCHA[$rand][0];
        }
        session_start();
        $_SESSION['capcha'] = $capcha_array;
        session_write_close();
        return $img;
    }

    //=========================================================================
    public function rus_to_lat($str)
    {
        $str = preg_replace('/[^a-zA-Zа-яА-ЯёЁ0-9_\. ]/u', '', $str);
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ', '.', '(', ')', ',', '®', '/', '\\', '|');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_', '.', '_', '_', '_', '', '', '', '');
        return str_replace($rus, $lat, $str);
    }

    //=========================================================================
    public function diff_two_dimensional_array($array)
    {
        self::out_d($array);
        $array2 = $array;
        foreach ($array2 as $key2 => $arr2) {
            $array_key[] = $key2;   // Массив ключей
        }
        $diff_array[] = $array[$array_key[0]];
        for ($i = 0; $i < count($array_key); $i++) {
            for ($ii = $i + 1; $ii < count($array_key); $ii++) {
                $first_el = (array)$array2[$array_key[$i]];
                $sec_el = (array)$array[$array_key[$ii]];
                $res_diff = count(array_diff($first_el, $sec_el));
                echo $i, '==?==', $ii, '==->', $res_diff, '<br>';
                if ($res_diff == 0) {
                    unset($array[$array_key[$ii]]);
                }
            }
        }
        self::out_d($array);
    }

    //=========================================================================
    public function correrct_nulled($word = '')
    {
        $yauri = "https://speller.yandex.net/services/spellservice.json/checkText?text=" . $word;
        $json = $this->getRequest($yauri);
        $array_correct = json_decode($json);
        return $array_correct;
    }

    //=========================================================================
    public function correrct_spell($word = '')
    {
        $yauri = "https://speller.yandex.net/services/spellservice.json/checkText?lang=ru&text=" . $word;
        $json = $this->getRequest($yauri);
        $array_correct = json_decode($json);
        if (empty($array_correct)) return null;
        if (count($array_correct) == 0) return null;
        $correct = $array_correct[0]->s[0];
        return $correct;
    }

    //=========================================================================
    public function correrct_spell_v2($word)
    {
        $word = urlencode($word);
        $yauri = "https://speller.yandex.net/services/spellservice.json/checkText?lang=ru&text=" . $word;
        $json = $this->getRequest($yauri);
        $array_correct = json_decode($json);
        $strword = '';
        foreach ($array_correct as $arc) {
            $strword = $strword . $arc->s[0] . ' ';
        }
        return trim($strword);
    }

    //=========================================================================
    public function correrct_spell_all($word = '')
    {
        $count = explode(' ', $word);
        if (count($count) > 1) {
            $word_sum = '';
            foreach ($count as $mword) {
                $yauri = "https://speller.yandex.net/services/spellservice.json/checkText?lang=ru&text=" . $mword;
                $json = $this->getRequest($yauri);
                $array_correct = json_decode($json);
                if (count($array_correct) == 0) $correct = $mword;
                else $correct = $array_correct[0]->s[0];
                $word_sum = $word_sum . ' ' . $correct;
            }
            $word_sum = preg_replace('/\s/', ' ', $word_sum);
            return trim($word_sum) ?? null;
        } else {
            $yauri = "https://speller.yandex.net/services/spellservice.json/checkText?lang=ru&text=" . $word;
            $json = $this->getRequest($yauri);
            $array_correct = json_decode($json);
            if (count($array_correct) == 0) return null;
            $correct = $array_correct[0]->s[0];
            return trim($correct);
        }
    }

    //=========================================================================
    public function predictor($words)
    {
        $yauri = "https://predictor.yandex.net/api/v1/predict.json/complete?key=pdct.1.1.20220608T173059Z.a8cc28709e68ab97.1bc6182194c386ecf86d355ff100793a5994984d&lang=ru&q=" . urlencode($words);
        $res = $this->getRequest($yauri);
        $ar = json_decode($res);
        return $ar;
    }

    //=========================================================================
    public function aurora($get_function)
    {
        $token = base64_encode('superu:iddqdidkfa');
        //$url = 'https://rlsaurora10.azurewebsites.net/api/inventory_brief?pos=' . $word;
        //$url = 'http://rlsaurora10.azurewebsites.net/api/dict_active_substances';
        $url = 'http://rlsaurora10.azurewebsites.net/api/' . $get_function;
        //$authorization = "Authorization: Basic " . $token;
        $ch = curl_init($url); // INITIALISE CURL
        $authorization = "Authorization: Basic " . $token; // *Prepare Autorisation Token*
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authorization)); // *Inject Token into Header*
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $w_data = curl_exec($ch);
        curl_close($ch);
        return $w_data;
    }

    static public function convertDate($undate)
    {
        $month = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
        $undateArray = explode(' ', trim($undate));
        $fulldate = $undateArray[2] . '-';
        $fulldate .= array_search($undateArray[1], $month);
        $fulldate .= '-' . $undateArray[0];
        return date('Y-m-d', strtotime($fulldate));
    }

    //=========================================================================
    public function testUrl($url = "http://reg.ru")
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        //$filejson = file_get_contents('https://tdme.ru/vasya', false, stream_context_create($arrContextOptions), false, 200);
        $res = @get_headers("https://reg.ru", false, stream_context_create($arrContextOptions));
        if (is_array($res)) {
            $rez = explode(' ', $res[0]);
            return $rez[1];
        } else {
            return false;
        }
    }

    public function aurora_getUpdate()
    {
        $login = 'superu';
        $passowrd = 'iddqdidkfa';
        $token = base64_encode($login . ':' . $passowrd);
        $url = 'https://rlsaurora10.azurewebsites.net/api/classes_prep?OnDate=01.08.2021';
        $ch = curl_init($url);
        $authorization = "Authorization: Basic " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authorization)); // *Inject Token into Header*
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $w_data = curl_exec($ch);
        return $w_data;
    }

    //=========================================================================
    public function aurora_getUpdatelibrary()
    {
        $login = 'lopez';
        $passowrd = 'iddqdidkfa';
        $token = base64_encode($login . ':' . $passowrd);
        $url = 'http://rlsaurora10.azurewebsites.net/api/library_as_description';
        $ch = curl_init($url);
        $authorization = "Authorization: Basic " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authorization)); // *Inject Token into Header*
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $w_data = curl_exec($ch);
        file_put_contents('/var/www/html/tmp/lib_as_desc.zip', $w_data);
        $url = 'http://rlsaurora10.azurewebsites.net/api/library_description';
        $ch = curl_init($url);
        $authorization = "Authorization: Basic " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authorization)); // *Inject Token into Header*
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $w_data = curl_exec($ch);
        file_put_contents('/var/www/html/tmp/lib_desc.zip', $w_data);
    }

    //=========================================================================
    public function aurora_api_update($name_update)
    {
        $this->load->database();
        $url_base = UPDATE_BASE[$name_update];
        $db_name = key($url_base);   //Название таблицы
        $url = $url_base[$db_name];    //url
        $active_key = $url_base['key']; //индекс
        $base_url = 'http://rlsaurora10.azurewebsites.net';

        $date = date("d.m.Y");
        $date = strtotime($date);
        $date = strtotime("-30 day", $date);

        $base_date = date('d.m.Y', $date);
        $login = 'lopez';
        $passowrd = 'iddqdidkfa';
        $url = $base_url . '/' . $url . $base_date;
        $token = base64_encode($login . ':' . $passowrd);
        $ch = curl_init($url);
        $authorization = "Authorization: Basic " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authorization)); // *Inject Token into Header*
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $w_data = curl_exec($ch);
        if (strlen($w_data) < 5) {
            $this->db->close();
            return false;
        }
        $obj_data = json_decode($w_data);
        echo '<br>=====================================', $db_name, '=============================<br>';
        self::out_d($obj_data);
        flush();
        ob_flush();
        foreach ($obj_data as $refresh_one_data) {
            //$this->db->insert($db_name, $refresh_one_data);
            $this->db->replace($db_name, $refresh_one_data);
        }
        echo 'CLEAR SYNTHETIC BASES, please wait....';
        flush();
        ob_flush();
        $this->truncate_insert();
    }

    //=========================================================================
    public function aurora_truncate_insert()
    {
        $this->load->database();
        $this->db->query("TRUNCATE TABLE `SYNTHETIC_TNLAT`");
        $this->db->query("INSERT INTO `SYNTHETIC_TNLAT` SELECT NULL,`AURORA_INVENTORY_COMPLETE`.`trade_name_id` as id, `old_id`, `AURORA_INVENTORY_COMPLETE`.`prep_id`, `AURORA_INVENTORY_COMPLETE`.`lat_name_id` as lat_id, `AURORA_INVENTORY_COMPLETE`.`trade_name_rus_html` as tn_name, `AURORA_INVENTORY_COMPLETE`.`lat_name` as tn_lat, `AURORA_INVENTORY_COMPLETE`.`ntfr_id`, `AURORA_INVENTORY_COMPLETE`.`as_id` FROM `AURORA_INVENTORY_COMPLETE` JOIN `AURORA_TRADENAMES` ON `AURORA_TRADENAMES`.`id`= `AURORA_INVENTORY_COMPLETE`.`trade_name_id`");
        $this->db->close();
    }

    //=========================================================================
    public function get_token()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        $xsecret = $_SERVER['HTTP_X_SECRET'] ?? null;
        $auth = $token . ' ' . $xsecret;
        if ($auth) return explode(' ', $auth);
        else return null;
    }

    //=========================================================================
    public function getWiki($phrase)
    {
        $struri = 'https://www.startpage.com/sp/search?query=wikipedia' . urlencode(' ' . trim($phrase));
        $result = $this->getRequest($struri);
        return $result;
    }

    public function get_dadata_address($arFields = ['Полтавская 18 Москва'])
    {
        $arResult = [];
        if ($oCurl = curl_init("https://cleaner.dadata.ru/api/v1/clean/address")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }

        return $arResult;
    }

    public function get_dadata_fastaddress($arFieldsIn)
    {
        $arFields = ['query' => $arFieldsIn, 'language' => 'ru'];
        $arResult = [];
        if ($oCurl = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }
        return $arResult;
    }

    public function googleGeocode($address)
    {
        $address = urlencode($address);
        $latlan = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=AIzaSyBgVIObHG9w4w-ZsGeA2aHsiCheZRVA7m4&language=ru");
        $srcAddress = json_decode($latlan, true);
        //self::out_d($srcAddress);
        if (isset($srcAddress['results'][0]['address_components'])) {
            foreach ($srcAddress['results'][0]['address_components'] as $unitAddress) {
                foreach ($unitAddress as $key => $oneCom) {
                    if ($key == 'long_name') $value = $oneCom;
                    if ($key == 'types') {
                        foreach ($oneCom as $item) {
                            if ($item == 'administrative_area_level_1') $region = $value;
                            if ($item == 'country') $country = $value;
                            if ($item == 'locality') $city = $value;
                            //if ($item == 'administrative_area_level_2') $city = $value;
                        }
                    }
                }
            }
            $latitude = $srcAddress['results'][0]['geometry']['location']['lat'];
            $longitude = $srcAddress['results'][0]['geometry']['location']['lng'];
            $address = $srcAddress['results'][0]['formatted_address'];
            return ['status' => $srcAddress['status'], 'country' => $country ?? '', 'region' => $region ?? '', 'city' => $city ?? '', 'address' => $address, 'lat' => $latitude ?? 0, 'lon' => $longitude ?? 0] ?? [];
        } else {
            return ['status' => 'Ok', 'country' => '', 'region' => '', 'city' => '', 'address' => $address, 'lat' => 0, 'lon' => 0] ?? [];
        }
    }

    public function get_dadata_geocode($arFieldsIn)
    {
        $arFields = [$arFieldsIn];
        $arResult = [];
        if ($oCurl = curl_init("https://cleaner.dadata.ru/api/v1/clean/address")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }
        return $arResult;
    }

    public function get_dadata_inversegeocode($arFieldsIn)
    {
        $arFields = [$arFieldsIn];
        $arResult = [];
        if ($oCurl = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }
        return $arResult;
    }

    public function get_dadata_inn($arFieldsIn)
    {
        $arFields = ['query' => $arFieldsIn, 'language' => 'ru'];
        $arResult = [];
        if ($oCurl = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }
        return $arResult;
    }

    public function get_dadata_okved($arFieldsIn)
    {
        $arFields = ['query' => $arFieldsIn, 'language' => 'ru'];
        $arResult = [];
        if ($oCurl = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/okved2")) {
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token 80908b35adc295125f8cab8428f5fa4d635f453f',
                'X-Secret: 5e6acebc6bb587ca1f851cce24687ccad05a70d4'
            ]);
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($arFields));
            $sResult = curl_exec($oCurl);
            $arResult = json_decode($sResult, true);
            curl_close($oCurl);
        }
        return $arResult;
    }

    public function webAuth($login, $password, $host)
    {
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);
    }

    public function clean_string($string)
    {
        $string = preg_replace('/[^_\-@a-zA-Zёа-яЁА-Я0-9 \d]/ui', '', $string);
        return trim($string) ?? null;
    }

    public function crypt_loginpass($login = null, $password = null, $reverse = false, $inverse = false)
    {
        //self::out_d(openssl_get_cipher_methods());
        //self::out_d(hash_hmac_algos());die();
        if (empty($login)) return ['error' => 'Bad login', 'result' => $login];
        if (empty($password)) return ['error' => 'Bad password', 'result' => $password];
        else {
            if (mb_strlen($password) < 6) $password = $password . $password;
        }
        if (!$reverse) {
            $login = hash('sha256', $login);
            $password = hash('sha256', $password);
            $code = openssl_encrypt($password, 'rc4', $login, 0, '');
            if ($inverse) {
                return ['error' => 'Not real restore', 'result' => null];
            } else return ['error' => 'Hash password', 'result' => $code];
        } else {
            if ($inverse) {
                $password_e = openssl_decrypt($password, 'rc4', $login, 0, '');
                return ['error' => 'Restore password', 'result' => $password_e];
            } else {
                $code = openssl_encrypt($password, 'rc4', $login, 0, '');
                return ['error' => 'Unsafe hash', 'result' => $code];
            }
        }
    }

    public function rus_lat($text, $flag = true)
    {      //Возвратная транслитерация true - русский в транслит, false - обратно
        $trans = array(
            "а" => "a", "б" => "b", "в" => "v", "г" => "g",
            "д" => "d", "е" => "e", "ё" => "_yo", "ж" => "_zh",
            "з" => "z", "и" => "i", "й" => "j", "к" => "k",
            "л" => "l", "м" => "m", "н" => "n", "о" => "o",
            "п" => "p", "р" => "r", "с" => "s", "т" => "t",
            "у" => "u", "ф" => "f", "х" => "h", "ц" => "c",
            "ч" => "_ch", "ш" => "_sh", "щ" => "_hh", "ы" => "y",
            "э" => "_je", "ю" => "_yu", "я" => "_ya", "ь" => "_mm",
            "ъ" => "_tt", "(" => "_ls", ")" => "_rs", " " => "~",

            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "_YO", "Ж" => "_ZH",
            "З" => "Z", "И" => "I", "Й" => "J", "К" => "K",
            "Л" => "L", "М" => "M", "Н" => "N", "О" => "O",
            "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
            "Ч" => "_CH", "Ш" => "_SH", "Щ" => "_HH", "Ы" => "Y",
            "Э" => "_JE", "Ю" => "_YU", "Я" => "_YA", "Ь" => "_MM",
            "Ъ" => "_TT"
        );
        if ($flag) {
            // Прямая транслитерация
            $recipient = '';
            foreach (mb_str_split($text) as $char) {
                if (isset($trans[$char])) $recipient .= $trans[$char];
                else $recipient .= $char;
            }
            return $recipient;
        } else {
            // Обратная транслитерация
            $recipient = '';
            $arr = mb_str_split($text);
            $recount = count($arr);
            $count = 0;
            while ($count < $recount) {
                if ($arr[$count] === '_') {
                    $char = '_';
                    $count++;
                    $char .= $arr[$count];
                    $count++;
                    $char .= $arr[$count];
                    $count++;
                    //self::out_d($char);
                } else {
                    $char = $arr[$count];
                    $count++;
                }
                foreach ($trans as $rus => $eng) {
                    if ($eng === $char) {
                        $key = $rus;
                        break;
                    } else $key = false;
                }
                if ($key) $recipient .= $key;
                else $recipient .= $char;
            }
            return $recipient;
        }
    }

    public function refcode()
    {
        $refminus = '';
        for ($i = 0; $i < 32; $i++) {
            $key = rand(0, 15);
            switch ($key) {
                case 10:
                    $refminus = $refminus . 'a';
                    break;
                case 11:
                    $refminus = $refminus . 'b';
                    break;
                case 12:
                    $refminus = $refminus . 'c';
                    break;
                case 13:
                    $refminus = $refminus . 'd';
                    break;
                case 14:
                    $refminus = $refminus . 'e';
                    break;
                case 15:
                    $refminus = $refminus . 'f';
                    break;
                default:
                    $refminus = $refminus . $key;
                    break;
            }
        }
        $temp = mb_substr($refminus, 0, 8) . '-' . mb_substr($refminus, 8, 4) . '-' . mb_substr($refminus, 12, 4) . '-' . mb_substr($refminus, 16, 4) . '-' . mb_substr($refminus, 20);
        return $temp;
    }

    public function only_float($string)
    {
        $text = str_replace(',', '.', $string);
        $str = preg_replace('/[^0-9\.]/', '', $text);
        //$str = str_replace(chr(160),'',$content);
        return (float)$str ?? 0;
    }

    public function __post()
    {
        if (empty($_POST)) {
            $stream = $this->input->raw_input_stream;
            return json_decode($stream, true);
        } else {
            return $_POST;
        }
    }

    public function altpost()
    {
        $stream = $this->input->raw_input_stream;
        $stream = ltrim($stream, '{');
        $stream = rtrim($stream, '}');
        $array = explode(',', $stream);
        foreach ($array as $ar) {
            $r = explode(':', $ar);
            $key = trim(trim($r[0]), '"');
            $res[$key] = trim($r[1], '"');
        }
        return $res;
    }
}
