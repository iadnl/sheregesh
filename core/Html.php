<?php
namespace Core;

class Html {
    public function escape($html) {
        if (is_array($html)) {
            foreach ($html as $key => $elem) {
                if (is_array($elem)) {
                    $html[$key] = $this->escape($elem);
                } else {
                    if ($elem) {
                        $html[$key] = htmlspecialchars($elem);
                    }
                }
            }
            return $html;
        } else {
            if ($html) {
                return htmlspecialchars($html);
            } else {
                return $html;
            }
            
        }
    }

} 