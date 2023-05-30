window.addEventListener("DOMContentLoaded", (e) => {
  // Compteur de caractère pour les articles
  const updateCounter = (
    input,
    counter,
    maxLength,
    pourcentLow,
    pourcentMiddle
  ) => {
    const valueLength = input.value.length;
    const caractereRestant = maxLength - valueLength;

    if (caractereRestant <= pourcentLow) {
      counter.classList.remove("btn-success", "btn-warning");
      counter.classList.add("btn-danger");
    } else if (caractereRestant <= pourcentMiddle) {
      counter.classList.remove("btn-success", "btn-danger");
      counter.classList.add("btn-warning");
    } else {
      counter.classList.remove("btn-danger", "btn-warning");
      counter.classList.add("btn-success");
    }

    if (caractereRestant < 0) return;

    counter.textContent = caractereRestant;
  };
  //INPUT
  const inputAuteur = document.querySelector(".article-auteur");
  const inputTitre = document.querySelector(".article-titre");
  const inputDescription = document.querySelector(".article-description");

  //COMPTEUR SELECTEUR
  const counterAuteur = document.querySelector(".count-auteur");
  const counterTitre = document.querySelector(".count-titre");
  const counterDescription = document.querySelector(".count-description");
  //MAXLENGTH
  const maxLength = inputAuteur.getAttribute("maxlength");
  const maxLengthTitre = inputTitre.getAttribute("maxlength");
  const maxLengthDescription = inputDescription.getAttribute("maxlength");

  const pourcentMiddle = maxLength * 0.6;
  const pourcentLow = maxLength * 0.25;

  //Compteur Auteur
  inputAuteur.addEventListener("input", (e) => {
    updateCounter(
      inputAuteur,
      counterAuteur,
      maxLength,
      pourcentLow,
      pourcentMiddle
    );
  });

  //Compteur Titre
  inputTitre.addEventListener("input", (e) => {
    updateCounter(
      inputTitre,
      counterTitre,
      maxLengthTitre,
      pourcentLow,
      pourcentMiddle
    );
  });
  //Compteur Description
  inputDescription.addEventListener("input", (e) => {
    updateCounter(
      inputDescription,
      counterDescription,
      maxLengthDescription,
      pourcentLow,
      pourcentMiddle
    );
  });
});
