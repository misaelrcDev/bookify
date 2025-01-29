<!DOCTYPE html>
<html>
<head>
    <title>Notificação de Vencimento de Assinatura</title>
</head>
<body>
    <h1>Olá, {{ $user->name }}</h1>
    <p>Este é um lembrete de que sua assinatura está prestes a vencer em {{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->format('d/m/Y') : \Carbon\Carbon::parse($subscription->created_at)->addMonth()->format('d/m/Y') }}.</p>
    <p>Por favor, renove sua assinatura para continuar aproveitando nossos serviços.</p>
    <p>Obrigado!</p>
</body>
</html>
