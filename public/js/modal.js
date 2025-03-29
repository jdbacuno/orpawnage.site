// Delete/Cancel Adoption Application
function openCancelModal(applicationId) {
  document.getElementById('cancelModal').classList.remove('hidden');
  document.getElementById('deleteForm').action = "/transactions/" + applicationId;
}

function closeCancelModal() {
  document.getElementById('cancelModal').classList.add('hidden');
}