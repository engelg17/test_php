<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChocoBillyServices;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class ChocoBillyController extends Controller
{
    protected $chocoBillyServices;

    public function __construct(ChocoBillyServices $chocoBillyServices)
    {
        $this->chocoBillyServices = $chocoBillyServices;
    }

    public function index($fileName)
    {
        $contents          = File::lines(storage_path('app/public/ChocoBilly/' . $fileName));
        $i                 = 0;
        $data              = array();
        $available_weights = null;

        foreach ($contents as $index => $content) {
            if ( $i > 0 ) {
                if ($i%2 == 0) {
                    $data['cases'][$index/2]['available_weights'] = $available_weights;
                    $data['cases'][$index/2]['quantity_requested'] = $content;
                } else {
                    $available_weights = explode(',', $content);
                }
            } else {
                $data['cases_to_calculate'] = $content;
            }
            $i++;
        }

        $result = $this->chocoBillyServices->process($data);
        try {
            $this->output($data['cases_to_calculate'], $result);

            return;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function output($cases_to_calculate, $result) {
        $string = '';
        foreach ($result as $data) {
            $string .= $cases_to_calculate. ':';

            foreach ($data as $item) {
                $string .= $item . ',';
            }

            $string .= PHP_EOL;
        }

        Storage::put('public/ChocoBilly/Output/output.txt', $string);
    }
}
