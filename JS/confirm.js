// Asks "Are you sure?" before a form is sent.
// Add data-confirm="Your message" to any <form> that should ask first.
document.addEventListener('submit', function (event) {
  const message = event.target.dataset.confirm;
  if (message && !window.confirm(message)) {
    event.preventDefault();
  }
});
