const createBtns    = document.querySelectorAll('.create-project__JS');
const createBtnsTask    = document.querySelectorAll('.create-task__JS');
const deleteBtns    = document.querySelectorAll('.delete-project__JS');
const updateBtns    = document.querySelectorAll('.update-project__JS');
const cancelBtns    = document.querySelectorAll('.pop-up__cancel-btn');
const textarea      = document.querySelector('.pop-up__textarea');

const handleClickCreateForm = () => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up');
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}
const handleClickCreateFormTask = () => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up');
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}

const handleClickDeleteForm = id => {
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

const handleClickUpdateForm = (title, description, id) => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up__update');
    const inputTitle = document.querySelector('.pop-up__update-title');
    const inputDescription = document.querySelector('.pop-up__update-description');
    const inputId = document.querySelector('.pop-up__update-id');
    inputTitle.setAttribute('value', `${title}`);
    inputId.setAttribute('value', `${id}`);
    inputDescription.innerText = `${description}`;
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}

const handleClickCloseForm = () => {
    const blur = document.querySelector('.blur__JS');
    const createForm = document.querySelector('.pop-up');
    const createFormTask = document.querySelector('.pop-up');
    const deleteForm = document.querySelector('.pop-up__delete');
    const updateForm = document.querySelector('.pop-up__update');
    if (createForm.classList.contains('pop-up__JS')) {
        createForm.classList.remove('pop-up__JS');
    } else if (deleteForm.classList.contains('pop-up__JS')) {
        deleteForm.classList.remove('pop-up__JS');
    } else if (updateForm.classList.contains('pop-up__JS')){
        updateForm.classList.remove('pop-up__JS');
    }
    else if(createFormTask.classList.contains('pop-up__JS')){
        createFormTask.classList.remove('pop-up__JS');
    }
    blur.parentNode.removeChild(blur);
}

const handleClickRemovePlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = '';
}

const handleClickAddPlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = 'Description';
}

createBtns.forEach(
    createBtn => createBtn.addEventListener('click', handleClickCreateForm)
);

createBtnsTask.forEach(
    createBtnTask => createBtnTask.addEventListener('click', handleClickCreateFormTask)
);


updateBtns.forEach(
    updateBtn => updateBtn.addEventListener('click', () =>{
    const title = updateBtn.parentElement.parentElement.children[1].textContent;
    const description = updateBtn.parentElement.parentElement.children[2].textContent;
    const id = updateBtn.parentElement.children[1].id;
    handleClickUpdateForm(title, description, id);
}));

deleteBtns.forEach(
    deleteBtn => deleteBtn.addEventListener('click', () => handleClickDeleteForm(deleteBtn.id)));

cancelBtns.forEach(
    cancelBtn => cancelBtn.addEventListener('click', handleClickCloseForm)
);
textarea.addEventListener('focus', handleClickRemovePlaceholder);
textarea.addEventListener('focusout', handleClickAddPlaceholder);
