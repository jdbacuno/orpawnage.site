<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Pet Notification</title>
  <style>
    body {
      background-color: #f9fafb;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #374151;
    }

    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      padding: 24px 32px;
    }

    h2 {
      font-size: 1.75rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 20px;
      text-align: center;
    }

    .info p {
      font-size: 1rem;
      line-height: 1.5;
      margin: 8px 0;
    }

    .image-container {
      margin: 24px 0;
      text-align: center;
    }

    .image-container img {
      max-width: 100%;
      border-radius: 8px;
    }

    .button {
      display: inline-block;
      margin: 24px auto 0;
      padding: 12px 24px;
      background-color: #3b82f6;
      color: #ffffff !important;
      font-weight: 600;
      text-decoration: none;
      border-radius: 6px;
      text-align: center;
      transition: background-color 0.2s ease-in-out;
    }

    .button:hover {
      background-color: #2563eb;
    }

    .footer {
      margin-top: 40px;
      padding-top: 16px;
      border-top: 1px solid #e5e7eb;
      font-size: 0.875rem;
      color: #6b7280;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    @if ($pet->image_path)
    <div class="image-container">
      <img src="{{ $message->embed(storage_path('app/public/' . $pet->image_path)) }}" alt="Pet Image">
    </div>
    @endif

    <div style="text-align: center; color: white;">
      <a href="{{ url('/services/' . $pet->slug . '/adoption-form') }}" class="button" style="color: white;">View Pet &
        Adopt</a>
    </div>

    <div class="footer">
      <p>Thanks for being part of our community!</p>
      <p><strong>{{ config('app.name') }}</strong></p>
    </div>
  </div>
</body>

</html>