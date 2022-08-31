<?php

namespace App\Services;

use App\Models\WebSetting;


class Setting {
    private static $instance;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected $settings;
    protected $model;

    public function __construct() {
        $this->model = WebSetting::first();

        if (is_null($this->model)) {
            $this->model = new WebSetting();
            $this->model->fill(WebSetting::getDefault());
            $this->model->save();
        }

        $this->settings = $this->model->transform();
    }

    public function get($key) {
        return $this->settings[$key];
    }

    public function set($key, $value) {
        if (!in_array($key, WebSetting::getProps())) {
            return false;
        }

        $this->settings[$key] = $value;
        $this->model->{$key} = $value;
    }

    public function setSave($key, $value) {
        if (!in_array($key, WebSetting::getProps())) {
            return false;
        }

        $this->settings[$key] = $value;
        $this->model->{$key} = $value;
        $this->model->save();
    }

    public function save($key, $value) {
        $this->model->save();
    }
}