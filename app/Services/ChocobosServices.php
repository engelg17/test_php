<?php

namespace App\Services;

use PhpParser\Node\Expr\Cast\Bool_;

class ChocobosServices
{
    protected $fileContent;

    public function __contruct() {
        $this->fileContent = '';
    }

    public function processData(array $data): Array
    {
        $output = [];
        foreach ($data as $index => $item) {
            $this->fileContent = '';
            $additionsNumber = 1;
            foreach ($item as $index2 => $value) {
                $output[] = $this->createOutput($value['position'], $value['byte'], $index, $additionsNumber);
                $additionsNumber++;
            }
        }

        return $output;
    }

    private function createOutput($position, $bytes, $fileName, $additionsNumber): String
    {
        $this->addByte($position,$bytes);
        $hash = hash('crc32b', $this->fileContent);

        return $fileName . ' '. $additionsNumber . ': ' . $hash;
    }

    public function addByte($position, $byte) {
        $byte = chr($byte);

        if ($position > strlen($this->fileContent)) {
            $this->fileContent = str_pad($this->fileContent, $position, chr(0));
        }

        $this->fileContent = substr($this->fileContent, 0, $position) . $byte . substr($this->fileContent, $position);
    }
}
