document.getElementById('name').addEventListener('input', function() {
    const nameLength = this.value.length;
    const feedback = document.getElementById('nameFeedback');

    if (nameLength > 0 && nameLength < 3) {
        feedback.textContent = 'Name is too short';
    } else {
        feedback.textContent = '';
    }
});

document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    const feedback = document.getElementById('emailFeedback');

    if (!email) {
        feedback.textContent = 'Email is required';
        return;
    }

    // Эмуляция асинхронного API-запроса для проверки занятости email
    feedback.textContent = 'Checking email...';
    setTimeout(() => {
        if (email === 'test@example.com') {
            feedback.textContent = 'This email is already taken';
        } else {
            feedback.textContent = '';
        }
    }, 1000);
});

document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    let errors = [];

    if (!name || name.length < 3) {
        errors.push("Name must be at least 3 characters long");
    }

    if (!email || !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
        errors.push("Invalid email format");
    }

    if (password.length < 6) {
        errors.push("Password must be at least 6 characters long");
    }

    if (errors.length > 0) {
        alert(errors.join("\n"));
    } else {
        // Отправляем форму, если ошибок нет
        this.submit();
    }
});