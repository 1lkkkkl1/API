<?php 

function err_handler2($errno, $errmsg, $filename, $linenum){
    GLOBAL $DB;

    $path_error_log = "../error.log";
    $date = date("Y-m-d H:i:s (T)");

    echo(json_encode(array(
        "error" => true,
        "type" => "FATAL_ERROR",
        "title" => "Критическая ошибка!",
        "desc" => $errmsg,
        "line" => $linenum,
        "errno" => $errno,
        "filename" => $filename,
        "datetime" => array(
            'Y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
            'H' => date('H'),
            'i' => date('i'),
            's' => date('s'),
            'full' => date('Y-m-d H:i:s'),
        )
    )));

    file_put_contents($path_error_log, json_encode(array(
        "date" => $date,
        "desc" => $errmsg,
        "file" => $filename,
        "line" => $linenum,
        "errno" => $errno,
    ))."\r\n", FILE_APPEND);

    exit;

    // $connection = @mysqli_connect(
    //     $DB['host'],
    //     $DB['login'],
    //     $DB['password'],
    //     $DB['name'],
    // );

    // $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // $text_query = "INSERT INTO `errors`(
    //     `token_id`,
    //     `errno`,
    //     `error_msg`,
    //     `file`,
    //     `linenum`,
    //     `user_agent`
    // ) VALUES (
    //     'ewB7KWREU1ukLJioZ7nQcxdqqviDOX5y',
    //     '$errno',
    //     '$errmsg',
    //     '$filename',
    //     '$linenum',
    //     '$user_agent'
    // );";
    // $res = @mysqli_query($connection, $text_query);

}

set_error_handler('err_handler2');