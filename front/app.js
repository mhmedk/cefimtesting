// Données des apprenants filtrés pour le dev
let apprenantsFalse = [
    [
        { promotion: 2021, nom: "Apprenant 1", prenom: "John", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
        { promotion: 2021, nom: "Apprenant 1", prenom: "Marc", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
    ],
    [
        { promotion: 2021, nom: "Apprenant 1", prenom: "Louis", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
        { promotion: 2021, nom: "Apprenant 1", prenom: "Mohammed", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
    ],
    [
        { promotion: 2021, nom: "Apprenant 1", prenom: "Bilal", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
        { promotion: 2021, nom: "Apprenant 1", prenom: "Pierre", age: 25, sexe: "Homme", competences: ["JavaScript", "HTML"] },
    ]
]

// Fonction d'affichage des apprenants filtrés
function afficherApprenants(apprenantsFiltres = apprenantsFalse) {
    const result = document.getElementById("resultats")
    result.innerHTML = ""

    apprenantsFiltres.forEach((apprenantGroup) => {

        let ul = document.createElement("ul")
        apprenantGroup.forEach((apprenant) => {

            let item = document.createElement("li")
            item.textContent = apprenant.prenom
            ul.appendChild(item)

        })
        result.appendChild(ul)

    })

}
