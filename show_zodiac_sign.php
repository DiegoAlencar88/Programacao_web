<?php 
include('layouts/header.php');

// Capturar a data formulario
$data_nascimento = $_POST['data_nascimento'];
list($ano, $mes, $dia) = explode(separator: '-', string: $data_nascimento);

// Carregar o XML dos signos
$signos = simplexml_load_file(filename: "signos.xml");

// Função para verificar se a data está ok
function dataEstaNoIntervalo($dia, $mes, $dataInicio, $dataFim): bool {
    list($diaInicio, $mesInicio) = explode(separator: '/', string: $dataInicio);
    list($diaFim, $mesFim) = explode(separator: '/', string: $dataFim);

    $inicio = mktime(hour: 0, minute: 0, second: 0, month: $mesInicio, day: $diaInicio);
    $fim = mktime(hour: 0, minute: 0, second: 0, month: $mesFim, day: $diaFim);
    $data = mktime(hour: 0, minute: 0, second: 0, month: $mes, day: $dia);

    // Ajusta caso o intervalo esteja entre dois anos diferentes
    if ($inicio > $fim) {
        return ($data >= $inicio || $data <= $fim);
    }
    return ($data >= $inicio && $data <= $fim);
}

// Itera sobre os signos e exibe o correspondente
foreach ($signos->signo as $signo) {
    if (dataEstaNoIntervalo(dia: $dia, mes: $mes, dataInicio: $signo->dataInicio, dataFim: $signo->dataFim)) {
        echo "<h2 class='mt-5'>Seu signo é: {$signo->signoNome}</h2>";
        echo "<img src='{$signo->imagem}' alt='{$signo->signoNome}' class='img-fluid mb-3'>";
        echo "<p>{$signo->descricao}</p>";
        break;
    }
}

echo '<a href="index.php" class="btn btn-secondary mt-3">Voltar</a>';
?>
</div> <!-- Fim container -->
</body>
</html>

