const spesialisSelect = document.getElementById("spesialis");
const formPendaftaran = document.querySelector("#pendaftaran form");
const tentangKami = document.getElementById("tentang");
const darkModeBtn = document.getElementById("darkModeBtn");
let isDark = false;

spesialisSelect.addEventListener("change", function () {
  alert("Anda memilih spesialis: " + spesialisSelect.value);
});

formPendaftaran.addEventListener("submit", function (event) {
  event.preventDefault();
  const nama = document.getElementById("nama").value;
  if (nama.trim() === "") {
    alert("Nama tidak boleh kosong!");
  } else {
    alert("Terima kasih sudah mendaftar, " + nama + "!");
  }
});

tentangKami.addEventListener("mouseenter", function () {
  tentangKami.style.backgroundColor = "#e0f7fa";
});
tentangKami.addEventListener("mouseleave", function () {
  tentangKami.style.backgroundColor = "transparent";
});

darkModeBtn.addEventListener("click", function () {
  document.body.classList.toggle("dark-mode");

  if (document.body.classList.contains("dark-mode")) {
    darkModeBtn.textContent = "Light Mode";
  } else {
    darkModeBtn.textContent = "Dark Mode";
  }
});
