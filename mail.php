<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $fone = $_POST['fone'];
    $passport_files = $_FILES['passport_file']; // Alterado para $passport_files
    $visa_files = $_FILES['visa_file']; // Alterado para $visa_files
    $produtos = isset($_POST['produtos']) ? implode(', ', $_POST['produtos']) : 'Nenhum produto selecionado';

    $passport_filename = 'passport.pdf';
    $visa_filename = 'visa.pdf';

    $boundary = md5(time());

    $headers = "From: \"$name $sobrenome\" <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "<html><body>";
    $body .= "<h2>Novo Formulário Recebido</h2>";
    $body .= "<p><strong>Nome:</strong> $name</p>";
    $body .= "<p><strong>Sobrenome:</strong> $sobrenome</p>";
    $body .= "<p><strong>Email:</strong> $email</p>";
    $body .= "<p><strong>Telefone:</strong> $fone</p>";
    $body .= "<p><strong>Produtos Selecionados:</strong> $produtos</p>";
    $body .= "</body></html>\r\n";

    // Verifique se há arquivos de passaporte
    if (!empty($passport_files['name'][0])) {
        foreach ($passport_files['tmp_name'] as $index => $tmp_name) {
            // Defina o tipo de conteúdo como PDF e adicione a extensão .pdf ao nome do arquivo
            $passport_filename = 'passport_' . ($index + 1) . '.pdf';

            // Adicione o arquivo ao corpo do e-mail
            $attachment = chunk_split(base64_encode(file_get_contents($tmp_name)));
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: application/pdf; name=\"$passport_filename\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$passport_filename\"\r\n\r\n";
            $body .= "$attachment\r\n\r\n";
        }
    }

    // Verifique se há arquivos de visto
    if (!empty($visa_files['name'][0])) {
        foreach ($visa_files['tmp_name'] as $index => $tmp_name) {
            // Defina o tipo de conteúdo como PDF e adicione a extensão .pdf ao nome do arquivo
            $visa_filename = 'visa_' . ($index + 1) . '.pdf';

            // Adicione o arquivo ao corpo do e-mail
            $attachment = chunk_split(base64_encode(file_get_contents($tmp_name)));
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: application/pdf; name=\"$visa_filename\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$visa_filename\"\r\n\r\n";
            $body .= "$attachment\r\n\r\n";
        }
    }

    $to = "Atip Canada <teste@atipcanada.com>";
    $subject = "Novo Formulário Recebido - $name $sobrenome";
    mail($to, $subject, $body, $headers);

    header("Location: index.html");
    exit();
}
