window.addEventListener("DOMContentLoaded", (event) => {
  const slider = document.querySelector(".slider");
  fetch("https://127.0.0.1:8000/admin/API/slider")
    .then((response) => response.json())
    .then((data) => {
      const nbrSlide = data.length;
      //Affichage des images
      for (let i = 0; i < data.length; i++) {
        const img = document.createElement("img");

        if (i === 0) {
          img.classList.add("active");
        }
        img.src = "/images/" + data[i].image;
        img.alt = data[i].titre;
        slider.append(img);

        //Creation des boutons radio
        const btn = document.createElement("label");
        btn.setAttribute("for", "btn");
        if (i > 0) {
          btn.classList.add("btn-radio") + btn.classList.add("margin");
        } else {
          btn.classList.add("btn-radio");
        }
        slider.append(btn);
      }

      //Ajout des informations sur la bannière
      const banniere = document.querySelector(".banniere");
      const infoBanniere = document.querySelector(".infos-banniere");

      for (let i = 0; i < data.length; i++) {
        const h3 = document.createElement("h3");
        const p = document.createElement("p");

        h3.innerHTML = data[i].titre;
        p.innerHTML = data[i].description;

        infoBanniere.appendChild(h3);
        infoBanniere.appendChild(p);
      }

      const items = document.querySelectorAll(".slider img");
      const suivant = document.querySelector(".right");
      const precedent = document.querySelector(".left");

      let count = 0;

      function slideSuivante() {
        items[count].classList.remove("active");
        if (count < nbrSlide - 1) {
          count++;
        } else {
          count = 0;
        }
        items[count].classList.add("active");
        console.log(count);
      }
      setInterval(slideSuivante, 8000);
      suivant.addEventListener("click", slideSuivante);

      function slidePrecedente() {
        items[count].classList.remove("active");
        if (count > 0) {
          count--;
        } else {
          count = nbrSlide - 1;
        }
        items[count].classList.add("active");
      }
      precedent.addEventListener("click", slidePrecedente);
    });
});
