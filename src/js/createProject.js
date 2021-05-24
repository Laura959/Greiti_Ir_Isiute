const createBtns = document.querySelectorAll('.create-project__JS');
const createBtnsTask = document.querySelectorAll('.create-task__JS');
const deleteBtns = document.querySelectorAll('.delete-project__JS');
const updateBtns = document.querySelectorAll('.update-project__JS');

const updateBtns1 = document.querySelectorAll('.update1-project__JS');

const cancelBtns = document.querySelectorAll('.pop-up__cancel-btn');
const textarea = document.querySelector('.pop-up__textarea');
const deleteBtns1 = document.querySelectorAll('.delete1-project__JS');
const cancelBtns1 = document.querySelectorAll('.pop-up__cancel-btn1');
const description = document.querySelectorAll('.project-description__JS');
const descriptionTasks = document.querySelectorAll('.project-description-tasks__JS');

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
const handleClickDeleteForm1 = (id, title, Projekto_id) => {
    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up__delete1');
    const deleteBtn = document.querySelector('.pop-up__confirm-btn1');
    const link = `delete1.php?Uzduoties_id=${id}&title=${title}&Projekto_id=${Projekto_id}`;
    deleteBtn.setAttribute('href', `${link}`);
    console.log(deleteBtn.getAttribute('href'))
    form.classList.add('pop-up__JS');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}
const handleClickCloseForm1 = () => {
    const blur = document.querySelector('.blur__JS');
    const deleteForm = document.querySelector('.pop-up__delete1');
    const updateForm = document.querySelector('.pop-up__update1');
    if (deleteForm.classList.contains('pop-up__JS')) {
        deleteForm.classList.remove('pop-up__JS');
    } else if (updateForm.classList.contains('pop-up__JS')) {
        updateForm.classList.remove('pop-up__JS');
    }
    blur.parentNode.removeChild(blur);
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


const handleClickUpdateForm1 = (title, priority, busena, description, id1) => {
    let test = document.querySelectorAll('.pop-up__update-priority');
    let test2 = document.querySelectorAll('.pop-up__update-status');
    test.forEach(t => {
        t.removeAttribute('checked');
        console.log(t.hasAttribute('checked'));
    });

    test2.forEach(t2 => {
        t2.removeAttribute('checked');
        console.log(t2.hasAttribute('checked'));
    });

    const blur = document.createElement('div');
    const form = document.querySelector('.pop-up__update1');
    const inputTitle = document.querySelector('.pop-up__update-title1');
    const inputDescription = document.querySelector('.pop-up__update-description1');
    const inputId = document.querySelector('.pop-up__update-id1');
    const taskPriority = document.querySelector(`.priority-${priority}`);
    const masyvas = busena.split(' ');
    if (masyvas.lenght == 2) {
        masyvas.pop();
    }
    const taskBusena = document.querySelector(`.status-${masyvas[0]}`);
    inputTitle.setAttribute('value', `${title}`);
    inputId.setAttribute('value', `${id1}`);
    inputDescription.innerText = `${description}`;
    taskPriority.setAttribute('checked', '');
    taskBusena.setAttribute('checked', '');
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
    } else if (updateForm.classList.contains('pop-up__JS')) {
        updateForm.classList.remove('pop-up__JS');
    } else if (createFormTask.classList.contains('pop-up__JS')) {
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
    updateBtn => updateBtn.addEventListener('click', () => {
        const title = updateBtn.parentElement.parentElement.children[1].textContent;
        const description = updateBtn.parentElement.parentElement.children[2].textContent;
        const id = updateBtn.parentElement.children[1].id;
        handleClickUpdateForm(title, description, id);
    }));

updateBtns1.forEach(
    updateBtn => updateBtn.addEventListener('click', () => {
        const title = updateBtn.parentElement.parentElement.children[1].textContent;
        const description = updateBtn.parentElement.parentElement.children[2].textContent;
        const priority = updateBtn.parentElement.parentElement.children[3].textContent;
        const busena = updateBtn.parentElement.parentElement.children[4].textContent
        const id1 = updateBtn.parentElement.children[1].id;
        console.log(title, priority, busena, description, id1);
        handleClickUpdateForm1(title, priority, busena, description, id1);
    }));

description.forEach(
    fullDescription => fullDescription.addEventListener('click', () => {
        const title = fullDescription.parentElement.parentElement.children[1].textContent;
        const description = fullDescription.parentElement.parentElement.children[2].textContent;
        const id = fullDescription.parentElement.parentElement.children[0].textContent;
        console.log(title, description, id);
        handleClickUpdateForm(title, description, id);
    }));

descriptionTasks.forEach(
    descriptionTask => descriptionTask.addEventListener('click', () => {
        const title = descriptionTask.parentElement.parentElement.children[1].textContent;
        const description = descriptionTask.parentElement.parentElement.children[2].textContent;
        const priority = descriptionTask.parentElement.parentElement.children[3].textContent;
        const busena = descriptionTask.parentElement.parentElement.children[4].textContent
        const id1 = descriptionTask.parentElement.parentElement.children[0].textContent;
        handleClickUpdateForm1(title, priority, busena, description, id1);
    }));

deleteBtns1.forEach(
    deleteBtn => deleteBtn.addEventListener('click', () => {
        const id = deleteBtn.id;
        const title = deleteBtn.getAttribute('data-title');
        const project_id = deleteBtn.getAttribute('data-id');
        handleClickDeleteForm1(id, title, project_id);
    }));

cancelBtns1.forEach(
    cancelBtn => cancelBtn.addEventListener('click', handleClickCloseForm1)
);
deleteBtns.forEach(
    deleteBtn => deleteBtn.addEventListener('click', () => handleClickDeleteForm(deleteBtn.id)));

cancelBtns.forEach(
    cancelBtn => cancelBtn.addEventListener('click', handleClickCloseForm)
);
// textarea.addEventListener('focus', handleClickRemovePlaceholder);
// textarea.addEventListener('focusout', handleClickAddPlaceholder);

window.addEventListener('load', (event) => {
    if (document.querySelector('[data-link]')) {
        const exportBtn = document.querySelector('.export');
        const link = document.querySelector('[data-link]').getAttribute('data-link').replace(/\n$/, '');
        console.log(link);
        exportBtn.setAttribute('href', link);
    }
});