<?php

/**
 * Class VolanteMonetizzeSena
 */
class VolanteMonetizzeSena
{

    /**
     * @var int
     */
    private $qtdDezenas;

    /**
     * @var array
     */
    private $resultado;

    /**
     * @var int int
     */
    private $totalJogos;

    /**
     * @var array
     */
    private $jogos;

    /**
     * VolanteMonetizzeSena constructor.
     * @param int $qtdDezenas
     * @param int $totalJogos
     */
    public function __construct(int $qtdDezenas, int $totalJogos)
    {
        $this->setQtdDezenas($qtdDezenas);
        $this->setResultado([]);
        $this->setTotalJogos($totalJogos);
        $this->setJogos([]);
    }

    /**
     * @return int
     */
    public function getQtdDezenas(): int
    {
        return $this->qtdDezenas;
    }

    /**
     * @param int $qtdDezenas
     */
    public function setQtdDezenas(int $qtdDezenas)
    {
        if(!in_array($qtdDezenas, [6, 7, 8, 9, 10])) {
            throw new \Exception('A quantidade de dezenas está limitada a 6, 7, 8, 9 ou 10. Tente novamente!');
        }

        $this->qtdDezenas = $qtdDezenas;
    }

    /**
     * @return array
     */
    public function getResultado(): array
    {
        return $this->resultado;
    }

    /**
     * @param array $resultado
     */
    public function setResultado(array $resultado)
    {
        $this->resultado = $resultado;
    }

    /**
     * @return int
     */
    public function getTotalJogos(): int
    {
        return $this->totalJogos;
    }

    /**
     * @param int $totalJogos
     */
    public function setTotalJogos(int $totalJogos)
    {
        $this->totalJogos = $totalJogos;
    }

    /**
     * @return array
     */
    public function getJogos(): array
    {
        return $this->jogos;
    }

    /**
     * @param array $jogos
     */
    public function setJogos(array $jogos)
    {
        $this->jogos = $jogos;
    }

    /**
     * Gera as dezenas de um jogo de acordo com a quantidade de dezenas configurada
     *
     * @return array
     */
    private function geraDezenas(): array
    {
        $dezenas = array();

        do {
            $dezena = rand(1, 60);

            if(!in_array($dezena, $dezenas)) {
                $dezenas[] = $dezena;
            }
        } while(count($dezenas) < $this->getQtdDezenas());

        sort($dezenas);

        return $dezenas;
    }

    /**
     * Gera os jogos e adiciona ao volante
     *
     * @return void
     */
    public function geraJogos()
    {
        for($i = 0; $i < $this->getTotalJogos(); $i++) {
            $this->jogos[] = $this->geraDezenas();
        }
    }

    /**
     * @return void
     */
    public function geraSorteio()
    {
        $dezenasSorteio = array();

        do {
            $dezena = rand(1, 60);

            if(!in_array($dezena, $dezenasSorteio)) {
                $dezenasSorteio[] = $dezena;
            }
        } while(count($dezenasSorteio) < 6);

        sort($dezenasSorteio);

        $this->setResultado($dezenasSorteio);
    }

    /**
     * @return string
     */
    public function geraTabelaConferencia(): string
    {
        $contador = 0;

        $tabela = '
            <table border="1">
                <thead>
                   <tr>
                        <th colspan="4">Resultado: ' . implode('-', $this->getResultado()) . '</th>
                   </tr>
                   <tr>
                       <th>#Jogo Nº</th>
                       <th>Qtd Dezenas</th>
                       <th>Dezenas</th>
                       <th>Qtd Dezenas Sorteadas</th>
                   </tr>
                </thead>
                <tbody>
            ';

        foreach($this->getJogos() as $jogo) {
            $match = array_intersect($this->getResultado(), $jogo);

            $tabela .= '<tr>';
            $tabela .= '    <td>' . $contador . '</td>';
            $tabela .= '    <td>' . $this->getQtdDezenas() . '</td>';
            $tabela .= '    <td>' . implode(' - ', $jogo) . '</td>';
            $tabela .= '    <td>' . count($match) . '</td>';
            $tabela .= '</tr>';

            $contador++;
        }

        $tabela .= '
                </tbody>
            </table>
            <br/>
        ';

        return $tabela;
    }

}