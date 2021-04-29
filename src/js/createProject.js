const createBtn     = document.querySelector('.create-project__JS');
const deleteBtns    = document.querySelectorAll('.delete-project__JS');
const cancelBtns    = document.querySelectorAll('.pop-up__cancel-btn');
const textarea      = document.querySelector('.pop-up__textarea');

const handleClickCreateForm = () => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up');
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}

const handleClickDeleteForm = (id) => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up__delete');
    const deleteBtn = document.querySelector('.pop-up__confirm-btn');
    const link = `delete.php?Projekto_id=${id}`;
    deleteBtn.setAttribute('href', `${link}`);
    console.log(deleteBtn.getAttribute('href'))
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}

const handleClickRemoveForm = () => {
    const blur = document.querySelector('.blur__JS');
    const createForm = document.querySelector('.pop-up');
    const deleteForm = document.querySelector('.pop-up__delete');
    if (createForm.classList.contains('pop-up__JS')) {
        createForm.classList.remove('pop-up__JS');
    } else if (deleteForm.classList.contains('pop-up__JS')) {
        deleteForm.classList.remove('pop-up__JS')
    }
    blur.parentNode.removeChild(blur);
}

const handleClickRemovePlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = '';
}

const handleClickAddPlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = 'Description';
}

createBtn.addEventListener('click', handleClickCreateForm);

deleteBtns.forEach(
    deleteBtn => deleteBtn.addEventListener('click', () => handleClickDeleteForm(deleteBtn.id)));

cancelBtns.forEach(
    cancelBtn => cancelBtn.addEventListener('click', handleClickRemoveForm)
);
textarea.addEventListener('focus', handleClickRemovePlaceholder);
textarea.addEventListener('focusout', handleClickAddPlaceholder);
