import {
    sleep,
    isNotAuthorized,
    getInitials,
    areUsersLoaded
} from './helper.js';

const createProjectBtns = document.querySelectorAll('.create-project__JS');
const createTaskBtns = document.querySelectorAll('.create-task__JS');
const deleteProjectBtns = document.querySelectorAll('.delete-project__JS');
const deleteTaskBtns = document.querySelectorAll('.delete1-project__JS');
const updateProjectBtns = document.querySelectorAll('.update-project__JS');
const updateTaskBtns = document.querySelectorAll('.update1-project__JS');
const cancelBtns = document.querySelectorAll('.pop-up__cancel-btn');
const textarea = document.querySelector('.pop-up__textarea');
const togglerMenu = document.querySelectorAll('.left-menu__btn');
const description = document.querySelectorAll('.project-description__JS');
const descriptionTasks = document.querySelectorAll('.project-description-tasks__JS');
const updateDashboard = document.querySelectorAll('.update-dashboard__JS');
const manageMembersBtn = document.querySelector('.manage-members__JS');
const inviteMembersBtn = document.querySelector('.pop-up__invite-btn');

const handleProjectCreateForm = () => {
    const form = document.querySelector('.pop-up');
    form.classList.add('pop-up__JS');
    renderBlur();
}


const handleTaskCreateForm = () => {
    const form = document.querySelector('.pop-up');
    form.classList.add('pop-up__JS');
    renderBlur();
}

const renderWarning = async () => {
    const body = document.body;

    const container = document.createElement('div');
    container.classList.add('pop-up__warning');

    const title = document.createElement('h2');
    title.classList.add('pop-up__warning-title');
    title.textContent = "Warning!";
    container.appendChild(title);

    const text = document.createElement('h3');
    text.textContent = "Not Authorized."
    container.appendChild(text);

    const description = document.createElement('p');
    description.textContent = "You are not authorized to perform the request on this project.";
    container.appendChild(description);

    body.appendChild(container);
    renderBlur();
    await sleep(1500);
    removeWarning();
    removeBlur();
}

const removeWarning = () => {
    const container = document.querySelector('.pop-up__warning');
    container.parentNode.removeChild(container);
}

const renderBlur = () => {
    const blur = document.createElement('div');
    blur.classList.add('blur__JS');
    document.body.appendChild(blur);
}

const removeBlur = () => {
    const blur = document.querySelector('.blur__JS');
    blur.parentNode.removeChild(blur);
}

const handleProjectDeleteForm = (id, role) => {
    if (isNotAuthorized(role)) {
        renderWarning();
        return;
    }
    const form = document.querySelector('.pop-up__delete');
    const deleteBtn = document.querySelector('.pop-up__confirm-btn');
    const link = `delete.php?Projekto_id=${id}`;
    deleteBtn.setAttribute('href', `${link}`);
    form.classList.add('pop-up__JS');
    renderBlur();
}
const handleClickDeleteForm1 = (id, title, Projekto_id) => {
    const form = document.querySelector('.pop-up__delete1');
    const deleteBtn = document.querySelector('.pop-up__confirm-btn1');
    const link = `delete1.php?Uzduoties_id=${id}&title=${title}&Projekto_id=${Projekto_id}`;
    deleteBtn.setAttribute('href', `${link}`);
    form.classList.add('pop-up__JS');
    renderBlur();
}

const handleUpdateForm = (title, description, id, role) => {
    if (isNotAuthorized(role)) {
        renderWarning();
        return;
    }
    const form = document.querySelector('.pop-up__update');
    const inputTitle = document.querySelector('.pop-up__update-title');
    const inputDescription = document.querySelector('.pop-up__update-description');
    const inputId = document.querySelector('.pop-up__update-id');
    inputTitle.setAttribute('value', `${title}`);
    inputId.setAttribute('value', `${id}`);
    inputDescription.innerText = `${description}`;
    form.classList.add('pop-up__JS');
    renderBlur();
}


const removeChecked = () => {
    let test = document.querySelectorAll('.pop-up__update-priority');
    let test2 = document.querySelectorAll('.pop-up__update-status');
    test.forEach(t => {
        t.removeAttribute('checked');
    });

    test2.forEach(t2 => {
        t2.removeAttribute('checked');
    });
}

const handleTaskUpdateForm = (title, priority, busena, description, id) => {
    removeChecked();
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
    inputTitle.setAttribute('value', `${title.trimStart()}`);
    inputId.setAttribute('value', `${id}`);
    inputDescription.innerText = `${description}`;
    taskPriority.setAttribute('checked', '');
    taskBusena.setAttribute('checked', '');
    form.classList.add('pop-up__JS');
    renderBlur();
}

const handleCloseForm = () => {
    const form = document.querySelector('.pop-up__JS');
    form.classList.remove('pop-up__JS');
    removeBlur();
}

const handleClickRemovePlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = '';
}

const handleClickAddPlaceholder = () => {
    document.querySelector('.pop-up__placeholder').textContent = 'Description';
}

