Hello {{ $request->recipient_name }},

You have a new contact form request: Below are the details:

Name: {{ $request->sender_name }}
Email: {{ $request->sender_email }}
Message: {{ $request->message }}
