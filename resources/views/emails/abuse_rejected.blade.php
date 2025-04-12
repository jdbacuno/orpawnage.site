<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animal Abuse Report Update</title>
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

    h4 {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 20px;
    }

    .report-box {
      background-color: #f9fafb;
      padding: 16px;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      margin: 16px 0;
    }

    .reason-box {
      background-color: #fef2f2;
      padding: 16px;
      border-left: 4px solid #ef4444;
      margin: 16px 0;
    }

    .footer {
      margin-top: 32px;
      padding-top: 16px;
      border-top: 1px solid #e5e7eb;
      font-size: 0.875rem;
      color: #6b7280;
    }
  </style>
</head>

<body>
  <div class="container">
    <h4>Update Regarding Your Animal Abuse Report</h4>

    <div class="content">
      <p>We regret to inform you that your animal abuse report could not be taken action:</p>

      <div class="report-box">
        <p><strong>Report Number:</strong> #{{ $report->report_number }}</p>
        <p><strong>Date Submitted:</strong> {{ $report->created_at->format('F j, Y') }}</p>
        <p><strong>Incident Location:</strong> {{ $report->incident_location }}</p>
      </div>

      <p>Unfortunately, we were unable to verify your report.</p>

      <p>If you believe this decision was made in error or would like to provide additional information,
        please contact us with your report number for further assistance.</p>
    </div>

    <div class="footer">
      <p>Thank you for your understanding,</p>
      <p><strong>The Orpawnage Team</strong></p>
      <p><small>This is an automated message. Please do not reply directly to this email.</small></p>
    </div>
  </div>
</body>

</html>