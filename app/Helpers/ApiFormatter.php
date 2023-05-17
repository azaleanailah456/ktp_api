<?php
//file ini mengatur proses pengambilan API
//namespace : mengatur posisi file ada di folder mana
namespace App\Helpers;

class ApiFormatter{
    //membuat variable static, berupa array (variable yg akan dihasilkan ketika API digunakan)
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    public static function createAPI($code = NULL, $message = NULL, $data = NULL)
    {
        //mengisi data ke variable $response yg diatas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        //mengembalikan hasil pengisian data $response dengan format json
        return response()->json(self::$response, self::$response['code']);
    }
}

?>