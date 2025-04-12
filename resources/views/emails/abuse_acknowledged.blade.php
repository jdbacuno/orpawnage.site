<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animal Abuse Report Acknowledgment</title>
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

    .content {
      color: #374151;
      line-height: 1.6;
    }

    .report-box {
      background-color: #f9fafb;
      padding: 16px;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      margin-top: 16px;
      margin-bottom: 16px;
    }

    .report-box p {
      margin: 4px 0;
    }

    .font-medium {
      font-weight: 500;
    }

    .font-semibold {
      font-weight: 600;
    }

    .footer {
      margin-top: 32px;
      padding-top: 16px;
      border-top: 1px solid #e5e7eb;
      font-size: 0.875rem;
      color: #6b7280;
    }

    .footer p {
      margin: 4px 0;
    }

    .italic {
      font-style: italic;
    }

    .bold {
      font-weight: bold;
      color: #1f2937;
    }

    .small-note {
      margin-top: 8px;
      font-size: 0.75rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <h4>Thank you for reporting animal abuse</h4>

    <div class="content">
      <p>We have received and processed your animal abuse report:</p>

      <div class="report-box">
        <p class="font-medium">Report Details:</p>
        <p><span class="font-semibold">Report Number:</span> #{{ $report->report_number }}</p>
        <p><span class="font-semibold">Date Submitted:</span> {{ $report->created_at->format('F j, Y') }}</p>
        <p><span class="font-semibold">Incident Location:</span> {{ $report->incident_location }}</p>
      </div>

      <p>Our team has reviewed your report and taken appropriate action. We take all reports seriously and appreciate
        your vigilance in helping protect animals.</p>

      <p>If you have any additional information or questions regarding this case, please reference the report number
        above when contacting us.</p>
    </div>

    <div class="footer">
      <p>Thank you for making a difference,</p>
      <p class="italic bold">Orpawnage Team</p>
      <p class="small-note">This is an automated message. Please do not reply directly to this email.</p>
    </div>
  </div>
</body>

</html>