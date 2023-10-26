document.addEventListener("DOMContentLoaded", function () {
  const graphique = document.querySelector(".graphique");
  graphique.style.transform = "scale(1)"; // Mettez à l'échelle à 1 pour l'effet de zoom-in

  // Attendez 1 seconde (1000 millisecondes) avant d'afficher le reste des éléments
  setTimeout(function () {
    const colonnes = document.querySelectorAll(".colonne");
    colonnes.forEach((colonne) => {
      const valeur = colonne.querySelector(".valeur");
      const valeurFinale = parseFloat(valeur.getAttribute("data-valeur"));

      let valeurActuelle = 0;
      let interval = 10;

      const incrementerValeur = () => {
        if (valeurActuelle <= valeurFinale) {
          valeur.textContent = valeurActuelle;
          valeur.style.height = `${(valeurActuelle / valeurFinale) * 100}%`;
          valeurActuelle++;
        }
      };

      const animation = setInterval(incrementerValeur, interval);
    });
  }, 1000); // Attendre 1 seconde avant de commencer l'animation
});
