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
        'login' => 'https://passport.i.ua/login?',
        'add' => 'http://finance.i.ua/market/add/',
        'listBuy' => 'http://finance.i.ua/market/kiev/usd/?type=1',
        'listSell' => 'http://finance.i.ua/market/kiev/usd/?type=2',
        'remove' => 'http://finance.i.ua/market/delete/{id}',
    );

    private static $_instance = false;

    public static function instance($l = false, $p = false)
    {
        if(self::$_instance === false) {
            self::$_instance = new self($l, $p);
        }

        return self::$_instance;
    }

    private function __construct($l, $p)
    {
        self::$_login = $l;
        self::$_password = $p;

        $content = $this->connect($this->url['add']);
        if ($this->checkAuthorization($content) === false) {
            preg_match('/<input type="hidden" name="scode" value="(.*)" \/>/', $content, $hash);

            $response = $this->connect($this->url['login'],
                array(
                    '_subm' => 'lform',
                    'cpass' => '',
                    '_url' => 'http://finance.i.ua/market/add/',
                    '_rand' => '0.808818741235882',
                    'scode' => $hash[1],
                    'login' => self::$_login,
                    'pass' => self::$_password,
                ),
                $this->url['login']
            );
			$this->sleep();
            if ($this->checkAuthorization($response) === false) {
                echo "not auth";
                exit;
            }
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
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, sdch');
        // ???? ??????? ???????? HTTP User-agent, ?? ???????? ???? ?? ????????? ?????????? ?????????:
        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36');
        // ???? ?????????? ?????? ?????? ????????????, ?? ????????? ?????????? ????????? HTTP Referer:
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
            //@todo ???????? ????????????? ?????.
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $new_url);
            return $this->curl_exec_follow($ch);
        } else {
            self::$_loops = 0;
            return $temp;
        }
    }

    /**
     * ????????? ????????????? ?? ????????????.
     */
    private function checkAuthorization($html)
    {
        if(strpos($html, 'input type="text" name="login"') === false) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * ??????? ?????? ??????????.
     */
    public function removeOldAdvertisement()
    {
        while(true) {
            $content = $this->connect($this->url['listBuy']);
            preg_match('/a href="\/market\/delete\/(.*)\/"/', $content, $hash);

            if (empty($hash[1]) === true) {
                break;
            }

            $this->connect($this->prepareUrl($this->url['remove'], array('{id}' => $hash[1])));
			$this->sleep();
        }

        return true;
    }

    /**
     * ????????? ????? ??????????.
     *
     * fType 1 - buy | 2 - sell
     */
    public function addAdvertisement($advertisement, $statistic)
    {
        if ($advertisement->buyAmount > 0) {
            $this->connect($this->url['add'],
                array(
                    '_subm' => 'addForm',
                    'fType' => '1',
                    'fAmount' => $advertisement->buyAmount,
                    'fCurrency' => '840',
                    'fRatio' => $advertisement->buyPrice,
                    'fCity' => $advertisement->city,
                    'fDistrict' => iconv("utf-8", "windows-1251", $advertisement->district),
                    'fComment' => iconv("utf-8", "windows-1251", $advertisement->comment),
                    'fValid' => $advertisement->live,
                ),
                $this->url['add']
            );
			$this->sleep();
        }

        if ($advertisement->sellAmount > 0) {
            $this->connect($this->url['add'],
                array(
                    '_subm' => 'addForm',
                    'fType' => '2',
                    'fAmount' => $advertisement->sellAmount,
                    'fCurrency' => '840',
                    'fRatio' => $advertisement->sellPrice,
                    'fCity' => $advertisement->city,
                    'fDistrict' => iconv("utf-8", "windows-1251", $advertisement->district),
                    'fComment' => iconv("utf-8", "windows-1251", $advertisement->comment),
                    'fValid' => $advertisement->live,
                ),
                $this->url['add']
            );
			$this->sleep();
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
				if ($min == 0 || (float)$min[1] > $price) {
					$min = $c;
				}
				if ($max == 0 || (float)$max[1] < $price) {
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
		$connector = Connector::instance($advertisement->login, $advertisement->password);
		
		echo json_encode($connector->getStatistic());
		exit;
	}

	//if (isset($argv[1]) && $argv[1] == 'update') {
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update') {
		if((int) $time > (int) $advertisement->live || (int) $time < (int) $advertisement->start) {
			echo 'published in ' . $advertisement->start . ':00 to ' . $advertisement->live . ':00';
			exit;
		}
		$connector = Connector::instance($advertisement->login, $advertisement->password);
		$statistic = $connector->getStatistic();
		$connector->sleep();
		$connector->removeOldAdvertisement();
		$connector->addAdvertisement($advertisement, $statistic);
		echo 'updated';
		exit;
	}
