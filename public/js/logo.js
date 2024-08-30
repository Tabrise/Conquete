document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('etat_societe_logo')
    const logo = document.getElementById('logo').innerHTML = '<h1><i class="' + document.getElementById('etat_societe_logo').value + ' " ></i></h1>'

    select.addEventListener('change', () => {
        const logo = document.getElementById('logo').innerHTML = '<h1><i class="' + document.getElementById('etat_societe_logo').value + ' " ></i></h1>'
    })
})