<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public static function handlingResponse($response_code)
    {
        $messages = [
            "100" => "Showing Data Success",
            "101" => "Showing Data Failed",
            "156" => "User not found",
            "300" => "Token Passed",
            "301" => "Token is not valid",
            "302" => "Token is Expired",
            "500" => "Data Successfully Created",
            "501" => "Data Successfully Updated",
            "502" => "Data Successfully Deleted",
            "503" => "Too Much Request",
            "504" => "Error sending data",
            "505" => "Data Already Exist!",
            "506" => "Customer can't be assigned to other Dealer",
            "600" => "New Token Successfully Created",
            "601" => "New Token on this ID Successfully updated",
            "602" => "Current Token is not expired yet!",
            "104" => "Data not Found!",
            "105" => "Wrong Username",
            "106" => "Wrong Username or Password",
            "1995" => "Access Denied",
            "2000" => "Internal Server Error",
            "2001" => "Format file is not correct",
            "2002" => "Format file is correct",
        ];

        return $messages[$response_code] ?? "Response Code Undefined";
    }

    public static function appResponse($responseCode, $data = null)
    {
        $responseMessage = self::handlingResponse($responseCode);
        $response = [
            'code' => $responseCode,
            'status' => $responseMessage,
            'data' => $data
        ];
        return response()->json($response);
    }

    
}
