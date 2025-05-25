<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MISSING PET ALERT</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.5;
      color: #333;
      margin: 0;
      padding: 0;
      background-color: #f5f5f5;
    }

    .container {
      width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .missing-banner {
      background-color: #d9534f;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
      border-radius: 4px;
    }

    .pet-name {
      font-size: 26px;
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .main-image {
      text-align: center;
      margin: 15px 0;
      cursor: pointer;
    }

    .main-image img {
      width: 100%;
      height: auto;
      border: 1px solid #ddd;
      border-radius: 4px;
      max-height: 350px;
    }

    .details {
      background-color: #f9f9f9;
      padding: 15px;
      margin: 20px 0;
      border-left: 4px solid #d9534f;
    }

    .detail-row {
      margin-bottom: 8px;
    }

    .detail-label {
      font-weight: bold;
      color: #333;
    }

    h3 {
      text-align: left;
      color: #d9534f;
      margin-top: 30px;
    }

    .photo-gallery {
      margin-top: 10px;
    }

    .photo-gallery {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: space-between;
      align-items: baseline;
      margin: 10px 0;
    }

    .photo-gallery img {
      width: calc(50% - 10px);
      height: auto;
      aspect-ratio: 1/1;
      object-fit: cover;
      border: 1px solid #ddd;
      border-radius: 4px;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .photo-gallery img:hover {
      transform: scale(1.05);
    }

    @media only screen and (min-width: 768px) {
      .photo-gallery img {
        width: calc(33.33% - 10px);
      }
    }

    @media only screen and (max-width: 480px) {
      .photo-gallery img {
        width: calc(50% - 5px);
      }
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      text-align: center;
    }

    .modal-content {
      max-width: 90%;
      max-height: 90%;
      margin: auto;
      display: block;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .close {
      position: absolute;
      top: 20px;
      right: 30px;
      color: white;
      font-size: 35px;
      font-weight: bold;
      cursor: pointer;
    }

    .contact-info {
      background-color: #5cb85c;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      margin: 20px 0;
      border-radius: 4px;
    }

    .contact-phone {
      font-size: 22px;
      margin: 10px 0;
    }

    .footer {
      margin-top: 30px;
      padding-top: 15px;
      border-top: 1px solid #ddd;
      font-size: 12px;
      color: #777;
      text-align: center;
    }

    .reporter-note {
      background-color: #d9edf7;
      border: 1px solid #bce8f1;
      padding: 15px;
      margin: 20px 0;
      border-radius: 4px;
      color: #31708f;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="missing-banner">MISSING PET</div>
      <div class="pet-name">{{ $report->pet_name }}</div>
    </div>

    <div class="main-image"
      onclick="openModal('{{ $message->embed(storage_path('app/public/' . str_replace('storage/', '', $mainPetPhotoUrl))) }}')">
      @if($mainPetPhotoUrl)
      <img src="{{ $message->embed(storage_path('app/public/' . str_replace('storage/', '', $mainPetPhotoUrl))) }}"
        alt="{{ $report->pet_name }}">
      @endif
    </div>

    <div class="details">
      <div class="detail-row">
        <span class="detail-label">Last Seen:</span> {{ date('F j, Y', strtotime($report->last_seen_date)) }}
      </div>
      <div class="detail-row">
        <span class="detail-label">Last Seen Location:</span> {{ $report->last_seen_location }}
      </div>
      <div class="detail-row">
        <span class="detail-label">Description:</span> {{ $report->pet_description }}
      </div>
    </div>

    @if(count($allPetPhotos) > 0)
    <h3>More Photos of {{ $report->pet_name }}:</h3>
    <div class="photo-gallery">
      @foreach($allPetPhotos as $photo)
      @php
      $embeddedUrl = $message->embed(storage_path('app/public/' . str_replace('storage/', '', $photo)));
      @endphp
      <img src="{{ $embeddedUrl }}" alt="Additional photos of {{ $report->pet_name }}"
        onclick="openModal('{{ $embeddedUrl }}')">
      @endforeach
    </div>
    @endif

    @if(count($locationPhotos) > 0)
    <h3>Where Our Pet Was Last Seen or Might Have Gone:</h3>
    <div class="photo-gallery">
      @foreach($locationPhotos as $photo)
      @php
      $embeddedUrl = $message->embed(storage_path('app/public/' . str_replace('storage/', '', $photo)));
      @endphp
      <img src="{{ $embeddedUrl }}" alt="Location photos where {{ $report->pet_name }} was last seen"
        onclick="openModal('{{ $embeddedUrl }}')">
      @endforeach
    </div>
    @endif

    <div class="contact-info">
      <div>IF YOU HAVE SEEN THIS PET</div>
      <div>Please contact {{ $report->owner_name }}</div>
      <div class="contact-phone">{{ $report->contact_no }}</div>
    </div>

    @if($isReporter)
    <div class="reporter-note">
      <strong>Note to reporter:</strong> This alert has been sent to all registered users in our community. You can
      check the status of your report anytime by visiting the <a
        href="{{ url('/transactions/missing-status') }}">Missing Pet Status</a> page.
    </div>
    @endif

    <div class="footer">
      <p>This is an automated message from the Orpawnage Team. Please do not reply to this email.</p>
    </div>
  </div>

  <!-- Modal for enlarged images -->
  <div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
  </div>

  <script>
    function openModal(imageSrc) {
      const modal = document.getElementById('imageModal');
      const modalImg = document.getElementById('modalImage');
      modal.style.display = 'block';
      modalImg.src = imageSrc;
    }

    function closeModal() {
      document.getElementById('imageModal').style.display = 'none';
    }

    window.onclick = function (event) {
      const modal = document.getElementById('imageModal');
      if (event.target == modal) {
        closeModal();
      }
    }
  </script>
</body>

</html>