<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    public function topup(Request $request)
    {
        // Inisialisasi inputan dari form
        $buyer_sku_code = $request->input('buyer_sku_code');
        $customer_no = $request->input('customer_no');
        $username = '[USERNAME ANDA]';
        $key = '[KEY ANDA]';
        $ref_id = $request->input('ref_id');
        $sign = md5($username . $key . $ref_id);

        // Membuat URL API dengan parameter yang diterima dari request
        $apiUrl = "https://api.digiflazz.com/v1/transaction";

        // Menggunakan Guzzle untuk membuat permintaan POST ke API
        $client = new Client();

        try {
            //ini desesuiakan dengan ruanglingkup digiflazz yang menerima json
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'username' => $username,
                    'buyer_sku_code' => $buyer_sku_code,
                    'customer_no' => $customer_no,
                    'ref_id' => $ref_id,
                    'sign' => $sign
                ],
            ]);

            $body = $response->getBody();
            $result = json_decode($body, true);

            // Lakukan sesuatu dengan $result, misalnya, tampilkan respon API.
            return response()->json($result);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
