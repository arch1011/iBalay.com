
// Wrap your JavaScript code in the window.onload event
window.onload = function () {
  // Add an event listener for the notification icon
  document.getElementById('notification-icon').addEventListener('click', function () {
    // When the icon is clicked, update the count to 0
    document.querySelector('.badge-number').textContent = '0';
  });
};
