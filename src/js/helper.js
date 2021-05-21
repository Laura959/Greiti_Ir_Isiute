export const sleep = ms => {
    return new Promise((accept) => {
        setTimeout(() => {
            accept();
        }, ms);
    });
}

export const isNotAuthorized = (role)=>{
    return role !== '1' ? true : false;
}

export const getInitials = (fullNames)=>{
    let initials = [];
    if(Array.isArray(fullNames) && !fullNames.lenght){
        fullNames.forEach(fullName =>{
            if(fullName){
                initials.push(fullName.split(' ').map((name) => name[0]).join(''));
            }
        });
    }
    return initials;
}

export const areUsersLoaded = ()=>{
    const usersTable = document.querySelector('.pop-up__users');
    return usersTable.hasChildNodes();
}