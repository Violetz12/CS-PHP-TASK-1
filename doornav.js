document.addEventListener('DOMContentLoaded', () => {
    const doors = document.querySelectorAll('.door');
    
    doors.forEach(door => {
        door.addEventListener('click', () => {
            switch(door.id) {
                case 'door1':
                    window.location.href = 'room1.html';
                    break;
                case 'door2':
                    window.location.href = 'room2.html';
                    break;
                case 'door3':
                    window.location.href = 'room3.html';
                    break;
            }
        });
    });
});