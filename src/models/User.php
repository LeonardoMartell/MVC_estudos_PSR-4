<?php
//classe usuario com CRUD basico caso esteja conectada ao banco de dados
//classe demonstrativa e só funciona se conectada a um banco de dados com uma tabela ja criada (No caso aqui é usuarios)
//Como é apenas demonstrativa não tem nenhuma verificação

namespace App\models;

use App\core\Model;

class User extends Model
{
    //Cria um novo usuário
    public function createUser($nome, $telefone){
        $params = [':nome' => $nome, ':telefone' => $telefone];
        $resultado = $this->db->execute('INSERT INTO usuarios (nome, telefone) Values (:nome, :telefone)', $params);
        return $resultado;
    }

    //Retorna um usuario pelo id
    public function getUser($id){
        $params = [':id' => $id];
        $resultado = $this->db->fetch('SELECT * FROM usuarios WHERE id = :id', $params);
        return $resultado;
    }

    //Retorna todos os usuarios do banco
    public function listUsers(){
        $resultado = $this->db->fetchAll('SELECT * FROM usuarios');
        return $resultado;
    }

    //busca um usuario pelo id e edita suas informações
    public function editUser($id, $novoNome, $novoTelefone){
        $params = [':id' => $id, ':nome' => $novoNome, ':telefone' => $novoTelefone];
        $resultado = $this->db->execute('UPDATE usuarios SET nome = :nome, telefone = :telefone WHERE id = :id', $params);
        return $resultado;
    }

    //busca um usuario pelo id e apaga o registro do banco de dados
    public function deleteUser($id){
        $params = [':id' => $id];
        $resultado = $this->db->execute('DELETE FROM usuarios WHERE id = :id', $params);
        return $resultado;
    }
}