// JavaScript для управления формами
document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.querySelector('#login-form');
  const registrationForm = document.querySelector('#registration-form');

  loginForm.addEventListener('submit', (event) => {
    event.preventDefault(); 

    const username = loginForm.querySelector('input[name="username"]').value;
    const password = loginForm.querySelector('input[name="password"]').value;

    fetch('login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username: username, password: password }),
    })
    .then(response => {
      if (response.ok) {
        return response.json();
      }
      throw new Error('Network response was not ok.');
    })
    .then(data => {
      window.location.href = '../news/news.php';
    })
    .catch(error => {
      console.error('There has been a problem with your fetch operation:', error);
    });
  });

  registrationForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const formData = new FormData(registrationForm);

    fetch('register.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => {
      if (response.ok) {
        return response.json();
      }
      throw new Error('Network response was not ok.');
    })
    .then(data => {
      console.log('Registration successful:', data);
    })
    .catch(error => {
      console.error('There has been a problem with your fetch operation:', error);
    });
  });
});
