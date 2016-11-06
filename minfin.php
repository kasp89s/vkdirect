<?php
define('API_KEY', 'zp3kitpic');
define('login', 'boosyck@i.ua');
define('password', 'g65uerden');

include_once 'DB.php';
//echo file_get_contents(__DIR__ . '/cookies_tmp/r.txt'); exit;
if(is_dir(__DIR__ . "/cookies_tmp") === false) {
    mkdir(__DIR__ . "/cookies_tmp");
}

if(is_dir(__DIR__ . "/cookies_tmp") === false) {
    echo 'Error can`t create tmp folder!';
    exit;
}

if (!function_exists('curl_init')) {
    echo 'Curl can`t instance!';
    exit;
}

if (!file_put_contents(__DIR__ . '/cookies_tmp/t.txt', 't')) {
    echo 'Can`t write in tmp folder!';
    exit;
}

class Connector {

    private static $_login = '';

    private static $_password = '';

    private static $_loops = 0;

    private static $_maxLoops = 5;

    private $url = array(
        'login' => 'http://minfin.com.ua/login',
        'add' => 'http://minfin.com.ua/currency/auction/new',
        'post' => 'http://minfin.com.ua/currency/auction/add/',
        'finish' => 'http://minfin.com.ua/currency/auction/finish/',
        'list' => 'http://minfin.com.ua/currency/auction/list/',
        'remove' => 'http://minfin.com.ua/api/auction/delete/',
    );

    private static $_instance = false;

    public static function instance($l = false, $p = false)
    {
        if(self::$_instance === false) {
            self::$_instance = new self($l, $p);
        }

        return self::$_instance;
    }

//Login:boosyck@i.ua
//Password:g65uerden
//action:login
//ref:
    private function __construct($l, $p)
    {
        self::$_login = $l;
        self::$_password = $p;

        $content = $this->connect($this->url['add']);
        if ($this->checkAuthorization($content) === false) {
            $response = $this->connect($this->url['login'],
                array(
                    'Login' => self::$_login,
                    'Password' => self::$_password,
                    'action' => 'login',
                    'ref' => '',
                ),
                $this->url['login']
            );
            $this->sleep();
        } else {
            //echo "auth";
        }
    }

