<?php

/**
 * função que devolve em formato JSON os dados do cliente
 */
function retorna($nome, $db) {

    $sql = "SELECT * FROM `customer` WHERE `cpf` = '{$nome}' or `name` = '{$nome}' ";

    $query = $db->query($sql);

    $arr = Array();

    if ($query->num_rows) {
        while ($dados = $query->fetch_object()) {

            $arr['id'] = $dados->id;
            $arr['cpf'] = $dados->cpf;
            $arr['name'] = $dados->name;            
            $arr['gender'] = $dados->gender;           
            $arr['convenio'] = $dados->convenio;
            $birthday = $dados->birthday;
            $birthday = date('d/m/Y', strtotime($birthday)); 
            $arr['birthday'] =  $birthday;
        }
    } else {
        if (isset($_GET['cpf'])) {
           
            $arr['id'] = 'CPF não cadastrado!';
        }
        if (isset($_GET['name'])) {
            
            $arr['id'] = 'Paciente não cadastrado!';
         
        }
    }



    return json_encode($arr);
}

/* só se for enviado o parâmetro, que devolve os dados */
if (isset($_GET['cpf'])) {

    $db = new mysqli('localhost', 'root', '', 'paciente');
    echo retorna(filter($_GET['cpf']), $db);
}


if (isset($_GET['name'])) {

    $db = new mysqli('localhost', 'root', '', 'paciente');
    echo retorna(filter($_GET['name']), $db);
}

function filter($var) {
    return $var; //a implementação desta, fica a cargo do leitor
}
