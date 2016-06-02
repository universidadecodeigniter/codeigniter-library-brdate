<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class BRdate
{
  /**
   * Converte data no padrão dd/mm/aaaa para aaaa-mm-dd
   *
   * @param string $data String da data no formato do banco de dados (aaaa-m-d)
   *
   * @return string
   */
  public static function Padrao2Banco( $data )
  {

    $resultado = null;

    $novaData = substr( trim( $data ), 0, 10 );

    if ( strlen( $novaData ) == 10 )
    {
      $vetor = explode( "/", $novaData );
      if ( count( $vetor ) == 3 )
      {
        $resultado = $vetor[2] . "-" . $vetor[1] . "-" . $vetor[0];
      }
      else
      {
        $resultado = $novaData;
      }
    }


    return $resultado . substr( $data, 10 );

  }

  /**
   * Converte uma data no padrão aaaa-mm-dd para dd/mm/aaaa
   *
   * @param string $data Data no formato brasileiro (dd/mm/aaaa)
   *
   * @return string
   */
  public static function Banco2Padrao( $data )
  {

    $resultado = null;

    $novaData = substr( trim( $data ), 0, 10 );

    if ( strlen( $novaData ) == 10 )
    {
      $vetor = explode( "-", $novaData );
      if ( count( $vetor ) == 3 )
      {
        $resultado = $vetor[2] . "/" . $vetor[1] . "/" . $vetor[0];
      }
      else
      {
        $resultado = $novaData;
      }
    }

    return $resultado . substr( $data, 10 );

  }

  /**
   * Retorna a data atual no fuso horário de Brasília, independente das configurações do servidor.
   *
   * @param string $strFormato Formato da data a ser retornado
   *
   * @return string
   */
  public static function dataAtual( $strFormato = "Y-m-d" )
  {

    $intDesvio = 3;

    if ( date( "I" ) == "1" )
    {
      $intDesvio -= 1;
    }

    $data = date( $strFormato, mktime( gmdate( "H" ) - $intDesvio, gmdate( "i" ), gmdate( "s" ), gmdate( "m" ), gmdate( "d" ), gmdate( "Y" ) ) );
    return $data;

  }


  /*
  -----------------------------------------------------------------------------------
  Funções para retornar data e hora quando a String possui ambos
  -----------------------------------------------------------------------------------
  */

  /**
   * Extrai somente a data de uma string com data e hora
   *
   * @param string $strData Data e Hora
   *
   * @return string
   */
  public static function getData( $strData )
  {
    $arrDados = explode( " ", $strData );
    return $arrDados['0'];

  }

  /**
   * Extrai somente a hora de uma string com data e hora
   *
   * @param string $strData Data e Hora
   *
   * @return string
   */
  public static function getHora( $strData )
  {
    $arrDados = explode( " ", $strData );
    return $arrDados['1'];

  }

  /**
   * Soma ou diminui x dias para de data no padrão aaaa-mm-dd
   *
   * @param string $data Data
   *
   * @param string $quantidade Número de dias
   *
   * @param string $strIntervalor Intervalo para cálculo (d = dia | m = mês | y = ano | h = horas | m = minutos | s = segundos)
   *
   * @param bolean $bolRetornaDiaUtil Se vai retornar dias úteis ou não
   *
   * @param bolean $bolSabadoDiaUtil Se sábado será contado como dia útil ou não
   *
   * @return string
   */
  public static function adicionarDias( $data, $quantidade, $strIntervalo = "d", $bolRetornaDiaUtil = false, $bolSabadoDiaUtil = false )
  {

    $dia = null;
    $mes = null;
    $ano = null;
    $hora = null;
    $minuto = null;
    $vetor = explode( "/", $data );

    if ( count( $vetor ) == 3 )
    {
      /* dd/mm/aaaa */
      $dia = $vetor[0];
      $mes = $vetor[1];
      $ano = $vetor[2];
    }
    else
    {
      /* aaaa-mm-dd */
      $vetor = explode( "-", $data );
      $dia = $vetor[2];
      $mes = $vetor[1];
      $ano = $vetor[0];
    }


    switch ( $strIntervalo )
    {

      case "y":
      {
        $ano += $quantidade;
        break;
      }

      case "m":
      {
        $mes += $quantidade;
        break;
      }

      case "h":
      {
        $hora += $quantidade;
        break;
      }

      case "i":
      {
        $minuto += $quantidade;
        break;
      }

      case "d":
      default:
      {
        $dia += $quantidade;
        break;
      }
    }


    $novaData = mktime( $hora, $minuto, 0, $mes, $dia, $ano );

    if ( $bolRetornaDiaUtil )
    {

      $diaSemana = date( "w", $novaData );
      if ( $diaSemana == 0 )
      {
        $novaData = mktime( $hora, $minuto, 0, $mes, $dia + 1, $ano );
      }

      if ( !$bolSabadoDiaUtil )
      {
        if ( $diaSemana == 6 )
        {
          $novaData = mktime( $hora, $minuto, 0, $mes, $dia + 2, $ano );
        }
      }
    }

    return strftime( "%d/%m/%Y", $novaData );

  }

  /**
   * Soma ou diminui x horas para o tempo no padrão h:i:s
   *
   * @param string $hora String
   *
   * @param string $quantidade Número de dias
   *
   * @param string $strIntervalor Intervalo para cálculo (h = horas | m = minutos | s = segundos)
   *
   * @param bolean $bolRetornaSegundos Se vai retornar os segundos ou não
   *
   * @return string
   */
  public static function adicionarHoras( $hora, $quantidade, $strIntervalo = "h", $bolRetornaSegundos = false )
  {

    $vetor = explode( ":", $hora );

    $hora = $vetor[0];
    $minuto = $vetor[1];
    $segundo = (count( $vetor ) == 3) ? $vetor[2] : 0;

    switch ( $strIntervalo )
    {

      case "h":
      {
        $hora += $quantidade;
        break;
      }

      case "m":
      {
        $minuto += $quantidade;
        break;
      }

      case "s":
      {
        $segundo += $quantidade;
        break;
      }
    }


    $novaHora = mktime( $hora, $minuto, $segundo, 0, 0, 0 );

    if ( $bolRetornaSegundos )
    {
      return strftime( "%H:%M:%S", $novaHora );
    }
    else
    {
      return strftime( "%H:%M", $novaHora );
    }

  }

  /**
   * Soma x dias úteis para a data
   *
   * @param string $data Data
   *
   * @param string $dias Número de dias
   *
   * @param bolean $bolSabadoDiaUtil Se sábado é dia útil ou não
   *
   * @return string
   */
  public static function adicionarDiasUteis( $data, $dias, $bolSabadoDiaUtil = false )
  {
    /* Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
    Transforma para DATE - aaaa-mm-dd */
    $data = substr( $data, 0, 10 );

    /* Se a data estiver no formato brasileiro: dd/mm/aaaa
    Converte-a para o padrão americano: aaaa-mm-dd */
    if ( preg_match( "@/@", $data ) == 1 )
    {
      $data = implode( "-", array_reverse( explode( "/", $data ) ) );
    }


    $array_data = explode( '-', $data );
    $intContador = 0;
    $intFimDeSemana = 0;
    $intDias = abs( $dias );
    while ( $intContador < $intDias )
    {

      $dia_da_semana = date( 'w', strtotime( '+' . $intContador . ' day', mktime( 0, 0, 0, $array_data[1], $array_data[2], $array_data[0] ) ) );

      if ( $dia_da_semana == '0' )
      {
        $intFimDeSemana++;
      }

      if ( !$bolSabadoDiaUtil )
      {
        if ( $dia_da_semana == '6' )
        {
          $intFimDeSemana++;
        }
      }

      $intContador++;
    }

    $strSinal = ($dias >= 0) ? "+" : "-";

    return date( 'd/m/Y', strtotime( $strSinal . $intContador . ' day', strtotime( $data ) ) );

  }

  /**
   * Calcula a diferença de dias entre duas datas
   *
   * @param string $strDataInicio Data de início
   *
   * @param string $strDataFim Data de início
   *
   * @param string $dias Número de dias
   *
   * @param string $strIntervalor Intervalo para cálculo (d = dia | m = mês | y = ano | h = horas | m = minutos | s = segundos)
   *
   * @param bolean $bolDiasUteis Se vai calcular somente os dias úteis ou não
   *
   * @param bolean $bolSabadoDiaUtil Se sábado é dia útil ou não
   *
   * @return string
   */
  public static function calcularDiferencaDias( $strDataInicio, $strDataFim, $strIntervalo = "d", $bolDiasUteis = false, $bolSabadoDiaUtil = false )
  {

    if ( strlen( $strDataInicio ) <= 0 || strlen( $strDataFim ) <= 0 )
    {
      return false;
    }

    $strDataInicio = self::Padrao2Banco( $strDataInicio );
    $strDataFim = self::Padrao2Banco( $strDataFim );

    $data1 = explode( "-", $strDataInicio );
    $hora1 = explode( " ", $data1['2'] );
    $hora1 = explode( ":", $hora1['1'] );
    $dia1 = null;

    if ( count( $hora1 ) == 3 )
    {
      $dia1 = mktime( $hora1['0'], $hora1['1'], $hora1['2'], $data1['1'], $data1['2'], $data1['0'] );
    }
    elseif ( count( $hora1 ) == 2 )
    {
      $dia1 = mktime( $hora1['0'], $hora1['1'], 0, $data1['1'], $data1['2'], $data1['0'] );
    }
    else
    {
      $dia1 = mktime( 0, 0, 0, $data1['1'], $data1['2'], $data1['0'] );
    }


    $data2 = explode( "-", $strDataFim );
    $hora2 = explode( " ", $data2['2'] );
    $hora2 = explode( ":", $hora2['1'] );
    $dia2 = null;


    if ( count( $hora2 ) == 3 )
    {
      $dia2 = mktime( $hora2['0'], $hora2['1'], $hora2['2'], $data2['1'], $data2['2'], $data2['0'] );
    }
    elseif ( count( $hora2 ) == 2 )
    {
      $dia2 = mktime( $hora2['0'], $hora2['1'], 0, $data2['1'], $data2['2'], $data2['0'] );
    }
    else
    {
      $dia2 = mktime( 0, 0, 0, $data2['1'], $data2['2'], $data2['0'] );
    }


    $diferenca = ($dia2 - $dia1);


    $intervalo = null;
    if ( $strIntervalo == "h" )
    {
      $intervalo = round( ($diferenca / 60 / 60 ) );
    }
    else if ( $strIntervalo == "m" )
    {
      $intervalo = round( ($diferenca / 60 ) );
    }
    else if ( $strIntervalo == "s" )
    {
      $intervalo = $diferenca;
    }
    else if ( $strIntervalo == "M" )
    {
      $intervalo = floor( $diferenca / (60 * 60 * 24 * 30) );
    }
    else if ( $strIntervalo == "y" )
    {
      $intBissextos = intval( self::calcularAnosBissextos( $strDataInicio, $strDataFim ) );

      $intDias = floor( $diferenca / (60 * 60 * 24) ) - $intBissextos;
      $intervalo = floor( $intDias / 365 );
    }
    else
    {
      $intervalo = floor( $diferenca / (60 * 60 * 24) );
    }


    if ( $strIntervalo == "d" )
    {

      if ( $bolDiasUteis )
      {

        $count_days = 0;
        $intFimDeSemana = 0;
        $intDias = abs( $intervalo );
        while ( $count_days < $intDias )
        {

          $dias_da_semana = date( 'w', strtotime( '+' . $count_days . ' day', mktime( 0, 0, 0, $data1[1], $data1[2], $data1[0] ) ) );

          if ( $dias_da_semana == '0' )
          {
            $intFimDeSemana += 1;
          }

          if ( !$bolSabadoDiaUtil )
          {
            if ( $dias_da_semana == '6' )
            {
              $intFimDeSemana += 1;
            }
          }

          $count_days += 1;
        }

        $intervalo -= $intFimDeSemana;
      }
    }

    return $intervalo;

  }

  /**
   * Calcula a diferença de tempo entre duas datas
   *
   * @param string $strDataInicio Data de início
   *
   * @param string $strDataFim Data de início
   *
   * @return string
   */
  public static function calcularDiferencaTempo( $strDataInicio, $strDataFim )
  {

    $diferenca = self::calcularDiferencaDias( $strDataInicio, $strDataFim, "s" );

    if ( $diferenca > 0 )
    {

      //Segundos
      if ( $diferenca < 60 )
      {
        $strS = ($diferenca > 1) ? "s" : null;
        return "{$diferenca} segundo{$strS}";
      }

      //Minutos
      $diferenca = floor( $diferenca / 60 );
      if ( $diferenca < 60 )
      {
        $strS = ($diferenca > 1) ? "s" : null;
        return "{$diferenca} minuto{$strS}";
      }

      //Horas
      $diferenca = floor( $diferenca / 60 );
      if ( $diferenca < 24 )
      {
        $strS = ($diferenca > 1) ? "s" : null;
        return "$diferenca hora{$strS}";
      }

      //Dias
      $diferenca = round( $diferenca / 24 );
      if ( $diferenca < 31 )
      {
        $strS = ($diferenca > 1) ? "s" : null;
        return "$diferenca dia{$strS}";
      }

      //Meses
      $diferenca = round( $diferenca / 31 );
      if ( $diferenca < 12 )
      {
        $strS = ($diferenca > 1) ? "meses" : "mês";
        return "$diferenca $strS";
      }
      else
      {
        $diferenca = round( $diferenca / 12 );
        $strS = ($diferenca > 1) ? "s" : null;
        return "$diferenca ano{$strS}";
      }
    }
    else
    {
      return "alguns instantes";
    }

  }

  /**
   * Calcula a idade a partir da data de nascimento
   *
   * @param string $data_nascimento Data de nascimento
   *
   * @param string $strDataAtual Data final do intervalo de cálculo
   *
   * @return string
   */
  public static function calcularIdade( $data_nascimento, $strDataAtual = null )
  {

    if ( strlen( $data_nascimento ) > 0 )
    {

      $data_nascimento = self::Padrao2Banco( $data_nascimento );


      $data_atual = (strlen( $strDataAtual ) > 0) ? self::Padrao2Banco( $strDataAtual ) : self::dataAtual( "Y-m-d" );


      $data_nascimento = explode( "-", $data_nascimento );
      $atual = explode( "-", $data_atual );

      $idade = $atual[0] - $data_nascimento[0];

      if ( $data_nascimento[1] > $atual[1] ) //verifica se o mês de nascimento é maior que o mês atual
      {
        $idade--; //tira um ano, já que ele não fez aniversário ainda
      }
      elseif ( $data_nascimento[1] == $atual[1] && $data_nascimento[2] > $atual[2] ) //verifica se o dia de hoje é maior que o dia do aniversário
      {
        $idade--; //tira um ano se não fez aniversário ainda
      }

      return $idade; //retorna a idade da pessoa em anos
    }
    else
    {
      return 0;
    }

  }

  /**
   * Calcula o total de anos bissextos entre duas datas
   *
   * @param string $strDataInicio Data de início
   *
   * @param string $strDataFim Data de início
   *
   * @return string
   */
  public static function calcularAnosBissextos( $strDataInicio, $strDataFim )
  {

    $data_inicio = self::Padrao2Banco( $strDataInicio );

    $data_inicio = explode( "-", $data_inicio );
    $ano_inicio = $data_inicio['0'];


    $data_fim = self::Padrao2Banco( $strDataFim );

    $data_fim = explode( "-", $data_fim );
    $ano_fim = $data_fim['0'];


    $contador = 0;


    for ( $i = $ano_inicio; $i < $ano_fim; $i++ )
    {

      if ( $i % 4 == 0 )
      {
        $contador++;
      }
    }

    return $contador;

  }

  /**
   * Verifica o nome do mês
   *
   * @param int $intMes Mês
   *
   * @return string
   */
  public static function retornaNomeMes( $intMes )
  {

    if ( strlen( $intMes ) <= 2 )
    {
      $intMes = intval( $intMes );
    }
    else
    {
      $data = self::Padrao2Banco( $intMes );
      $vetData = explode( "-", $data );
      $intMes = intval( $vetData['1'] );
    }


    if ( $intMes >= 1 && $intMes <= 12 )
    {
      $arrMes = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

      return $arrMes[$intMes];
    }

  }

  /**
   * Retorna o dia para uma determinada data
   *
   * @param string $data Data
   *
   * @return string
   */
  public static function retornaDia( $data )
  {

    $data = self::Padrao2Banco( $data );
    $vetData = explode( "-", $data );
    $intAno = intval( $vetData['2'] );

    return $intAno;

  }

  /**
   * Retorna o mês para uma determinada data
   *
   * @param string $data Data
   *
   * @return string
   */
  public static function retornaMes( $data )
  {

    $data = self::Padrao2Banco( $data );
    $vetData = explode( "-", $data );
    $intAno = intval( $vetData['1'] );

    return $intAno;

  }

  /**
   * Retorna o ano para uma determinada data
   *
   * @param string $data Data
   *
   * @return string
   */
  public static function retornaAno( $data )
  {

    $data = self::Padrao2Banco( $data );
    $vetData = explode( "-", $data );
    $intAno = intval( $vetData['0'] );

    return $intAno;

  }

  /**
   * Retorna a data por extenso, compactada (Jun/16)
   *
   * @param string $data Data
   *
   * @return string
   */
  public static function retornaNomeDataCompacta( $data )
  {

    $data = self::Padrao2Banco( $data );

    $nomeMes = self::retornaNomeMes( $data );
    $nomeMes = substr( $nomeMes, 0, 3 );

    $vetData = explode( "-", $data );
    $anoData = substr( $vetData['0'], - 2 );

    return $nomeMes . "/" . $anoData;

  }

  /**
   * Retorna a data por extenso
   *
   * @param string $data Data
   *
   * @param boolean $bolExibirDiaDaSemana Se irá exibir o dia da semana ou não
   *
   * @return string
   */
  public static function exibirDataPorExtenso( $data = null, $bolExibirDiaDaSemana = true )
  {

    if ( strlen( $data ) > 0 )
    {
      $data = self::Padrao2Banco( $data );
    }
    else
    {
      $data = date( "Y-m-d" );
    }


    $vetData = explode( "-", $data );

    if ( count( $vetData ) == 3 )
    {

      $data_dia = $vetData['2'];
      $data_mes = $vetData['1'];
      $data_ano = $vetData['0'];

      $novaData = mktime( 0, 0, 0, $data_mes, $data_dia, $data_ano );

      $dia = date( "d", $novaData ); //Representação numérica do dia do mês (1 a 31)
      $diaSemana = date( "w", $novaData ); // representação numérica do dia da semana com 0 (para Domingo) a 6 (para Sabado)
      $mes = date( "n", $novaData ); // Representação numérica de um mês (1 a 12)
      $ano = date( "Y", $novaData ); // Ano com 4 digitos, lógico, né?

      $nomeDia = array(0 => "Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");
      $nomeMes = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

      $strDiaSemana = ($bolExibirDiaDaSemana) ? "{$nomeDia[$diaSemana]}, " : null;

      return "{$strDiaSemana}{$dia} de {$nomeMes[$mes]} de {$ano}";
    }

  }

  /**
   * Retorna o dia da semana
   *
   * @param string $data Data
   *
   * @return string
   */
  public static function exibirDiaDaSemana( $data )
  {
    if ( strlen( $data ) > 0 )
    {
      $data = self::Padrao2Banco( $data );

      $arrData = explode( "-", $data );
      $diaSemana = date( "w", mktime( 0, 0, 0, $arrData['1'], $arrData['2'], $arrData['0'] ) );
    }
    else
    {
      $diaSemana = date( "w" );
    }

    $nomeDia = array(0 => "Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");

    return $nomeDia[$diaSemana];

  }

  /**
   * Retorna uma mensagem de cumprimento com base na hora atual (bom dia, boa tarde, boa noite, boa madrugada)
   *
   * @return string
   */
  public static function exibirMensagemCumprimento()
  {
    $hora_do_dia = date( "H" );

    if ( ($hora_do_dia >= 6) && ($hora_do_dia < 12) )
    {
      return "Bom dia";
    }
    else if ( ($hora_do_dia >= 12) && ($hora_do_dia < 18) )
    {
      return "Boa tarde";
    }
    else if ( ($hora_do_dia >= 18) && ($hora_do_dia <= 24) )
    {
      return "Boa noite";
    }
    else
    {
      return "Boa madrugada";
    }

  }

  /**
   * Verifica se é dia útil
   *
   * @param string $data Data
   *
   * @param boolean $bolSabadoDiaUtil Se sábado é dia útil ou não
   *
   * @return boolean
   */
  public static function verificaDiaUtil( $data, $bolSabadoDiaUtil = false )
  {

    $data = self::Padrao2Banco( $data );
    $vetData = explode( "-", $data );

    $dia_da_semana = date( 'w', mktime( 0, 0, 0, $vetData[1], $vetData[2], $vetData[0] ) );

    if ( $bolSabadoDiaUtil )
    {
      return ($dia_da_semana != '0');
    }
    else
    {
      return ($dia_da_semana != '0' && $dia_da_semana != '6');
    }

  }

}

?>
