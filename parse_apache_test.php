<?php
$time_start = microtime(true);
class BigFile
{
    protected $file;
    public function __construct($filename, $mode = "r")
    {
        if (!file_exists($filename)) {
            throw new Exception("File not found");
        }
        $this->file = new SplFileObject($filename, $mode);
    }
    protected function iterateText()
    {
        $count = 0;
        while (!$this->file->eof()) {
            yield $this->file->fgets();
            $count++;
        }
        return $count;
    }
    protected function iterateBinary($bytes)
    {
        $count = 0;
        while (!$this->file->eof()) {
            yield $this->file->fread($bytes);
            $count++;
        }
    }
    public function iterate($type = "Text", $bytes = NULL)
    {
        if ($type == "Text") {
            return new NoRewindIterator($this->iterateText());
        } else {
            return new NoRewindIterator($this->iterateBinary($bytes));
        }
    }
}
$largefile = new BigFile("example.txt");
$iterator = $largefile->iterate("Text"); // Text or Binary based on your file type
foreach ($iterator as $line) {
    $asd[] = explode(' ', $line);

}
getParseLog($asd);
//$lines = file('example.txt');
//$last = sizeof($lines) - 1 ;
//unset($lines[$last]);

function getParseLog($array_result)
{
//print_r($array_result);
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

//    foreach ($array_result as $key => $dat) {
    for($i = 0; $i < $count_string; ++$i) {
//echo "<pre>";
//print_r($array_result[$i][8]);
//echo "</pre>";
        switch ($array_result[$i][8]) {
            case '200' :
                ++$status_code_200;
                break;
            case '301' :
                ++$status_code_301;
        }

        $array_16  = $array_result[$i][16];

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

        if (!in_array($array_result[$i][6], $array_urls)) {
            $array_urls[] = $array_result[$i][6];
            ++$count_urls;
        }

        $result['urls'] = $count_urls;

        if ($array_result[$i][8] == '200') {
            $summ_traffic += (int)$array_result[$i][9];
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

//    $array[] = $result;

    echo "<pre>";
    print_r($result);
    echo "</pre>";
//    $time = microtime(true) - $time_start;
//    print_r($time);
    createJson($result);
    return $result;



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


