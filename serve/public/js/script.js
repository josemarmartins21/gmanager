var overlay = document.getElementById('overlay')
var btn = document.getElementById('modal-btn')
var modal = document.getElementById('modal')
var modalTable = document.getElementById('modal-table')
var btnTheme = document.getElementById('btn-theme')
var btnCloseModal = document.getElementById('close-modal-btn')
/* var btnCloseModalTable = document.getElementById('close-modal-btn-table')
var overlayTable = document.getElementById('overlay-modal-table') */

overlay.addEventListener('click', showModalPlanos) // Modal
/* overlayTable.addEventListener('click', abrirModalTable) */ // Modal
btnCloseModal.addEventListener('click', showModalPlanos) // Modal
/* btnCloseModalTable.addEventListener('click', abrirModalTable) */ // Modal

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card')
    
    cards.forEach(card => {
        const cardBtn = card.querySelector('.ver-mais-plano')   
        const item = card.dataset.item
        let instacia = null

        if (item) {
            try {
                instacia = JSON.parse(item)
            } catch (error) {
                console.warn('Dados do card inválidos:', item)
            }
        }

        if (cardBtn) {
            cardBtn.addEventListener('click', () => {
                showModalPlanos(instacia)
            })
        }
    });


    const lines = document.querySelectorAll('.table-line')

    lines.forEach(line => {
        const cardBtn = line.querySelector('.ver-mais-contact')   
        const item = line.dataset.contact
        const user = line.dataset.user
        let instacia = null
        let instaciaUser = null

        if (item) {
            try {
                instacia = JSON.parse(item)
                instaciaUser = JSON.parse(user)
            } catch (error) {
                console.warn('Dados do card inválidos:', item)
            }
        }

        if (cardBtn) {
            cardBtn.addEventListener('click', () => {
                showModalContacts(instacia, instaciaUser)
            })
        }
    });

    var btnFloat = document.getElementById('float-btn')
    var btnCloseModalTable = document.getElementById('close-modal-btn-table')
    var overlayTable = document.getElementById('overlay-modal-table') 
    overlayTable.addEventListener('click', abrirModalTable)
    btnCloseModalTable.addEventListener('click', abrirModalTable)
    
    btnFloat.addEventListener('click', abrirModalTable)
    
    
    function abrirModalTable() {
        var wantOpen = overlayTable.classList.contains('hidden')
        var o = overlayTable
        var m = modalTable
    
        if (wantOpen) {
            setBoxPositionToOpen(o)   
            setBoxPositionToOpen(m)
        }
        
        if (! wantOpen) {
            alternarClass(o) 
            alternarClass(m) 
        }
    }
})



function showModalIndicacoes() {
    abrirModal()
}

function showModalContacts(dado, instaciaUser) {
    var title = document.getElementById('modal-title')
    var phone = document.getElementById('modal-phone')
    var email = document.getElementById('modal-email')
    var bairro = document.getElementById('modal-bairro')
    var indicacoes = document.getElementById('modal-indicacoes')
    var street = document.getElementById('modal-street')
    var user = document.getElementById('modal-user')

    abrirModal()
    
    title.innerText = dado.first_name + ' ' + dado.last_name;
    phone.innerText = dado.phone;
    email.innerText = dado.email;
    bairro.innerText = dado.bairro + ' - ' + dado.municipio;
    street.innerText = dado.street;
    indicacoes.innerText = dado.indicacoes;
    user.innerText = instaciaUser.name;
    
}

function showModalPlanos(dado) {
    var title = document.getElementById('modal-title')
    var price = document.getElementById('modal-price')
    var velocity = document.getElementById('modal-velocity')
    var description = document.getElementById('modal-description')
    var userName = document.getElementById('modal-user')
    
    abrirModal() 

    title.innerText = dado.name;
    price.innerText = dado.price + 'Kz';
    velocity.innerText = dado.velocity_download + 'Mbps';
    description.innerText = dado.description;
    userName.innerText = dado.user_name;
    
}


function abrirModal() {
    var wantOpen = overlay.classList.contains('hidden')
    var o = overlay
    var m = modal

    if (wantOpen) {
        setBoxPositionToOpen(o)   
        setBoxPositionToOpen(m)
    }
    
    if (! wantOpen) {
        alternarClass(o) 
        alternarClass(m) 
    } 
}

function alternarClass(o) {
    o.classList.toggle('hidden') 
}

function setBoxPositionToOpen(o) {
    alternarClass(o)
    o.classList.add('abrir') 
}

// Persistência do tema
const temasalvo = localStorage.getItem('tema');
changeMode(temasalvo === 'escuro')

btnTheme.addEventListener('click', () => {
  var corpo = document.getElementById('corpo')
  const isescuro = corpo.classList.toggle('dark');

  changeMode(isescuro);
  localStorage.setItem('tema', isescuro ? 'escuro' : 'claro');
}) // Dark Mode

function changeMode(tipo) {
    if (tipo == true) {
        corpo.classList.add('dark')
        btnTheme.innerHTML = '<i class="fa-solid fa-sun"></i>';
        return
    } 

    if (tipo == false) {
        corpo.classList.remove('dark')
        btnTheme.innerHTML = '<i class="fa-solid fa-moon"></i>';
        return
    }
}