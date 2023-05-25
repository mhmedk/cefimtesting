// Ajout du listener au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('groupForm')
    form.addEventListener('submit', getApprenants)
})

// Fonction pour récupérer les apprenants depuis le serveur
function getApprenants(event) {

    event.preventDefault()

    const ageCheckbox = document.getElementById('age');
    const ageFilter = ageCheckbox.checked;

    const maxApprenantsPerGroup = document.getElementById('groupSize').value;

    // Faire une requête fetch pour obtenir les apprenants
    fetch('../back/group.php?maxApprenantsPerGroup=' + maxApprenantsPerGroup + '&agefilter=' + ageFilter.toString())
        .then((response) => {
            if (response.ok) {
                return response.json()
            } else {
                throw new Error('Erreur lors de la récupération des apprenants : ' + response.status)
            }
        })
        .then((groups) => {
            displayGroups(groups)
        })
        .catch(function(error) {
            console.error('Erreur lors de la récupération des apprenants : ' + error.message)
        })

}

// Fonction d'affichage des apprenants
function displayGroups(apprenantsFiltres) {

    const result = document.getElementById("resultats")
    result.innerHTML = ""

    apprenantsFiltres.forEach((apprenantGroup) => {

        let ul = document.createElement("ul")
        apprenantGroup.forEach((apprenant) => {

            let item = document.createElement("li")
            item.textContent = apprenant.name + ' ' + apprenant.firstname
            ul.appendChild(item)

        })
        result.appendChild(ul)

    })

}
