<?php

namespace App\Services;

use PhpParser\Node\Expr\Cast\Bool_;

class ChocoBillyServices
{
    public function process(array $data)
    {
        $results = [];
        foreach ($data['cases'] as $case) {
            $result = $this->calculate($case['available_weights'], $case['quantity_requested']);
            $results[] = $result;
        }

        return $results;
    }

    private function calculate($available_weights, $quantity_requested) {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $dp = array_fill(0, $quantity_requested + 1, PHP_INT_MAX);
        $dp[0] = 0; // No se necesitan aves para obtener un peso de 0
        $combinaciones = array_fill(0, $quantity_requested + 1, []);

        for ($i = 1; $i <= $quantity_requested; $i++) {
            foreach ($available_weights as $peso) {
                if ($peso <= $i && $dp[$i - $peso] + 1 < $dp[$i]) {
                    $dp[$i] = $dp[$i - $peso] + 1;
                    $combinaciones[$i] = array_merge($combinaciones[$i - $peso], [$peso]);
                }
            }
        }

        if ($dp[$quantity_requested] == PHP_INT_MAX) {
            return "No es posible alcanzar el peso solicitado con las aves disponibles";
        } else {
            $combinacion = $combinaciones[$quantity_requested];
            return count($combinacion) . ":" . implode(',', $combinacion);
        }
    }
}
