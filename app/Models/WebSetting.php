<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WebSetting extends MongoModel {
    
    protected $connection = 'mongodb';

    protected $table = 'os_websettings';

    protected $fillable = [
        'version',
        'whatsapp_vendor_name',
        'whatsapp_vendor_api_url',
        'whatsapp_vendor_api_key',
        'mail_vendor_name',
        'mail_vendor_api_url',
        'mail_vendor_api_key',
        'affiliate_enabled',
        'model_version',
    ];

    protected $hidden = [
        'whatsapp_vendor_api_key',
        'mail_vendor_api_key',
        '_id',
        'model_version',
        'updated_at',
        'created_at',
    ];

    public static function modelVersion() {
        return 1;
    }

    public static function getDefault() {
        $output = array_fill_keys(self::getProps(), null);

        $output['version'] = config('webapp.version');
        $output['model_version'] = self::modelVersion();
        $output['whatsapp_vendor_name'] = config('webapp.whatsapp_name');
        $output['whatsapp_vendor_api_url'] = config('webapp.whatsapp_api_url');
        $output['whatsapp_vendor_api_key'] = config('webapp.whatsapp_api_key');
        $output['mail_vendor_name'] = config('webapp.mail_name');
        $output['mail_vendor_api_url'] = config('webapp.mail_api_url');
        $output['mail_vendor_api_key'] = config('webapp.mail_api_key');
        $output['affiliate_enabled'] = config('webapp.affiliate_enabled');
        $output['register_validation_expires'] = config('webapp.register_validation_expires');

        return $output;
    }

    public function transform() {
        foreach(self::getDefault() as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}