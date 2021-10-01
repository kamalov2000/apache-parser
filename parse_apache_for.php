<?php
$time_start = microtime(true);

$filename = __DIR__ . './text.txt';

//function checkFile($path_to_file)
//{
//    if (file_exists($path_to_file) && file_get_contents($path_to_file)) {
//        $data_log_file = file_get_contents($path_to_file);
//    } else {
//        echo 'Файл по такому пути не существует';
//    }
//    echo "<pre>";
//    getFileData($data_log_file);
//
////    return $data_log_file;
//
//}
//
//function getFileData($path)
//{
//    $data = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//
////    getArrayFromData($data);
//
////    return $data;
//
//}


function oneMillinString()
{
    $handle = fopen("example.txt", "r");

//    $array_100_element = [];
//    if ($handle) {
//        while (($line = fgets($handle)) !== false) {
//            $total_lines++;
//            $array_100_element[] = $line;
//            if ($total_lines = 10) {
//                foreach ($array_100_element as $dat) {
////                    getParseLog($dat);
//
//                }
//            }
//            if(strlen($line) <= 30) {
//                $short_lines++;
//            }
//        }
//
//echo "<pre>";
//        fclose($handle);
//    }


    if ($handle) {
        $i = 0;
//        $new = [];
        while (($buffer = fgets($handle, 4096))) {
            $new[$i] = $buffer;
            ++$i;
            if ($i > 20000) {
                getParseLog($new);
                $i = 0;
                $new = [];
            }

        }
        getParseLog($new);
    }
}
oneMillinString();

//function getArrayFromData($data_result)
//{
//    $filename = __DIR__ . '/example.txt';
//
//    $handle = fopen($filename, "r");
//
//    $result_array_buffer = [];
//
//    if ($handle) {
//
//        while (($buffer = fgets($handle, 4096)) !== false) {
//            $result_array_buffer[] = explode(' ', $buffer);
//
//        }
//
//        if (!feof($handle)) {
//            echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
//        }
//        fclose($handle);
//    }
//
//    getParseLog($result_array_buffer);
//
////    return $result_array_data;
//
//}

//function lines($file)
//{
//    // в начале ищем сам файл. Может быть, путь к нему был некорректно указан
//    if(!file_exists($file))exit("Файл не найден");
//    $a = file_get_contents($file);
//    // рассмотрим файл как массив
//    $file_arr = file($file);
////    for ($i = 0; $i < 1; ++$i) {
////        file_put_contents($file, $a, FILE_APPEND);
////    }
//    // подсчитываем количество строк в массиве
//    $lines = count($file_arr);
//
//    // вывод результата работы функции
//    return $lines;
//
//}
//
//echo lines("example_copy.txt"); // выводим число - количество строк в файле index.php

function getParseLog($array_result)
{

    global $array;

//    $time_start = microtime(true);

    $count_string = sizeof($array_result);
    $array_urls = [];
    $result = [];
    $summ_traffic = 0;
    $status_code_200 = 0;
    $status_code_301 = 0;
    $count_urls = 0;
    $count_google = 0;
    $count_Bing = 0;
    $count_baidu = 0;
    $count_yandex = 0;

    foreach ($array_result as  $dat) {
        $broken_array = explode(" ", $dat);

        switch ($broken_array[8]) {
            case '200' :
                ++$status_code_200;
                break;
            case '301' :
                ++$status_code_301;
        }

        $array_16  = $broken_array[16];

        if (str_contains($array_16, 'Google') == true) {
            ++$count_google;
        } else if (str_contains($array_16, 'Bing') == true) {
            ++$count_Bing;
        } else if (str_contains($array_16, 'Baidu') == true) {
            ++$count_baidu;
        } else if (str_contains($array_16, 'Yandex') == true) {
            ++$count_yandex;
        }

        $result['views'] = $count_string;

        if (!in_array($broken_array[6], $array_urls)) {
            $array_urls[] = $broken_array[6];
            ++$count_urls;
        }

        $result['urls'] = $count_urls;

        if ($broken_array[8] == '200') {
            $summ_traffic += (int)$broken_array[9];
        }

        $result['traffic'] = $summ_traffic;
        $result['crawlers'] = [
            'Google' => $count_google,
            'Bing' => $count_Bing,
            'baidu' => $count_baidu,
            'yandex' => $count_yandex,
        ];
        $result['status_code'] = [
        '200' => $status_code_200,
        '301' => $status_code_301,
        ];



    }



//print_r($result);

    $array[] = $result;

    echo "<pre>";
//    print_r($array);
    echo "</pre>";
//    $time = microtime(true) - $time_start;
//    print_r($time);
    createJson($array);
    return $array;



}


function createJson($data_5)
{
    $post_data = file_put_contents('./my.json', json_encode($data_5, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION));
//    return $post_data;
}

//checkFile($filename);

//$get_file_data = getFileData($file_name);
//getArrayFromData($data);
$time = microtime(true) - $time_start;
print_r($time);
