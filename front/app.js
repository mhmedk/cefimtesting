// Ajout du listener au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('groupForm')
    form.addEventListener('submit', getApprenants)
})

// Fonction pour récupérer les apprenants depuis le serveur
function getApprenants(event) {

    event.preventDefault()

    const genderCheckbox = document.getElementById('gender');
    const genderFilter = genderCheckbox.checked;

    const skillsCheckbox = document.getElementById('skillsFilter');
    const skillsFilter = skillsCheckbox.checked;

    const maxApprenantsPerGroup = document.getElementById('groupSize').value

    // Faire une requête fetch pour obtenir les apprenants
    fetch('../back/group.php?maxApprenantsPerGroup=' + maxApprenantsPerGroup
        + '&genderfilter=' + genderFilter.toString()
        + '&skillsFilter=' + skillsFilter.toString())
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
    console.log(apprenantsFiltres);
    const result = document.getElementById("resultats")
    result.innerHTML = ""

    apprenantsFiltres.forEach((apprenantGroup, index) => {

        indexVal = index + 1

        let h3 = document.createElement("h3")
        h3.textContent = "Groupe " + indexVal

        let ul = document.createElement("ul")
        apprenantGroup.forEach((apprenant) => {
            let item = document.createElement("li")
            item.textContent = apprenant.name + ' ' + apprenant.firstname
            ul.appendChild(item)

        })
        result.appendChild(h3)
        result.appendChild(ul)

    })

}
