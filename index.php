<?php

require './src/VolanteMonetizzeSena.php';

echo '<h1>Gera jogos, um resultado e o sorteio</h1>';

try {
    $volante = new VolanteMonetizzeSena(9, 3);
    $volante->geraJogos();
    $volante->geraSorteio();
    echo $volante->geraTabelaConferencia();
} catch (Exception $e) {
    echo $e->getMessage();
}