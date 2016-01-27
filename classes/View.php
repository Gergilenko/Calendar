<?php

namespace app\classes;


class View {


    protected $data =[];

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function __get($key) {
        return $this->data[$key];
    }

    public function __isset($attr) {
        return isset($this->data[$attr]);
    }

    public function display($template) {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }
        include __DIR__ . '/../views/' . $template;
    }

    public static function redirect($url) {
        header('Location: ' . SITE_ROOT . $url);
    }

}