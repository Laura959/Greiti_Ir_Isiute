const createBtn = document.querySelector('.create-project__JS');
const cancelBtn = document.querySelector('.pop-up__cancel-btn');
const textarea = document.querySelector('.pop-up__textarea');

const handleClickCreateProject = () =>{
    const blur = document.createElement('div');
    blur.classList.add('blur__JS');
    document.querySelector('.pop-up').classList.add('pop-up__JS')
    document.body.appendChild(blur);
}

const handleClickCancelProject = () =>{
    const blur = document.querySelector('.blur__JS');
    document.querySelector('.pop-up').classList.remove('pop-up__JS');
    blur.parentNode.removeChild(blur);
}

const handleClickRemovePlaceholder = () =>{
    document.querySelector('.pop-up__placeholder').textContent = '';
}

const handleClickAddPlaceholder = () =>{
    document.querySelector('.pop-up__placeholder').textContent = 'Description';
}

createBtn.addEventListener('click', handleClickCreateProject);
cancelBtn.addEventListener('click', handleClickCancelProject);
textarea.addEventListener('focus', handleClickRemovePlaceholder);
textarea.addEventListener('focusout', handleClickAddPlaceholder);
