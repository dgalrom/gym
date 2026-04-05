<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas — GYM</title>
</head>
<body>
    <h1>Estadísticas del gimnasio</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    <hr>

    {{-- Totales --}}
    <h2>Resumen general</h2>
    <ul>
        <li>Usuarios registrados: <strong>{{ $totalUsuarios }}</strong></li>
        <li>Clases activas: <strong>{{ $totalClases }}</strong></li>
    </ul>

    <hr>

    {{-- Clases con más reservas --}}
    <h2>Clases con más reservas (top 5)</h2>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Clase</th>
                <th>Reservas activas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clasesMasReservadas as $clase)
                <tr>
                    <td>{{ $clase->nombre }}</td>
                    <td>{{ $clase->reservas_count }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Sin datos.</td></tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    {{-- Clientes con más reservas --}}
    <h2>Clientes con más reservas (top 5)</h2>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Reservas activas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientesMasReservas as $cliente)
                <tr>
                    <td>{{ $cliente->name }}</td>
                    <td>{{ $cliente->reservas_count }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Sin datos.</td></tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    {{-- Reservas por día --}}
    <h2>Reservas por día (últimos 30 días)</h2>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Día</th>
                <th>Reservas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasPorDia as $fila)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($fila->dia)->format('d/m/Y') }}</td>
                    <td>{{ $fila->total }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Sin reservas en los últimos 30 días.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