const handleToggleMenu = () => {
    const body = document.body;
    body.classList.toggle('left-menu__JS');
}

const renderUserInfo = (initials, fullname) => {
    const usersTable = document.querySelector('.pop-up__users');
    const tr = document.createElement('tr');
    const initialsData = document.createElement('td');
    initialsData.textContent = initials.toUpperCase();
    initialsData.classList.add('pop-up__members-initials');
    tr.appendChild(initialsData);

    const fullnameData = document.createElement('td');
    fullnameData.innerHTML = fullname;
    fullnameData.classList.add('pop-up__members-info');
    tr.appendChild(fullnameData);
    usersTable.appendChild(tr);
}

const handleMembersForm = (members) => {
    const form = document.querySelector('.pop-up__members');
    const fullNames = members.split(',');
    const initials = getInitials(fullNames);

    form.classList.add('pop-up__JS');
    renderBlur();
    if (areUsersLoaded()) return;
    initials.forEach((initial, index) => {
        renderUserInfo(initial, fullNames[index]);
    });
}

const handleInviteMembers = () => {
    handleCloseForm();
    const form = document.querySelector('.pop-up__invite');
    form.classList.add('pop-up__JS');
    renderBlur();
}

togglerMenu.forEach(btn => {
    btn.addEventListener('click', handleToggleMenu);
});

createProjectBtns.forEach(
    btn => btn.addEventListener('click', handleProjectCreateForm)
);

createTaskBtns.forEach(
    btn => btn.addEventListener('click', handleTaskCreateForm)
);


updateProjectBtns.forEach(
    btn => btn.addEventListener('click', () => {
        const title = btn.parentElement.parentElement.children[1].textContent;
        const description = btn.parentElement.parentElement.children[2].textContent;
        const id = btn.parentElement.children[1].id;
        const role = btn.getAttribute('data-role');
        handleUpdateForm(title, description, id, role);
    }));

updateTaskBtns.forEach(
    btn => btn.addEventListener('click', () => {
        const title = btn.parentElement.parentElement.children[1].textContent;
        const description = btn.parentElement.parentElement.children[2].textContent;
        const priority = btn.parentElement.parentElement.children[3].textContent;
        const busena = btn.parentElement.parentElement.children[4].textContent
        const id = btn.parentElement.children[1].id;
        handleTaskUpdateForm(title, priority, busena, description, id);
    }));


description.forEach(
    fullDescription => fullDescription.addEventListener('click', () => {
        const title = fullDescription.parentElement.parentElement.children[1].textContent;
        const description = fullDescription.parentElement.parentElement.children[2].textContent;
        const id = fullDescription.parentElement.parentElement.children[0].textContent;
        handleClickUpdateForm(title, description, id);
    }));

descriptionTasks.forEach(
    descriptionTask => descriptionTask.addEventListener('click', () => {
        const title = descriptionTask.parentElement.parentElement.children[1].textContent;
        const description = descriptionTask.parentElement.parentElement.children[2].textContent;
        const priority = descriptionTask.parentElement.parentElement.children[3].textContent;
        const busena = descriptionTask.parentElement.parentElement.children[4].textContent
        const id1 = descriptionTask.parentElement.parentElement.children[0].textContent;
        handleTaskUpdateForm(title, priority, busena, description, id1);
    }));

updateDashboard.forEach(
    item => item.addEventListener('click', () => {
        const title = item.textContent;
        const description = item.getAttribute('data-description');
        const priority = item.getAttribute('data-priority');
        const busena = item.getAttribute('data-status');
        const id1 = item.getAttribute('data-id');
        handleTaskUpdateForm(title, priority, busena, description, id1);
    }));

deleteTaskBtns.forEach(
    btn => btn.addEventListener('click', () => {
        const id = btn.id;
        const title = btn.getAttribute('data-title');
        const project_id = btn.getAttribute('data-id');
        handleClickDeleteForm1(id, title, project_id);
    }));

deleteProjectBtns.forEach(
    btn => btn.addEventListener('click', () => {
        const id = btn.id;
        const role = btn.getAttribute('data-role');
        handleProjectDeleteForm(id, role)
    }));

cancelBtns.forEach(
    cancelBtn => cancelBtn.addEventListener('click', handleCloseForm)
);

if (textarea) {
    textarea.addEventListener('focus', handleClickRemovePlaceholder);
    textarea.addEventListener('focusout', handleClickAddPlaceholder);
}
console.log(inviteMembersBtn)
if(inviteMembersBtn){
manageMembersBtn.addEventListener('click', () => {
    const members = manageMembersBtn.getAttribute('data-users');
    handleMembersForm(members);
});

inviteMembersBtn.addEventListener('click', handleInviteMembers);
}

window.addEventListener('load', (event) => {
    if (document.querySelector('[data-link]')) {
        const exportBtn = document.querySelector('.export');
        const link = document.querySelector('[data-link]').getAttribute('data-link').replace(/\n$/, '');
        exportBtn.setAttribute('href', link);
    }
});