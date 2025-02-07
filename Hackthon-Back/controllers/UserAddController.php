<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Hackthon/Hackthon-Back/models/User.php';
class userAddController {
    public function addUser() {
    
    header('Content-Type: application/json');
        
   
   $input = file_get_contents('php://input');
   $data = json_decode($input, true); // Decodifica JSON para array associativo

   
   if (!isset($data['email'])) {
       http_response_code(400);
       echo json_encode(['status' => 'error', 'message' => 'Email inválido']);
       exit();
   }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


    $username = $data['username'] ?? '';
    if (empty($username)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Campo de usuário vazio ou menor que 3 caracteres']);
        exit();
    }

    
    $password = $data['password'] ?? '';
    if (empty($password) ) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Senha menor que 6 caracteres ou campo vazio']);
        exit();
    }

    $novoUsuario = new User();
    $novoUsuario->setUsername($username); 
    $novoUsuario->setEmail($email);
    $novoUsuario->setPassword($password);
    $novoUsuario->creatUser();


    if (http_response_code(201)) {
        // Sucesso ao criar usuário
        http_response_code(201);
        echo json_encode(['status' => 'success', 'message' => 'Usuário cadastrado com sucesso']);
    } else {
        // Falha ao criar usuário
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o usuário']);
    }

    exit();
}}
