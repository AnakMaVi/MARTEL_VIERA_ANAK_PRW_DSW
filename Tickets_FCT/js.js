const apiBaseUrl = 'http://localhost/TICKETS_FCT/Respuestas.php';

// Obtener todos los usuarios
function getAllUsers() {
    return fetch(`${apiBaseUrl}?action=GET_ALL_USERS`)
        .then(response => response.json());
}

// Crear usuario
function createUser(userData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...userData, action: 'CREATE_USER' })
    }).then(response => response.json());
}

// Actualizar usuario
function updateUser(userId, userData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: userId, ...userData, action: 'UPDATE_USER' })
    }).then(response => response.json());
}

// Eliminar usuario
function deleteUser(userId) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId, action: 'DELETE_USER' })
    }).then(response => response.json());
}


// Obtener todas las peticiones
function getAllPetitions() {
    return fetch(`${apiBaseUrl}?action=GET_ALL_PETITIONS`)
        .then(response => response.json());
}

// Crear petición
function createPetition(petitionData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...petitionData, action: 'CREATE_PETITION' })
    }).then(response => response.json());
}

// Actualizar petición
function updatePetition(petitionId, petitionData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: petitionId, ...petitionData, action: 'UPDATE_PETITION' })
    }).then(response => response.json());
}

// Eliminar petición
function deletePetition(petitionId) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ petitionId, action: 'DELETE_PETITION' })
    }).then(response => response.json());
}


// Obtener todas las salas
function getAllClassrooms() {
    return fetch(`${apiBaseUrl}?action=GET_ALL_CLASSROOMS`)
        .then(response => response.json());
}

// Crear sala
function createClassroom(classroomData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...classroomData, action: 'CREATE_CLASSROOM' })
    }).then(response => response.json());
}

// Actualizar sala
function updateClassroom(classroomId, classroomData) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: classroomId, ...classroomData, action: 'UPDATE_CLASSROOM' })
    }).then(response => response.json());
}

// Eliminar sala
function deleteClassroom(classroomId) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ classroomId, action: 'DELETE_CLASSROOM' })
    }).then(response => response.json());
}


// Obtener todos los tokens
function getAllTokens() {
    return fetch(`${apiBaseUrl}?action=GET_ALL_TOKENS`)
        .then(response => response.json());
}

// Crear token
function createToken() {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'CREATE_TOKEN' })
    }).then(response => response.json());
}

// Eliminar token
function deleteToken(tokenId) {
    return fetch(apiBaseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tokenId, action: 'DELETE_TOKEN' })
    }).then(response => response.json());
}
