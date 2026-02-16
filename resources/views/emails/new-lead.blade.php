<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Notification</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #006AFF;
        }
        .header img {
            max-height: 50px;
        }
        .content {
            padding: 30px;
        }
        .property-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .property-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #006AFF;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/pronalist-logo.png') }}" alt="PronaList Logo">
        </div>
        
        <div class="content">
            <h2>New Lead Received!</h2>
            <p>Hello {{ $notifiable->name ?? 'Agent' }},</p>
            <p>You have received a new inquiry for the following property:</p>
            
            @if($lead->property)
                @if($lead->property->primary_image_url)
                    <img src="{{ $lead->property->primary_image_url }}" alt="{{ $lead->property->translated_title }}" class="property-image">
                @endif
                
                <div class="property-details">
                    <h3 style="margin-top:0;">{{ $lead->property->translated_title }}</h3>
                    <p><strong>Price:</strong> {{ $lead->property->formatted_price }}</p>
                    <p><strong>Location:</strong> {{ $lead->property->city }}, {{ $lead->property->country }}</p>
                </div>
            @else
                <div class="property-details">
                    <p><strong>General Inquiry</strong> (No specific property linked)</p>
                </div>
            @endif

            <p>To view the lead details and contact the interested party, please visit your dashboard.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('agent.leads') }}" class="btn">View Lead Details</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} PronaList. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
