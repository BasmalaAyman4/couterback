<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HelperApi;
use App\Models\Counter;
use Illuminate\Http\Request;

class ApisController extends Controller
{
    use HelperApi;

    public function count(Request $request){
        try {
            $count = Counter::where('barcode', $request->barcode)->first();
            if ($count){
                $count->quantity = $count->quantity + 1;
                $count->save();
            }else{
               $count = Counter::create([
                    'barcode' => $request->barcode,
                    'quantity' => 1,
                ]);
            }
            return $this->onSuccess(200, 'success', $count);
        } catch (\Throwable $error) {
            return $this->onError(500, trans('site.server_error'), $error->getMessage());
        }
    }

    public function getData()
    {
        try {
            $counters = Counter::all();
            return $this->onSuccess(200, 'all data', $counters);
        }catch (\Throwable $error) {
            return $this->onError(500, trans('site.server_error'), $error->getMessage());
        }
    }
}
