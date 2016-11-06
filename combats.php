<?php
define('API_KEY', 'zp3kitpic');
define('login', 'Megabot');
define('password', 'zp3kitpic');

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
        'index' => 'http://www.combats.com/',
        'from' => 'combats.ru',
        'login' => 'http://capitalcity.combats.com/enter.pl',
        'main' => '{city}main.pl',
        'zayavka' => '{city}zayavka.pl',
        '1n1' => '{city}zayavka.pl?level=fiz',
        'battle' => '{city}battle3.pl',
        'home' => 'http://demonscity.combats.com/main.pl?homeworld=0.80240079893635',
    );

	public $_content = '';
	
	private $_city = 'http://demonscity.combats.com/';
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
		if (is_file(__DIR__ . "/cookies_tmp/city.txt")) {
			$this->_city = file_get_contents(__DIR__ . "/cookies_tmp/city.txt");
		}
		//$content = $this->connect($this->prepareUrl($this->url['main'], array('{city}' => $this->_city)));
		$content = $this->connect($this->prepareUrl($this->url['battle'], array('{city}' => $this->_city)));
		//file_put_contents('response.txt', $content);

		if ($this->checkGame($content) === true){
			$this->_content = $content;
		} else {
			$response = $this->connect($this->url['login'],
                array(
                    'login' => self::$_login,
                    'psw' => self::$_password,
                ),
                $this->url['index']
			);
		//file_put_contents('response.txt', $response);
		//exit;
		// В случае удачи получим 
		// <HTML><BODY onload="document.F1.submit()"><FORM name=F1 method=POST action="http://demonscity.combats.com/enter.pl" target=_top><input type=hidden name=from  value="combats.ru"><input type=hidden name=sid value="1440283964132234204628490574.1271857"></FORM></BODY></HTML>
		//file_put_contents('responce.txt', $response);
        if ($this->checkAuthorization($response) === false) {
            echo "not auth";
            exit;
        } else {
			preg_match('/<FORM name=F1 method=POST action="(.*)" target=_top>/', $response, $url);
			$this->_city = str_ireplace('enter.pl', '', $url[1]);
			file_put_contents(__DIR__ . "/cookies_tmp/city.txt", $this->_city);
			preg_match('/<input type=hidden name=sid value="(.*)">/', $response, $sid);
			$response = $this->connect($url[1],
                array(
                    'from' => $this->url['from'],
                    'sid' => $sid[1],
                ),
                $this->url['login']
            );
			//$this->_content = $response;
			$content = $this->connect($this->prepareUrl($this->url['main'], array('{city}' => $this->_city)));
			$this->_content = $content;
			file_put_contents('auth.txt', $content);
        }
		}
    }

    private function connect($link, $post = null, $referer = false)
    {
        //echo 'POST of link ' . $link . ':';
        //var_dump($post);
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
        //$header[] = "Origin: http://www.combats.com";
        $header[] = "Upgrade-Insecure-Requests: 1";
        $header[] = "Pragma: no-cache"; // browsers keep this blank.
        curl_setopt($ch, CURLOPT_URL,$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, sdch');
        // если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36');
        // елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
        curl_setopt ($ch, CURLOPT_REFERER, $referer);
        curl_setopt ($ch, CURLOPT_VERBOSE, 1);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt ($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . "/cookies_tmp/" . "cookie_bk.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . "/cookies_tmp/" . "cookie_bk.txt");

        if($post !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
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
	// <HTML><BODY onload="document.F1.submit()"><FORM name=F1 method=POST action="http://demonscity.combats.com/enter.pl" target=_top><input type=hidden name=from  value="combats.ru"><input type=hidden name=sid value="1440283964132234204628490574.1271857"></FORM></BODY></HTML>
		
    private function checkAuthorization($html)
    {
        if(strpos($html, 'document.F1.submit') === false) {
            return false;
        } else {
            return true;
        }

    }
	//<HTML><BODY><script>top.location.href="/index.html";</script></BODY></HTML>
    private function checkGame($html)
    {
        if(strpos($html, '<HTML><BODY><script>top.location.href="/index.html";</script></BODY></HTML>') === false) {
            return true;
        } else {
            return false;
        }

    }

	public static function getInfo()
	{
		$info = file_get_contents('http://capital.combats.com/inf.pl?' . self::$_login);
		preg_match('/<script>top.setHP\((.*)\);<\/script>/', $info, $hp);
		preg_match(iconv("utf-8", "windows-1251", '/Уровень: (.*)<BR>/'), $info, $level);
		preg_match(iconv("utf-8", "windows-1251", '/Побед: (.*)<\/A><BR>/'), $info, $win);
		preg_match(iconv("utf-8", "windows-1251", '/Поражений: (.*)<BR>/'), $info, $loss);
		$hp = explode(',', $hp[1]);

		return array(
			'hp' => $hp,
			'level' => $level[1],
			'win' => $win[1],
			'loss' => $loss[1],
		);
	}
	
	public function create1n1()
	{
		$content = $this->connect($this->prepareUrl($this->url['1n1'], array('{city}' => $this->_city)));

		preg_match('/<INPUT TYPE=hidden name=my_id value=(.*)>/', $content, $my_id);

		if(isset($my_id[1])) {
				$response = $this->connect(
				$this->prepareUrl($this->url['zayavka'], array('{city}' => $this->_city)),
                array(
                    'level' => 'fiz',
                    'my_id' => $my_id[1],
                    'open' => iconv("utf-8", "windows-1251", 'Подать заявку'),
                ),
                $this->prepareUrl($this->url['1n1'], array('{city}' => $this->_city))
			);
		}
		file_put_contents('battle.txt', $response);
		//var_dump($response);
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

	$connector = Connector::instance(login, password);

//location.href='zayavka.pl?level=fiz&my_id=850025370&open=1&from_quick_butt=1';
	while(true) {
		$info = Connector::getInfo();
		//$connector->create1n1();
		echo $connector->_content;
		break;
	}
