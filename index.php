<?php 

include_once("config.php");
include_once("err_handler.php");
include_once("db_connect.php");
include_once("functions.php");
include_once("find_token.php");

if(!isset($_GET['type'])) {
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали GET параметр type", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

//!3) Операции на вывод записей (Минимум 5 операций)!//

if(preg_match_all("/^(list_users)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `second_name`, `first_name`, `middle_name`, `gender` FROM `users`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список покупателей", // Заголовок ответа
        "Вывод списка покупателей", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

if(preg_match_all("/^(list_product)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `name`, `price` FROM `product`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список товаров", // Заголовок ответа
        "Вывод списка товаров", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

if(preg_match_all("/^(list_bought_products)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `product_id`, `user_id` FROM `bought_products`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список купленных товаров", // Заголовок ответа
        "Вывод списка купленных товаров", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

if(preg_match_all("/^(list_comments)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `product_id`, `user_id`, `comment`, `date_of_append` FROM `comments`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список отзывов", // Заголовок ответа
        "Вывод списка отзывов", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

if(preg_match_all("/^(list_clients_api)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `token`, `date_of_created` FROM `clients_api`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список токенов", // Заголовок ответа
        "Вывод списка токенов", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

//!1) Операции на добавление новых записей (Минимум 3 операции)!//

else if(preg_match_all("/^(add_users)$/ui", $_GET['type'])){

    if(!isset($_GET['second_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр second_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['first_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр first_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['middle_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр middle_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['gender'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр gender", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "INSERT INTO `user`(
        `first_name`, 
        `second_name`, 
        `middle_name`, 
        `gender`) VALUES (
            '" . $_GET['first_name'] . "',
             '". $_GET['second_name'] ."',
             '". $_GET['middle_name'] ."',
             '". $_GET['gender'] ."'
             )";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", // Заголовок ответа
        "Новый покупатель успешно добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

else if(preg_match_all("/^(add_product)$/ui", $_GET['type'])){

    if(!isset($_GET['name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['price'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр price", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "INSERT INTO `product`(`name`, `price`) VALUES ('" . $_GET['name'] . "', '". $_GET['price'] ."')";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", // Заголовок ответа
        "Новый товар успешно добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

else if(preg_match_all("/^(add_comment)$/ui", $_GET['type'])){
    
    if(!isset($_GET['product_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр product_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['user_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['comment'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр comment", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $query = "INSERT INTO `comments`(`product_id`, `user_id`, `comment`) VALUES ('" . $_GET['product_id'] . "', '". $_GET['user_id'] ."', '". $_GET['comment'] ."')";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", // Заголовок ответа
        "Новый отзыв о товаре успешно добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

//!2) Операции на редактирование записей (Минимум 3 операции)!//

else if(preg_match_all("/^(upd_users)$/ui", $_GET['type'])){

    if(!isset($_GET['second_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр second_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['first_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр first_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['middle_name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр middle_name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['gender'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр gender", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $query = "UPDATE `users` SET 
        `second_name` = '". $_GET['second_name'] ."',
        `first_name` = '". $_GET['first_name'] ."', 
        `middle_name` = '". $_GET['middle_name'] ."',
        `gender` = '". $_GET['gender'] ."'
        WHERE `id` = '". $_GET['id'] ."'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Обновление информации о покупателе прошло успешно", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

else if(preg_match_all("/^(upd_product)$/ui", $_GET['type'])){

    if(!isset($_GET['name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['price'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр price", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "UPDATE `product` SET `name` = '". $_GET['name'] ."', `price` = '". $_GET['price'] ."' WHERE `id` = '". $_GET['id'] ."'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", // Заголовок ответа
        "Обновление информации о товаре прошло успешно", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

else if(preg_match_all("/^(upd_bought_product)$/ui", $_GET['type'])){

    if(!isset($_GET['product_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр product_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['user_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['id'])) {
        echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали GET параметр id", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "UPDATE `bought_product` SET `product_id` = '". $_GET['product_id'] ."', `user_id` = '". $_GET['user_id'] ."' WHERE `id` = '". $_GET['id'] ."'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", // Заголовок ответа
        "Обновление информации о купленном товаре прошло успешно", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}