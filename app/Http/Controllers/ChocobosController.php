<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChocobosServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ChocobosController extends Controller
{
    protected $chocobosServices;

    public function __construct(ChocobosServices $chocobosServices)
    {
        $this->chocobosServices = $chocobosServices;
    }

    public function index($fileName): mixed
    {
        $contents          = File::lines(storage_path('app/public/Chocobos/' . $fileName));
        $i                 = 0;
        $file_name         = null;
        $data              = array();

        foreach ($contents as $index => $content) {
            if ($content !== '') {
                if ($i >= $index && $index !== 0) {
                    $array_content = explode(' ', $content);

                    $data[$file_name][$index]['position'] = $array_content[0];
                    $data[$file_name][$index]['byte'] = $array_content[1];
                } else {
                    $array_content = explode(' ', $content);
                    $file_name = $array_content[0];
                    $i = $index + $array_content[1];
                }
            }
        }

        $result = $this->chocobosServices->processData($data);

        return $this->output($result);

    }

    private function output($result)
    {
        try {
            $string = '';
            foreach ($result as $data) {
                $string .= $data;
                $string .= PHP_EOL;
            }

            Storage::put('public/Chocobos/Output/output.txt', $string);

            return [];
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
