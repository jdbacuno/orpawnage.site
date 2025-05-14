<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Pet Notification</title>
  <style>
    body {
      background-color: #f3f4f6;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 640px;
      margin: 40px auto;
      padding: 24px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #1f2937;
    }

    .info {
      margin: 20px 0;
      line-height: 1.6;
      color: #374151;
    }

    .image-container {
      text-align: center;
      margin: 20px 0;
    }

    .image-container img {
      max-width: 100%;
      border-radius: 8px;
    }

    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #3b82f6;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
    }

    .footer {
      margin-top: 32px;
      padding-top: 16px;
      border-top: 1px solid #e5e7eb;
      font-size: 0.875rem;
      color: #6b7280;
      text-align: center;
    }

    .text-white {
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>🐾 A New Pet Has Been Added!</h2>

    <div class="info">
      <p><strong>Name:</strong> {{ $pet->pet_name ?? 'Unnamed' }}</p>
      <p><strong>Species:</strong> {{ ucfirst($pet->species) }}</p>
      <p><strong>Age:</strong> {{ $pet->age }} {{ Str::plural($pet->age_unit, $pet->age) }}</p>
    </div>

    @if($pet->image_path)
    <div class="image-container">
      <img src="{{ $message->embed(storage_path('app/public/' . $pet->image_path)) }}" alt="Pet Image">
    </div>
    @endif

    <div style="text-align: center; color: white">
      <a href="{{ url('/services/' . $pet->slug . '/adoption-form') }}" style="color: white" class="button">View Pet &
        Adopt</a>
    </div>

    <div class="footer">
      <p>Thanks for being part of our community!</p>
      <p><strong>{{ config('app.name') }}</strong></p>
    </div>
  </div>
</body>

</html>