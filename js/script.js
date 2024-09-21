const button = document.getElementById("");

button.addEventListener("click", (event) => {
  button.textContent = `Click count: ${event.detail}`;
});
