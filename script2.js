const form = document.querySelector("form");
const role = document.getElementById("role");
const username = document.getElementById("username");
const password = document.getElementById("password");

form.addEventListener("submit", function (event) {
  event.preventDefault();

  const selectedRole = role.value;
  const user = username.value.trim();
  const pass = password.value.trim();

  // Validasi sederhana
  if (selectedRole === "admin") {
    if (user === "admin" && pass === "admin123") {
      alert("Login berhasil sebagai Admin!");
      document.body.style.backgroundColor = "#d1f7c4";
    } else {
      alert("Username atau password Admin salah!");
      document.body.style.backgroundColor = "#f7c4c4";
    }
  } else if (selectedRole === "user") {
    if (user === "user" && pass === "user123") {
      alert("Login berhasil sebagai User!");
      document.body.style.backgroundColor = "#c4e3f7";
    } else {
      alert("Username atau password User salah!");
      document.body.style.backgroundColor = "#f7c4c4";
    }
  }
});
