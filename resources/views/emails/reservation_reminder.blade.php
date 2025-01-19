<!DOCTYPE html>
<html>
<head>
    <title>Lembrete de Reserva Próxima</title>
</head>
<body>
    <p>Olá {{ $booking->client_name }},</p>
    <p>Este é um lembrete de que você tem uma reserva próxima.</p>
    <p><strong>Serviço:</strong> {{ $booking->service->name }}</p>
    <p><strong>Data e Hora de Início:</strong> {{ $booking->start_time }}</p>
    <p><strong>Data e Hora de Término:</strong> {{ $booking->end_time }}</p>
    <p>Atenciosamente,</p>
    <p>Sua Empresa</p>
</body>
</html>
