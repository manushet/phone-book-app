document.addEventListener('DOMContentLoaded', function () {
    fetchContacts();

    document.getElementById('addContactForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        addContact(name, phoneNumber);
    });

    function fetchContacts() {
        fetch('http://localhost:8080/', {
            method: 'GET',
            headers: { 
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log(response);
            return response.json();
        })
        .then(contacts => {
            displayContacts(contacts);
        });
    }

    function addContact(name, phoneNumber) {
        fetch('http://127.0.0.1:8080/contact', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, phoneNumber })
        })
        .then(() => {
            fetchContacts(); 
            document.getElementById('addContactForm').reset(); 
        });
    }

    function displayContacts(contacts) {
        console.log(contacts);
        
        const contactListTable = document.getElementById('contactListTable');
        contactListTable.innerHTML = ''; 

        let i = 1;
        contacts.forEach((contact, index) => {
            const tr = document.createElement('tr');

            const td1 = document.createElement('td');
            td1.textContent = i;
            tr.appendChild(td1);

            const td2 = document.createElement('td');
            td2.textContent = contact.name;
            tr.appendChild(td2);

            const td3 = document.createElement('td');
            td3.textContent = contact.originalPhoneNumber;
            tr.appendChild(td3);

            const deleteBtn = document.createElement('button');
            deleteBtn.type = "button";
            deleteBtn.classList.add("btn", "btn-danger", "delete-contact");
            deleteBtn.textContent = 'Delete';
            deleteBtn.onclick = () => deleteContact(contact.phoneNumber);

            const td4 = document.createElement('td');
            td4.classList.add('text-end')
            td4.appendChild(deleteBtn);
            tr.appendChild(td4);

            contactListTable.appendChild(tr);

            i++;
        });
    }

    function deleteContact(phoneNumber) {
        fetch('http://127.0.0.1:8080/contact', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phoneNumber })
        })
        .then(() => {
            fetchContacts(); 
        });
    }
});