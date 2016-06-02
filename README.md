# BRDate - Biblioteca para trabalhar com data e hora no formato brasileiro

Biblioteca para CodeIgniter, 100% em português, para operações com data e hora.
_______
## Como utilizar

Para utilizar a library BRDate você deverá copiá-la para o diretório `libraries` da sua aplicação, e em seguida fazer o carregamento da mesma, ou no arquivo `config/autoload.php` ou no próprio controller onde for utilizá-la.

**Autoload**

`$autoload['library'] = array('BRDate');`

**Controller**

`$this->load->library('BRDate');`

Após fazer o carregamento, basta chamar as funções da library usando `$this->brdate->exibirMensagemCumprimento()`, por exemplo.

_______

## Documentação

### `Padrao2Banco( $data )`

Converte data no padrão dd/mm/aaaa para aaaa-mm-dd

 * **Parâmetros:** `$data` — `string` — String da data no formato do banco de dados (aaaa-m-d)

 * **Retorno:** `string` —

### `Banco2Padrao( $data )`

Converte uma data no padrão aaaa-mm-dd para dd/mm/aaaa

 * **Parâmetros:** `$data` — `string` — Data no formato brasileiro (dd/mm/aaaa)

 * **Retorno:** `string` —

### `dataAtual( $strFormato = "Y-m-d" )`

Retorna a data atual no fuso horário de Brasília, independente das configurações do servidor.

 * **Parâmetros:** `$strFormato` — `string` — Formato da data a ser retornado

 * **Retorno:** `string` —

### `getData( $strData )`

Extrai somente a data de uma string com data e hora

 * **Parâmetros:** `$strData` — `string` — Data e Hora

 * **Retorno:** `string` —

### `getHora( $strData )`

Extrai somente a hora de uma string com data e hora

 * **Parâmetros:** `$strData` — `string` — Data e Hora

 * **Retorno:** `string` —

### `adicionarDias( $data, $quantidade, $strIntervalo = "d", $bolRetornaDiaUtil = false, $bolSabadoDiaUtil = false )`

Soma ou diminui x dias para de data no padrão aaaa-mm-dd

 * **Parâmetros:**
   * `$data` — `string` — Data

   * `$quantidade` — `string` — Número de dias

   * `$strIntervalor` — `string` — Intervalo para cálculo (d = dia | m = mês | y = ano | h = horas | m = minutos | s = segundos)

   * `$bolRetornaDiaUtil` — `bolean` — Se vai retornar dias úteis ou não

   * `$bolSabadoDiaUtil` — `bolean` — Se sábado será contado como dia útil ou não

 * **Retorno:** `string` —

### `adicionarHoras( $hora, $quantidade, $strIntervalo = "h", $bolRetornaSegundos = false )`

Soma ou diminui x horas para o tempo no padrão h:i:s

 * **Parâmetros:**
   * `$hora` — `string` — String

   * `$quantidade` — `string` — Número de dias

   * `$strIntervalor` — `string` — Intervalo para cálculo (h = horas | m = minutos | s = segundos)

   * `$bolRetornaSegundos` — `bolean` — Se vai retornar os segundos ou não

 * **Retorno:** `string` —

### `adicionarDiasUteis( $data, $dias, $bolSabadoDiaUtil = false )`

Soma x dias úteis para a data

 * **Parâmetros:**
   * `$data` — `string` — Data

   * `$dias` — `string` — Número de dias

   * `$bolSabadoDiaUtil` — `bolean` — Se sábado é dia útil ou não

 * **Retorno:** `string` —

### `calcularDiferencaDias( $strDataInicio, $strDataFim, $strIntervalo = "d", $bolDiasUteis = false, $bolSabadoDiaUtil = false )`

Calcula a diferença de dias entre duas datas

 * **Parâmetros:**
   * `$strDataInicio` — `string` — Data de início

   * `$strDataFim` — `string` — Data de início

   * `$dias` — `string` — Número de dias

   * `$strIntervalor` — `string` — Intervalo para cálculo (d = dia | m = mês | y = ano | h = horas | m = minutos | s = segundos)

   * `$bolDiasUteis` — `bolean` — Se vai calcular somente os dias úteis ou não

   * `$bolSabadoDiaUtil` — `bolean` — Se sábado é dia útil ou não

 * **Retorno:** `string` —

### `calcularDiferencaTempo( $strDataInicio, $strDataFim )`

Calcula a diferença de tempo entre duas datas

 * **Parâmetros:**
   * `$strDataInicio` — `string` — Data de início

   * `$strDataFim` — `string` — Data de início

 * **Retorno:** `string` —

## `calcularIdade( $data_nascimento, $strDataAtual = null )`

Calcula a idade a partir da data de nascimento

 * **Parâmetros:**
   * `$data_nascimento` — `string` — Data de nascimento

   * `$strDataAtual` — `string` — Data final do intervalo de cálculo

 * **Retorno:** `string` —

### `calcularAnosBissextos( $strDataInicio, $strDataFim )`

Calcula o total de anos bissextos entre duas datas

 * **Parâmetros:**
   * `$strDataInicio` — `string` — Data de início

   * `$strDataFim` — `string` — Data de início

 * **Retorno:** `string` —

## `retornaNomeMes( $intMes )`

Verifica o nome do mês

 * **Parâmetros:** `$intMes` — `int` — Mês

 * **Retorno:** `string` —

### `retornaDia( $data )`

Retorna o dia para uma determinada data

 * **Parâmetros:** `$data` — `string` — Data

 * **Retorno:** `string` —

### `retornaMes( $data )`

Retorna o mês para uma determinada data

 * **Parâmetros:** `$data` — `string` — Data

 * **Retorno:** `string` —

### `retornaAno( $data )`

Retorna o ano para uma determinada data

 * **Parâmetros:** `$data` — `string` — Data

 * **Retorno:** `string` —

### `retornaNomeDataCompacta( $data )`

Retorna a data por extenso, compactada (Jun/16)

 * **Parâmetros:** `$data` — `string` — Data

 * **Retorno:** `string` —

### `exibirDataPorExtenso( $data = null, $bolExibirDiaDaSemana = true )`

Retorna a data por extenso

 * **Parâmetros:**
   * `$data` — `string` — Data

   * `$bolExibirDiaDaSemana` — `boolean` — Se irá exibir o dia da semana ou não

 * **Retorno:** `string` —

### `exibirDiaDaSemana( $data )`

Retorna o dia da semana

 * **Parâmetros:** `$data` — `string` — Data

 * **Retorno:** `string` —

### `exibirMensagemCumprimento()`

Retorna uma mensagem de cumprimento com base na hora atual (bom dia, boa tarde, boa noite, boa madrugada)

 * **Retorno:** `string` —

### `verificaDiaUtil( $data, $bolSabadoDiaUtil = false )`

Verifica se é dia útil

 * **Parâmetros:**
   * `$data` — `string` — Data

   * `$bolSabadoDiaUtil` — `boolean` — Se sábado é dia útil ou não

 * **Retorno:** `boolean` —
