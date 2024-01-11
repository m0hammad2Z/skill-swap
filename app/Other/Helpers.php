<?php

// Here is some helpers functions that you can use in your project

// Return a json respnse with a message
function jsonResponese($success, $message, $status){
    return response()->json([
        'success' => $success,
        'message' => $message,
    ], $status);
}

// Return a json respnse with a message and data
function jsonResponeseWithData($success, $message, $data, $status){
    return response()->json([
        'success' => $success,
        'message' => $message,
        'data' => $data,
    ], $status);
}

?>