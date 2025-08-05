<?php

class ResponseHelper {
    public static function success($message, $data = [], $code = 200) {
        http_response_code($code);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    public static function error($message, $code = 400) {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }
    public static function validateYear($year) {
        $currentYear = (int)date('Y');
    
        if (!is_numeric($year)) {
            self::error("Year must be numeric.");
        }
    
        if (strlen((string)$year) !== 4) {
            self::error("Year must be 4 digits.");
        }
    
        if ((int)$year < 1900) {
            self::error("Year cannot be earlier than 1900.");
        }
    
        if ((int)$year > $currentYear) {
            self::error("Year cannot be greater than the current year ($currentYear).");
        }
    
        return true; // Valid year
    }
}