<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback()
    {
        // set konfigurasi
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = Config('services.midtrans.isProduction');
        Config::$isSanitized = Config('services.midtrans.isSanitized');
        Config::$is3ds = Config('services.midtrans.is3ds');

        // instance notification 
        $notification = new Notification();
        
        // assign variable from midtrans 
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;       
        
        // get transaction id
        $order = explode('-', $order_id);

        // search transaction by id
        $transaction = Transaksi::findOrFail($order[1]);

        // notificaion status
        if($status == 'capture'){
            if($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }
                else{
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if($status == 'settlement'){
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'pending'){
            $transaction->status = 'PENDING';
        }
        else if($status == 'deny'){
            $transaction->status = 'PENDING';
        }
        else if($status == 'expire'){
            $transaction->status = 'CANCELED';
        }
        else if($status == 'cancel'){
            $transaction->status = 'CANCELED';
        };

        // save status from notification
        $transaction->save();
        
        // return response json ke midtrans
        return response()->json([
            'meta'  => [
                'code'  => 200,
                'message' => 'Midtrans Transaction Success !'
            ]
        ]);
    }
}
