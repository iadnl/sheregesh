<?php
/*
  проверка прав доступа по прямому обращению к файлам из объявленного списка путей и прав
  в связке с mod_rewrite

  сервер работает в связке Nginx и apache, nginx отвечает за статику и отдает файлы (список ниже)
  apache отвечает за динамику
  Если в каталоге есть файл .htaccess то nginx не будет отдавать статические файлы и наоборот

  Вот полный список расширений:
  txt | ico | gz | rar | zip | tar | bz | bz2 | exe | flv | swf | gif | jpg | jpeg | png | pcx | bmp | tif | tiff | html | htm | xhtml | js | css

 */
namespace Core;

class Access {

    // проверка на доступ по группа (возврат true или false)
    public function allowGroup($degrees = []) {
        $session = new \Core\Session;
        $user_degree = $session->getUserDegree();
        if (in_array($user_degree, $degrees)) {
            return true;
        } else {
            return false;
        }
    }
    public function userAuth() {
        $session = new \Core\Session;

        if ($session->userIsAuth()) {
            $user = new \Models\User;
            $user_id = $session->getUserId();
            if ($user->isUserById($user_id) && !$user->isUserBlocked($user_id)) {
                return true;
            } else {
                $session->logout();
            }
        } else {
            return false;
        }
    }
    public function onlyGroupOtherDenied($degrees = []) {
        $session = new \Core\Session;
        $view = new \Core\View;
        
        $user_degree = $session->getUserDegree();
        if (!in_array($user_degree, $degrees)) {
            $view->notFound();
        }
    }

    // массив путей для доступа к каталогам по обработке пути файла
    private $config = [
        //        [
        //            'path_dir' => ['/asset/css/panel/'], // массив строк, полный путь к каталогу
        //            'degree' => [3], // массив числовой от 0 до 3 
        //            'types' => ['css'], // массив строк, типы данных
        //        ],
        [
            'path_dir' => [
            ],
            'degree' => ['admin'],
            'types' => '*', // все типы
        ],
        [
            'path_dir' => [
                '/panel/asset/js/',
                '/panel/asset/option-page/',
                '/panel/asset/css/',
                '/panel/asset/fonts/',
                '/panel/asset/fonts/f-aw/',
                '/robots.txt',
            ],
            'degree' => ['admin'],
            'types' => '*',
        //'types' => ['js', 'jpg', 'png', 'css', 'woff2'],
        ],
    ];

    public function check() {
        $url = new \Core\Url;
        $view = new \Core\View;
        $session = new \Core\Session;

        $path_file = $url->getPath();
        $degree = $session->getUserDegree();
        //echo SITE_DIR.'/'.$path_file;
        // проверка наличия запрашиваемого файла
        if (is_file($path_file)) {
            //получение типа файла из пути и имени файла по "."
            $path_arr = explode('.', $path_file);
            $type_file = array_pop($path_arr);
            // формирование пути к каталогу
            $url_str = parse_url(trim($path_file, '/'), PHP_URL_PATH);
            $url_arr = explode('/', $url_str);
            array_pop($url_arr);
            $path_dir = '/' . implode('/', $url_arr) . '/';

            $allow = false;
            //проверка вхождения пути к файлу в путь к каталогу	
            foreach ($this->config as $value) {
                if (in_array($path_dir, $value['path_dir'], true)) {
                    $allow = true;
                    break;
                }
            }
            if ($allow === false) {
                //echo $path_dir;
                echo 'cat';
                $view->notFound();
            }
            $allow = false;
            //проверка доступа к файлу по degree
            foreach ($this->config as $value) {
                if ((in_array($degree, $value['degree'], true)) || (in_array(0, $value['degree'], true))) {
                    $allow = true;
                    break;
                }
            }
            if ($allow === false) {
                echo 'deg';
                $view->notFound();
            }
            //проверка доступа разрешенного типа файла
            $allow = false;
            foreach ($this->config as $value) {
                if ((!is_array($value['types'])) && ($value['types'] === '*')) {
                    $allow = true;
                    break;
                }
                if (in_array($type_file, $value['types'], true)) {
                    $allow = true;
                    break;
                }
            }
            if ($allow === false) {
                echo 'type';
                $view->notFound();
            }

            //после проверки доступа отдаем файл 
            if ($type_file === 'php') {
                require_once($path_file);
                exit();
            } else {
                header('Cache-Control: public, max-age=604800');
                header("Pragma: cache");
                header('Content-type: ' . $this->mime_content_type($path_file) . ';');
                readfile($path_file);
                exit();
            }
        }
    }

    // получение mime типа файла
    private function mime_content_type($filename) {

        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $arr_path = explode('.', $filename);
        $ext = array_pop($arr_path);
        $ext = mb_strtolower($ext, 'UTF-8');
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }

}
