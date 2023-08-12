document.getElementById("calendar").addEventListener("input", function () {
  // Appel API
  // Une fois données de l'API reçues, les ajouter dans le tableau

  // Exemple de données de stand (à remplacer par les données de l'API) :
  const standData = {
    lieu: "Emplacement A",
    creneaux: "10h-12h, 14h-16h",
    personnes: "John Doe, Jane Smith",
  };

  // Mettre à jour les valeurs dans le tableau
  const table = document.getElementById("standDetails");
  const tbody = table.querySelector("tbody");
  tbody.innerHTML = `
    <tr>
      <td>${standData.lieu}</td>
      <td>${standData.creneaux}</td>
      <td>${standData.personnes}</td>
    </tr>
  `;

  // Afficher le tableau
  table.classList.add("visible");
});
