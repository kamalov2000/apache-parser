<?php
$time_start = microtime(true);

function checkFile()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data['name'] = $_POST['firstName'];
    }

    $path_to_file = __DIR__ . './' . $data['name'];

    if (file_exists($path_to_file) && file_get_contents($path_to_file)) {
      echo "<pre>";
      getFileData($path_to_file);

      $j = file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . 'my.json' );
      $data = json_encode(json_decode($j), JSON_PRETTY_PRINT);

      echo '<pre>' . $data . '</pre>';
    } else {
        echo 'Файл по такому пути не существует';
        die;
    }

}

function getFileData($path)
{
    $handle = fopen($path, "r");

    processingOneMillinString($handle);


    return $handle;
}

function processingOneMillinString($resource_id)
{
    if ($resource_id) {
        $i = 0;
        $new = [];
        while (($buffer = fgets($resource_id, 4096))) {
            $new[$i] = $buffer;
            ++$i;
            if ($i > 200000) {
                getParseLog($new);
                $i = 0;
                $new = [];
            }

        }
        getParseLog($new);
    }

}

function getParseLog($array_result)
{
    global $last_array;
    global $array_urls;
    global $array_urls_2;

    $count_string = sizeof($array_result);
    $array_urls = [];
    $result = [];
    $sum_traffic = 0;
    $status_code_200 = 0;
    $status_code_301 = 0;
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
            $array_urls[] = $broken_array[6]; // сохранить урл для подсчета
        }

       $result['urls'] = $array_urls;

       if ($broken_array[8] == '200') {
           $sum_traffic += (int)$broken_array[9];
       }

       $result['traffic'] = $sum_traffic;

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

    $last_array[] = $result;

    formationOfTheLastArray($last_array);

}

function formationOfTheLastArray($resulting_array)
{
    $final_array = [];
    $array_urls_2 = [];

    foreach ($resulting_array as $key => $value) {
      $unique = array_unique($value['urls']);
      $resulting_array[$key]['urls'] = $unique;

      if ( !in_array($resulting_array[$key]['urls'], $array_urls_2) ) {
        $array_urls_2[] = $resulting_array[$key]['urls'];
      }
    }

    $merge_urls = array_merge(...$array_urls_2);
    $uniaue_urls = array_unique($merge_urls);
    $count_urls = sizeof($uniaue_urls);


    foreach ($resulting_array as $all_arrays) {

        foreach ($all_arrays as $key_array => $value_array) {

          if ( is_numeric($value_array) ) {
            if ( isset($final_array[$key_array]) ) {
                $final_array[$key_array] = $final_array[$key_array] + $value_array;
            } else {
                $final_array[$key_array] = $value_array;
            }
          }

          if( is_array($value_array) ) {
            foreach ($value_array as $type => $score) {
                if ( isset($final_array[$key_array][$type]) ) {
                    $final_array[$key_array][$type] += (int) $score;
                } else {
                    $final_array[$key_array][$type] = (int) $score;
                }
            }
          }

        }

    }

    $final_array['urls'] = $count_urls;

    createJson($final_array);


    return $resulting_array;
}

function createJson($data_5)
{
    $post_data = file_put_contents('./my.json', json_encode($data_5, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION));

}

checkFile();

$time = microtime(true) - $time_start;
echo "<pre>";
echo "А вот и время выполнения ";
print_r($time);
