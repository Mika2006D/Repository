<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klachtenformulier</title>
</head>
<body>
    <h1>Klachtenformulier</h1>
    <form method="POST" action="verwerk_klacht.php">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="klacht">Omschrijving klacht:</label><br>
        <textarea id="klacht" name="klacht" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Verstuur klacht">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Haal de ingediende gegevens op
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $klacht = $_POST["klacht"];

    // Importeer de PHPMailer-bibliotheek
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    // Initialiseren van de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Serverinstellingen
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Vervang met de SMTP-server van je hostingprovider
        $mail->SMTPAuth = true;
        $mail->Username = 'jouw_email@example.com'; // Vervang met je eigen e-mailadres
        $mail->Password = 'jouw_wachtwoord'; // Vervang met je e-mailwachtwoord
        $mail->SMTPSecure = 'tls'; // Gebruik 'tls' of 'ssl' afhankelijk van je serverinstellingen
        $mail->Port = 587; // De SMTP-poort van je server

        // Ontvanger en cc
        $mail->setFrom('jouw_email@example.com', 'Jouw Naam'); // Vervang met je eigen informatie
        $mail->addAddress($email, $naam);
        $mail->addCC('jouw_email@example.com', 'Jouw Naam'); // Voeg jezelf toe aan de cc

        // Onderwerp en inhoud van de e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Uw klacht is in behandeling';
        $mail->Body = 'Beste ' . $naam . ',<br><br>Bedankt voor het indienen van uw klacht. We hebben uw klacht ontvangen en deze is in behandeling genomen.<br><br>Uw klacht:<br>' . $klacht . '<br><br>Met vriendelijke groet,<br>Je Bedrijfsnaam';

        // Verstuur de e-mail
        $mail->send();

        // Succesbericht
        echo 'Bedankt voor uw klacht! We hebben u een e-mail gestuurd.';

    } catch (Exception $e) {
        // Foutbericht als de e-mail niet kon worden verstuurd
        echo 'Er is een fout opgetreden bij het versturen van de e-mail: ' . $mail->ErrorInfo;
    }
}
?>
</body>
</html>
