function toggleRejectReason() {
  document.getElementById('rejectReasonShort').classList.toggle('hidden');
  document.getElementById('rejectReasonFull').classList.toggle('hidden');
  const btn = document.getElementById('seeMoreBtn');
  btn.textContent = btn.textContent === 'See Less' ? 'See More' : 'See Less';
}