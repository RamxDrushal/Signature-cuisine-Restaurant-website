let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
}

document.querySelectorAll('input[type="number"]').forEach(input =>{
    input.oniput = () =>{
        if(input.value.length > input.maxlength) input.value = input.value.slice (0, input.maxlength);
    }

});