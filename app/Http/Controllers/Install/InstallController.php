<?php

namespace App\Http\Controllers\Install;

use App\Services\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    
    public function installDummy() {
        Setting::instance();
        $this->installUser();
    }

    private function installUser($masterDiscount) {
        $admin = Models\User::getDefault();
        $admin['first_name'] = 'John';
        $admin['last_name'] = 'Wick';
        $admin['password'] = password_hash("123456789", PASSWORD_BCRYPT, ['cost' => 12]);
        $admin['email'] = 'webstoryinc@gmail.com';
        $admin['phone'] = '6289508618321';
        $admin['roles'] = ['administrator'];
        $admin['is_on_whatsapp'] = true;
        $admin['user_status'] = 'active';
        $admin['affiliate_status'] = ['active'];
        $admin['api_key'] = strtolower(Str::random(36));

        $user1 = Models\User::where('email', $admin['email'])->first();
        if (!$user1) {
            $user1 = Models\User::create($admin);
        } else {
            $user1->update($admin);
            $user1->save();
        }

        // user1 discount
        $adminDiscountData = Models\Discount::getDefault();
        
        $adminDiscountData['discount_type'] = 'affiliate';
        $adminDiscountData['coupon_code'] = 'PROMO';
        $adminDiscountData['user_id'] = $user1->getId();
        $adminDiscountData['parent_id'] = $masterDiscount->getId();
        $adminDiscountData['reduction_status'] = 'inherit';

        $adminDiscount = Models\Discount::where('coupon_code', $adminDiscountData['coupon_code'])->first();
        if (!$adminDiscount) {
            $adminDiscount = Models\Discount::create($adminDiscountData);
        } else {
            $adminDiscount->update($adminDiscountData);
            $adminDiscount->save();
        }

        $user1->affiliate_codes = [$adminDiscount->getId()];
        $user1->save();

    }
}
