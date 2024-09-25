<?php
namespace Core;

class Check {
    // проверка и получение изображения в соотвествии с запрошенным размером
    public function getImage($url, $size = 'full') {
        if (!$url) {
            return $url;
        }
        $result = $url;
        $file_name = mb_substr($url, 0, mb_strrpos($url, '.', -1, 'UTF-8'), 'UTF-8');
        $tmp = explode('.', $url);
        $file_extension = end($tmp);
        $full_path_catalog = $_SERVER['DOCUMENT_ROOT'] . '/web';

        if ($size === 'thumbnail') {
            $thumbnail = $file_name . '-thumbnail.' . $file_extension;
            if (file_exists($full_path_catalog . $thumbnail)) {
                return $thumbnail;
            }
        } elseif ($size === 'medium') {
            $medium = $file_name . '-medium.' . $file_extension;
            if (file_exists($full_path_catalog . $medium)) {
                return $medium;
            }
        } elseif ($size === 'large') {
            $large = $file_name . '-large.' . $file_extension;
            if (file_exists($full_path_catalog . $large)) {
                return $large;
            }
        }

        return $result;
    }

    // конвертация раскладки из en в ru
    public function switcher_en($word_ru) {
        $converter = array(
            'а' => 'f', 'б' => ',', 'в' => 'd', 'г' => 'u', 'д' => 'l', 'е' => 't', 'ё' => '`',
            'ж' => ';', 'з' => 'p', 'и' => 'b', 'й' => 'q', 'к' => 'r', 'л' => 'k', 'м' => 'v',
            'н' => 'y', 'о' => 'j', 'п' => 'g', 'р' => 'h', 'с' => 'c', 'т' => 'n', 'у' => 'e',
            'ф' => 'a', 'х' => '[', 'ц' => 'w', 'ч' => 'x', 'ш' => 'i', 'щ' => 'o', 'ь' => 'm',
            'ы' => 's', 'ъ' => ']', 'э' => "'", 'ю' => '.', 'я' => 'z',
            'А' => 'F', 'Б' => '<', 'В' => 'D', 'Г' => 'U', 'Д' => 'L', 'Е' => 'T', 'Ё' => '~',
            'Ж' => ':', 'З' => 'P', 'И' => 'B', 'Й' => 'Q', 'К' => 'R', 'Л' => 'K', 'М' => 'V',
            'Н' => 'Y', 'О' => 'J', 'П' => 'G', 'Р' => 'H', 'С' => 'C', 'Т' => 'N', 'У' => 'E',
            'Ф' => 'A', 'Х' => '{', 'Ц' => 'W', 'Ч' => 'X', 'Ш' => 'I', 'Щ' => 'O', 'Ь' => 'M',
            'Ы' => 'S', 'Ъ' => '}', 'Э' => '"', 'Ю' => '>', 'Я' => 'Z',
            '"' => '@', '№' => '#', ';' => '$', ':' => '^', '?' => '&', '.' => '/', ',' => '?',
        );

        $result = strtr($word_ru, $converter);
        return $result;
    }

    // конвертация раскладки из ru в en
    public function switcher_ru($word_en) {
        $converter = array(
            'f' => 'а', ',' => 'б', 'd' => 'в', 'u' => 'г', 'l' => 'д', 't' => 'е', '`' => 'ё',
            ';' => 'ж', 'p' => 'з', 'b' => 'и', 'q' => 'й', 'r' => 'к', 'k' => 'л', 'v' => 'м',
            'y' => 'н', 'j' => 'о', 'g' => 'п', 'h' => 'р', 'c' => 'с', 'n' => 'т', 'e' => 'у',
            'a' => 'ф', '[' => 'х', 'w' => 'ц', 'x' => 'ч', 'i' => 'ш', 'o' => 'щ', 'm' => 'ь',
            's' => 'ы', ']' => 'ъ', "'" => "э", '.' => 'ю', 'z' => 'я',
            'F' => 'А', '<' => 'Б', 'D' => 'В', 'U' => 'Г', 'L' => 'Д', 'T' => 'Е', '~' => 'Ё',
            ':' => 'Ж', 'P' => 'З', 'B' => 'И', 'Q' => 'Й', 'R' => 'К', 'K' => 'Л', 'V' => 'М',
            'Y' => 'Н', 'J' => 'О', 'G' => 'П', 'H' => 'Р', 'C' => 'С', 'N' => 'Т', 'E' => 'У',
            'A' => 'Ф', '{' => 'Х', 'W' => 'Ц', 'X' => 'Ч', 'I' => 'Ш', 'O' => 'Щ', 'M' => 'Ь',
            'S' => 'Ы', '}' => 'Ъ', '"' => 'Э', '>' => 'Ю', 'Z' => 'Я',
            '@' => '"', '#' => '№', '$' => ';', '^' => ':', '&' => '?', '/' => '.', '?' => ',',
        );

        $result = strtr($word_en, $converter);
        return $result;
    }
    // проверка строки только на буквы кирилицы, латиницы, цифр и пробела
    public function stringSymbols($str) {
        if (preg_match("/[^0-9a-zA-Zа-яёА-ЯЁ ]/u", $str)) {
            return true;
        } else {
            return false;
        }
    }
    // проверка логина на корректность
    public function login($str) {
        //if(preg_match("/^[a-zA-Z0-9]+$/",$str)) {
        if (preg_match("/[^0-9a-zA-Z]/u", $str)) {
            return true;
        } else {
            return false;
        }
    }
    //Проверка url страницы при добавлении
    public function urlPage($str) {
        if (preg_match("/^[a-zA-Z0-9_-]+$/", $str)) {
            return true;
        } else {
            return false;
        }
    }
    // Проверка на превышение минимального значения и на превышение максимального значения
    public function range($number, $min, $max) {
        if (($number >= $min) && ($number <= $max)) {
            return true;
        } else {
            return false;
        }
    }

    // Проверка на превышение минимального значения и на превышение максимального значения
    public function rangeStringLenght($string, $min, $max) {
        if ((mb_strlen($string, 'UTF-8') >= $min) && (mb_strlen($string, 'UTF-8') <= $max)) {
            return true;
        } else {
            return false;
        }
    }

    // Проверка на корректный email
    public function email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // проверка на корректность alt_name для статьи, "article_123"
    public function isUrlArticle($url) {
        if (preg_match("/^[a-zA-Z0-9_-]+_[0-9]+$/", $url)) {
            return true;
        } else {
            return false;
        }
    }

    // перевести числовую строку в формат с плавающей точкой
    public function toFloat($num_str) {
        $num = str_replace(' ', '', $num_str);
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
                ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
        return floatval(
                preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
                preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
        );
    }

}
