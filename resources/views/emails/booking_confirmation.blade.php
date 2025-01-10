<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Reserva</title>
</head>
<body>
    <p>Olá {{ $booking->client_name }},</p>
    <p>Sua reserva foi confirmada com sucesso!</p>
    <p><strong>Serviço:</strong> {{ $booking->service->name }}</p>
    <p><strong>Data e Hora de Início:</strong> {{ $booking->start_time }}</p>
    <p><strong>Data e Hora de Término:</strong> {{ $booking->end_time }}</p>
    <p>Atenciosamente,</p>
    <p>Sua Empresa</p>
</body>
</html>
