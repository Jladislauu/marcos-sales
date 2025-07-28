<?php
// Verifica se foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pega os dados do formulário
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validação básica
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Preencha todos os campos obrigatórios.";
        exit;
    }

    // Define o destinatário e o conteúdo
    $to = "psimarcossales@gmail.com"; // <- Troque pelo e-mail de destino real
    $email_subject = "Novo contato do site: $subject";
    $email_body = "Nome: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Telefone: $phone\n\n";
    $email_body .= "Mensagem:\n$message\n";

    $headers = "From: $name <$email>";

    // Tenta enviar
    if (mail($to, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Mensagem enviada com sucesso.";
    } else {
        http_response_code(500);
        echo "Erro ao enviar a mensagem.";
    }
} else {
    http_response_code(403);
    echo "Método não permitido.";
}
