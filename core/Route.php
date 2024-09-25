<?php
namespace Core;

class Route {
    public function init() {
        $url = new \Core\Url;
        $class_name = $url->getClassName();
        $method_name = $url->getMethodName();
        if ($class_name === 'panel') {
            $rout = new \Panel\Rout;
            $rout->init();
        }
        if ($class_name === 'page') {
            $static = new \Core\StaticPage;
            $static->init($method_name); 
        }
        if (is_file('../controllers/' . ucfirst($class_name) . '.php')) {
            $class_path = "\\Controllers\\$class_name";
            $obj = new $class_path;
            $method_name = $this->convertToMethodName($method_name);
            $class_methods = get_class_methods($class_path);
            if (method_exists($obj, $method_name) && in_array($method_name, $class_methods)) {
                $obj->$method_name();
            }
        }
        $page_object = new \Core\Page;
        $page_object->init();
    }

//---------------private-----------
    private function convertToMethodName($str) {
        $arrStr = explode('-', $str);
        $res = array_shift($arrStr);
        foreach ($arrStr as $key => $value) {
            $arrStr[$key] = ucfirst($value);
        }
        $res .= implode('', $arrStr);
        return $res;
    }

}
