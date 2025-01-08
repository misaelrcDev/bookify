<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Relatório de Reservas</h1>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Serviço</th>
                <th>Data e Hora de Início</th>
                <th>Data e Hora de Término</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
            <tr>
                <td>{{ $booking['client_name'] }}</td>
                <td>{{ $booking['service'] }}</td>
                <td>{{ $booking['start_time'] }}</td>
                <td>{{ $booking['end_time'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Nenhuma reserva encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
