<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mention Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0 0 5px 5px;
        }
        .ticket-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #dc3545;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid #dee2e6;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Anda Disebutkan dalam Tiket</h2>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $mentionedUser->name }}</strong>,</p>
        
        <p>Anda telah disebutkan oleh <strong>{{ $mentionedBy->name }}</strong> dalam tiket berikut:</p>
        
        <div class="ticket-info">
            <h4>Tiket #{{ $ticket->id }}</h4>
            <p><strong>Subjek:</strong> {{ $ticket->subject }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <p><strong>Departemen:</strong> {{ $ticket->department->name ?? 'N/A' }}</p>
        </div>
        
        <div class="message-box">
            <h5>Pesan:</h5>
            <p>{{ $conversationMessage }}</p>
        </div>
        
        <p>Silakan klik tombol di bawah untuk melihat tiket tersebut:</p>
        
        <a href="{{ url('/admin/tickets/' . $ticket->id) }}" class="btn">Lihat Tiket</a>
        
        <p>Terima kasih,<br>Tim Support Keloola</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
    </div>
</body>
</html> 