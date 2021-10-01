<?php


$filename = __DIR__ . './text.txt';

function checkFile($path_to_file)
{
    if (file_exists($path_to_file) && file_get_contents($path_to_file)) {
        $data_log_file = file_get_contents($path_to_file);
    } else {
        echo 'Файл по такому пути не существует';
    }
print_r($data_log_file);
    echo "<pre>";
    getFileData($data_log_file);

    return $data_log_file;

}

function getFileData($path)
{
    $data = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    getArrayFromData($data);

    return $data;

}

function getArrayFromData($data_result)
{
    $result_array_data = [];

    foreach ($data_result as $key => $dat) {
        $array_from_data = explode(' ', $dat);
        array_push($result_array_data, $array_from_data);
    }
//print_r($result_array_data);
    getParseLog($result_array_data);

    return $result_array_data;

}

function getParseLog($array_result)
{

    $time_start = microtime(true);

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

//print_r($array_result);
//        for ($i = 0; $i < $count_string; ++$i) {
    foreach ($array_result as $key => $dat) {
//print_r($array_result[$key][16]);
        switch ($array_result[8]) {
            case '200' :
                ++$status_code_200;
                break;
            case '301' :
                ++$status_code_301;
        }

        $array_16  = $array_result[$key][16];

        if (str_contains($array_16, 'Google') == true) {
            ++$count_google;
        } else if (str_contains($array_16, 'Bing') == true) {
            ++$count_Bing;
        } else if (str_contains($array_16, 'Baidu') == true) {
            ++$count_baidu;
        } else if (str_contains($array_16, 'Yandex') == true) {
            ++$count_yandex;
        }

        $result[$key]['views'] = $count_string;

        if (!in_array($array_result[$key][6], $array_urls)) {
            array_push($array_urls, $array_result[$key][6]);
            ++$count_urls;
        }

        $result[$key]['urls'] = $count_urls;

        if ($array_result[$key][8] == '200') {
            $summ_traffic += (int)$array_result[$key][9];
        }

        $result[$key]['traffic'] = $summ_traffic;
        $result[$key]['crawlers'] = [
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
    $time = microtime(true) - $time_start;
    print_r($time);
    $fruit = array_pop($result);
//    print_r($result);
    createJson($fruit);
    return $fruit;


}

function createJson($data_5)
{
    $post_data = file_put_contents('./my.json', json_encode($data_5, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION));
    return $post_data;
}

checkFile($filename);
//$get_file_data = getFileData($file_name);
//getArrayFromData($data);
