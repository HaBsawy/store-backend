<?php


namespace App\Helper;


class JsonResponder
{
    public static function make($data, $success = true, $status = 200, $msg = null)
    {
        return response()->json([
            'status'    => $status,
            'success'   => $success,
            'msg'       => $msg,
            'payload'   => $data
        ], $status);
    }
}
