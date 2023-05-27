// Add listener on DOM loaded
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('groupForm')
    form.addEventListener('submit', getApprenants)

})

/**
 * Retrieves the list of learners based on the selected filters and displays the corresponding groups
 *
 * @param {Event} event - The triggering event
 */
function getApprenants(event) {

    event.preventDefault()

    // Gettings inputs informations
    // Checkbox for gender
    const genderCheckbox = document.getElementById('genderFilter');
    const genderFilter = genderCheckbox.checked;

    // Checkbox for age
    const ageCheckbox = document.getElementById('ageFilter');
    const ageFilter = ageCheckbox.checked;

    // Checkbox for skills
    const skillsCheckbox = document.getElementById('skillsFilter');
    const skillsFilter = skillsCheckbox.checked;

    // Group size value
    const maxApprenantsPerGroup = document.getElementById('groupSize').value

    // Make a fetch request to obtain the learners list
    fetch('../back/group.php?maxApprenantsPerGroup=' + maxApprenantsPerGroup
        + '&genderfilter=' + genderFilter.toString()
        + '&agefilter=' + ageFilter.toString()
        + '&skillsFilter=' + skillsFilter.toString())
            .then((response) => {
                if (response.ok) {
                    return response.json()
                } else {
                    console.error('Erreur lors de la récupération des apprenants : ' + response.status)
                }
            })
            .then((groups) => {
                displayGroups(groups)
            })
            .catch((error) => {
                console.error('Erreur lors de la récupération des apprenants : ' + error.message)
            })

}

/**
 * Displays the filtered groups of learners
 *
 * @param {Array<Array<Object>>} apprenantsFiltres - The filtered groups of learners
 */
function displayGroups(apprenantsFiltres) {

    // Select the div that receive the learners list
    const result = document.getElementById("results")
    result.innerHTML = ""

    apprenantsFiltres.forEach((apprenantGroup, index) => {

        // For each group of learners create a title with the group number
        let h3 = document.createElement("h3")
        h3.textContent = "Groupe " + (index + 1)

        // And an unordered list
        let ul = document.createElement("ul")

        apprenantGroup.forEach((apprenant) => {

            // For each learner create a list item with his firstname and name
            let item = document.createElement("li")
            item.textContent = apprenant.firstname + ' ' + apprenant.name

            // Add this item to the list
            ul.appendChild(item)

        })

        // Add the title and list to the result div
        result.appendChild(h3)
        result.appendChild(ul)

    })

}
