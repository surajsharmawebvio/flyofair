<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting FlyOFair</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f39c12; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting FlyOFair</h1>
        </div>

        <div class="content">
            <p>Dear {{ $contactData['name'] }},</p>

            <p>Thank you for reaching out to us! We have received your message and appreciate you taking the time to contact FlyOFair.</p>

            <p><strong>Your message details:</strong></p>
            <ul>
                <li><strong>Subject:</strong> {{ $contactData['subject'] }}</li>
                <li><strong>Message:</strong> {{ $contactData['message'] ?: 'No additional message provided' }}</li>
            </ul>

            <p>Our team will review your inquiry and get back to you within 24-48 hours. If you have any urgent matters, please feel free to call us directly at +1-877-238-0219.</p>

            <p>Best regards,<br>
            The FlyOFair Team</p>
        </div>

        <div class="footer">
            <p>This is an automated response. Please do not reply to this email.</p>
            <p>&copy; 2025 FlyOFair. All rights reserved.</p>
        </div>
    </div>
</body>
</html>