    private function connect($link, $post = null, $referer = false)
    {
//        echo 'POST of link ' . $link . ':';
//        var_dump($post);
        if (empty($referer)) {
            $referer = $link;
        }
        $ch = curl_init();
        $f = fopen(__DIR__ . '/cookies_tmp/request.txt', 'w');
        $header = array();
        $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4";
        $header[] = "Pragma: "; // browsers keep this blank.
        curl_setopt($ch, CURLOPT_URL,$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, sdch');
        // если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36');
        // елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
        curl_setopt ($ch, CURLOPT_REFERER, $referer);
        curl_setopt ($ch, CURLOPT_VERBOSE, 1);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt ($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . "/cookies_tmp/" . "cookie".self::$_login.".txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . "/cookies_tmp/" . "cookie".self::$_login.".txt");

        if($post !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $response = $this->curl_exec_follow($ch);
        curl_close($ch);

        return $response;
    }

    private function curl_exec_follow( $ch )
    {
        if (self::$_loops++ >= self::$_maxLoops)
        {
            self::$_loops = 0;
            return false;
        }
        $data = curl_exec($ch);
        $temp = $data;
        list($header, $data) = explode("\n\n", $data, 2);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http == 301 || $http == 302) {
            $matches = array();
            preg_match('/ocation:(.*?)\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
//            print_r($url);
            if (!$url)
            {
                self::$_loops = 0;
                return $data;
            }
            $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            if (!$url['scheme'])
                $url['scheme'] = $last_url['scheme'];
            if (!$url['host'])
                $url['host'] = $last_url['host'];
            if (!$url['path'])
                $url['path'] = $last_url['path'];

            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
//            echo "\n redirect to ".$new_url;
            //@todo Возможна непредвиденая хуйня.
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $new_url);
            return $this->curl_exec_follow($ch);
        } else {
            self::$_loops = 0;
            return $temp;
        }
    }

    /**
     * Проверяет авторизирован ли пользователь.
     */
    private function checkAuthorization($html)
    {
        if(strpos($html, '<form action="/currency/auction/add/" method="POST" class="js-formAuAddNew" role="form">') === false) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Удаляет старые обьявления.
     */
    public function removeOldAdvertisement()
    {
            $content = $this->connect($this->url['list']);
            preg_match_all('/<a data-id="(.*)" href="#" title="Удалить объявление" class="au-my-deal-control au-my-deal-control-label-delete js-au-delete-deal">/', $content, $hash);

            if (empty($hash[1]) === true) {
                return false;
            }
            $ids = end($hash);

            foreach($ids as $id) {
                $this->connect($this->url['remove'], array('del' => $id));
                $this->sleep();
            }
        return true;
    }

    /**
     * Добавляет новое обьявление.
     *
     * fType 1 - buy | 2 - sell
     */
    public function addAdvertisement($advertisement)
    {
        if ($advertisement->buyAmount > 0) {
            $response = $this->connect($this->url['post'],
                array(
                    'Type' => 'buy',
                    'Amount' => $advertisement->buyAmount,
                    'Currency' => 'USD',
                    'Parts' => '1',
                    'Course' => $advertisement->buyPrice,
                    'RegionID' => 0,
                    'District' => $advertisement->district,
                    'Comments' => '',
                    'Contacts' => $advertisement->phone_minfin,
                    'agree' => 1,
                ),
                $this->url['add']
            );
            preg_match('/<input type="hidden" value="(.*)" name="Data">/', $response, $hash);
            if (isset($hash[1])) {
                $this->sleep();
                $this->connect($this->url['finish'],
                    array(
                        'Data' => $hash[1],
                    ),
                    $this->url['post']
                );
            }
        }

        if ($advertisement->sellAmount > 0) {
            $response = $this->connect($this->url['post'],
                array(
                    'Type' => 'sell',
                    'Amount' => $advertisement->sellAmount,
                    'Currency' => 'USD',
                    'Parts' => '1',
                    'Course' => $advertisement->sellPrice,
                    'RegionID' => 0,
                    'District' => $advertisement->district,
                    'Comments' => '',
                    'Contacts' => $advertisement->phone_minfin,
                    'agree' => 1,
                ),
                $this->url['add']
            );
            preg_match('/<input type="hidden" value="(.*)" name="Data">/', $response, $hash);
            if (isset($hash[1])) {
                $this->sleep();
                $this->connect($this->url['finish'],
                    array(
                        'Data' => $hash[1],
                    ),
                    $this->url['post']
                );
            }
        }
    }

    public function getStatistic()
    {
        $result = array(
            'buy' => array(),
            'sell' => array(),
        );

        foreach (array('buy' => $this->url['listBuy'], 'sell' => $this->url['listSell']) as $key => $url) {
            $content = $this->connect($url);

            preg_match_all('|<table class="local_table local_table-black_market">(.*)</table>|isU', $content, $table);
            $table = end($table[0]);
            preg_match_all('|<tr class="">(.*)</tr>|isU', $table, $matches);
            $rows = end($matches);
            $list = array();
            $summ = 0;
            $currentCount = 0;
            $count = count($rows);
            $min = 0;
            $max = 0;
            foreach ($rows as $row) {
                preg_match_all('|<td>(.*)</td>|isU', $row, $matches);
                preg_match_all('|<td class="align_left">(.*)</td>|isU', $row, $info_matches);

                $b = end($info_matches);
                $a = end($matches);
                $c = array_merge($a, $b);
                $price = (float) $a[1];

                if (
                    ($summ > 0 && $currentCount > 0 && (($price + 0.5) < round($summ / $currentCount, 2))) ||
                    ($summ > 0 && $currentCount > 0 && (($price - 0.5) > round($summ / $currentCount, 2)))
                ) {
                    $count-= 1;
                    continue;
                }
                //echo round($summ / $currentCount, 2) . ' => ';
                //echo $price . "\n";
                if (count($list) < 10) {
                    $list[] = $c;
                }

                $summ+= $price;
                $currentCount++;
                if ($min == 0 || $min > $price) {
                    $min = $c;
                }
                if ($max == 0 || $max < $price) {
                    $max = $c;
                }
            }
            //exit;
            $result[$key]['min'] = $min;
            $result[$key]['max'] = $max;
            $result[$key]['recommend'] = round($summ / $count, 2);
            $result[$key]['list'] = $list;
        }

        return $result;
    }

    private function prepareUrl($url, $data)
    {
        $result = $url;
        foreach ($data as $key => $value) {
            $result = str_replace($key, $value, $result);
        }

        return $result;
    }

    private function sendError($message)
    {
        echo json_encode(
            array('error' => $message)
        );
        exit;
    }

    public function sleep()
    {
        $sleep = rand(4, 6);
        sleep($sleep);
    }
}

$db = DB::instance();
$advertisement = $db->select("SELECT * FROM `i` WHERE `id` = 1")->find();
$time = date('H', time());
//var_dump($advertisement); exit;

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'getListInfo') {
    $connector = Connector::instance($advertisement->login_minfin, $advertisement->password_minfin);

    echo json_encode($connector->getStatistic());
    exit;
}

//if (isset($argv[1]) && $argv[1] == 'update') {
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update') {
    if((int) $time > (int) $advertisement->live || (int) $time < (int) $advertisement->start) {
        echo 'published in ' . $advertisement->start . ':00 to ' . $advertisement->live . ':00';
        exit;
    }
    $connector = Connector::instance($advertisement->login_minfin, $advertisement->password_minfin);
    $connector->removeOldAdvertisement();
    $connector->addAdvertisement($advertisement);
    echo 'updated';
    exit;
}
