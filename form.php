<?php
$pdo = new PDO('mysql:localhost;dbname=cadastro', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //vai mostrar os erros e não dará uma informação falsa de envio//

//Inserir dados//
//Insert
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM USUARIO WHERE id=$id");
    echo 'Deletado com sucesso o id' . $id;
}
if (isset($_POST['nome'])) { //Está verificando se o nome está vazio//Esse post poderia ser feito com sqlInjection se inserisse directament no banco de dados//
    $sql = $pdo->prepare("INSERT INTO usuarios VALUES(null,?,?)"); //está preparando e retirando todos os caracteres especiais que faria o sqilInjection//
    $sql->execute(array($_POST['nome'], $_POST['email'])); //Inserindo o Post nome o post email//
    echo "inserido com sucesso";
}
//ATulizar comando
$nome = 'Romeu Cajamba';
$pdo->exec("update usuarios set nome='$nome' where id=3");
?>

<form method="post">
    <input type="text" name="nome" placeholder="Insira seu nome" />
    <input type="email" name="email" placeholder="Insira seu email" />
    <input type="password" placeholder="Insira sua senha" />
    <input type="submit" value="Enviar" />
</form>

<?php
$sql = $pdo->prepare("SELECT * FROM usuarios"); //Fazndo uma consulta, uma query

$sql->execute();

$fetchUsuarios = $sql->fetchAll();
//Mostrando os usuarios cadastrados nome, email usando o forEch//
foreach ($fetchUsuarios as $key => $values) { //Opção para eliminar usuario//
    echo '<a href="?delete=' . $values['id'] . '">(Apagar)</a>' . $values['name'] . ' |' . $values['email'];
    echo "<hr/>";
}
?>