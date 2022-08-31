<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class MongoModel extends Model {
    
    protected $connection = 'mongodb';

    public function getId() {
        return $this->_id;
    }

    public function get_id() {
        return $this->_id;
    }

    public static function getProps() {
        return (new static())->fillable;
    }
}