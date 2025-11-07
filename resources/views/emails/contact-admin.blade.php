<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f39c12; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #555; }
        .field-value { background-color: white; padding: 10px; border-radius: 4px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
            <p>You have received a new message from your website contact form.</p>
        </div>

        <div class="content">
            <div class="field">
                <div class="field-label">Name:</div>
                <div class="field-value">{{ $contactData['name'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value">{{ $contactData['email'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Phone:</div>
                <div class="field-value">{{ $contactData['phone'] ?: 'Not provided' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Subject:</div>
                <div class="field-value">{{ $contactData['subject'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Message:</div>
                <div class="field-value">{{ $contactData['message'] ?: 'No message provided' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Submitted At:</div>
                <div class="field-value">{{ now()->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>
</body>
</html>